<?php

$Repit = false;


// Cadena de conexión
$conn_string = "postgres://default:DlC2mcJFxIr4@ep-yellow-dust-a7l7gm6q.ap-southeast-2.aws.neon.tech:5432/verceldb?sslmode=require";

// Conectar a PostgreSQL
$link = pg_connect($conn_string);

if (!$link) {
    die("Error en la conexión: " . pg_last_error());
}

// Configurar codificación de caracteres a UTF8
pg_set_client_encoding($link, "UTF8");

echo "Conexión a PostgreSQL exitosa.";

// Aquí puedes ejecutar tus consultas SQL

// Ejemplo: Ejecutar una consulta
// $result = pg_query($link, "SELECT * FROM tu_tabla");
// while ($row = pg_fetch_assoc($result)) {
//     echo $row['nombre_columna'];
// }

// Cierra la conexión cuando termines
// pg_close($link);
?>
