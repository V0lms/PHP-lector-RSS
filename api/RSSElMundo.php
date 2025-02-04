<?php
require_once "conexionRSS.php";

function download($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

$sXML = download("https://e00-elmundo.uecdn.es/elmundo/rss/espana.xml");
$oXML = new SimpleXMLElement($sXML);

if (!$link) {
    die("Conexión a la base de datos ha fallado.");
} else {
    $contador = 0;
    $categorias = ["Política", "Deportes", "Ciencia", "España", "Economía", "Música", "Cine", "Europa", "Justicia"];
    $categoriaFiltro = "";

    foreach ($oXML->channel->item as $item) {
        $categoriaFiltro = ""; // Reiniciar categorías en cada iteración
        
        // Filtrar categorías relevantes
        foreach ($item->category as $cat) {
            if (in_array((string)$cat, $categorias)) {
                $categoriaFiltro .= "[" . $cat . "]";
            }
        }

        $fPubli = strtotime($item->pubDate);
        $new_fPubli = date('Y-m-d', $fPubli);

        $media = $item->children("media", true);
        $description = isset($media->description) ? (string)$media->description : (string)$item->description;

        // Verificar si el enlace ya existe en la base de datos
        $check_query = "SELECT 1 FROM elmundo WHERE link = $1";
        $check_result = pg_query_params($link, $check_query, [(string)$item->link]);

        if (pg_num_rows($check_result) == 0 && $categoriaFiltro !== "") {
            // Insertar la noticia en la base de datos
            $insert_query = "INSERT INTO elmundo (title, link, description, categoria, fecha_publi, guid) 
                             VALUES ($1, $2, $3, $4, $5, $6)";

            $params = [
                (string)$item->title,
                (string)$item->link,
                $description,
                $categoriaFiltro,
                $new_fPubli,
                (string)$item->guid
            ];

            $insert_result = pg_query_params($link, $insert_query, $params);

            if ($insert_result) {
                echo "Noticia insertada: " . $item->title . "<br>";
            } else {
                echo "Error al insertar noticia: " . pg_last_error($link) . "<br>";
            }
        }
    }
}
?>
