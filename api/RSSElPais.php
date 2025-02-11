<?php

require_once "conexionRSS.php";

$sXML = download("https://feeds.elpais.com/mrss-s/pages/ep/site/elpais.com/portada");

$oXML = new SimpleXMLElement($sXML);

require_once "conexionBBDD.php";

if (false) {
    echo "Conexión a el periódico El País ha fallado";
} else {

    $contador = 0;
    $categoria = ["Política", "Deportes", "Ciencia", "España", "Economía", "Música", "Cine", "Europa", "Justicia"];
    $categoriaFiltro = "";

    foreach ($oXML->channel->item as $item) {

        for ($i = 0; $i < count($item->category); $i++) {

            for ($j = 0; $j < count($categoria); $j++) {

                if ($item->category[$i] == $categoria[$j]) {
                    $categoriaFiltro = "[" . $categoria[$j] . "]" . $categoriaFiltro;
                }
            }
        }



        $fPubli = strtotime($item->pubDate);
        $new_fPubli = date('Y-m-d', $fPubli);


        $content = $item->children("content", true);
        $encoded = $content->encoded;


        $sql = "SELECT link FROM elpais";
        $result = pg_query($link, $sql);
        $Repit = true;

        while ($sqlCompara = pg_fetch_array($result)) {


            if ($sqlCompara['link'] == $item->link) {

                $Repit = true;
                $contador = $contador + 1;
                $contadorTotal = $contador;
                break;
            } else {
                $Repit = false;
            }
        }
        if ($Repit == false && $categoriaFiltro <> "") {

            $sql = "INSERT INTO elpais VALUES('','$item->title','$item->link','$item->description','$categoriaFiltro','$new_fPubli','$encoded')";
            $result = pg_query($link, $sql);
        }

        $categoriaFiltro = "";
    }
}
