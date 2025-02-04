<?php
$Repit = false;
$conn_string = "host=ep-holy-firefly-a26hg6mf-pooler.eu-central-1.aws.neon.tech dbname=neondb user=neondb_owner password=npg_do47QlhJBNcC sslmode=require";
$link = pg_connect($conn_string);

if (!$link) {
    die('Error: ' . pg_last_error());
}

pg_set_client_encoding($link, "UTF8");
echo "Conexión exitosa";
?>
