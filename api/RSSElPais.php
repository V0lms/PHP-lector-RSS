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

$sXML = download("http://ep00.epimg.net/rss/elpais/portada.xml");
$oXML = new SimpleXMLElement($sXML);

if (!$link) {
    die("Conexión a la base de datos ha fallado.");
} else {
    $contador = 0;
    $categorias = ["Política", "Deportes", "Ciencia", "España", "Economía", "Música", "Cine", "Europa", "Justicia"];
    $categoriaFiltro = "";

    foreach ($oXML->channel->item as $item) {
        $categoriaFiltro = ""; // Reiniciar en cada iteración
        
        foreach ($item->category as $cat) {
            if (in_array((string)$cat, $categorias)) {
                $categoriaFiltro .= "[" . $cat . "]";
            }
        }

        $fPubli = strtotime($item->pubDate);
        $new_fPubli = date('Y-m-d', $fPubli);
        $content = $item->children("content", true);
        $encoded = isset($content->encoded) ? (string)$content->encoded : '';

        // Verificar si el enlace ya existe
        $check_query = "SELECT 1 FROM elpais WHERE link = $1";
        $check_result = pg_query_params($link, $check_query, [(string)$item->link]);

        if (pg_num_rows($check_result) == 0 && $categoriaFiltro !== "") {
            // Inserción de la noticia
            $insert_query = "INSERT INTO elpais (title, link, description, categoria, fecha_publi, contenido) 
                             VALUES ($1, $2, $3, $4, $5, $6)";

            $params = [
                (string)$item->title,
                (string)$item->link,
                (string)$item->description,
                $categoriaFiltro,
                $new_fPubli,
                $encoded
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
