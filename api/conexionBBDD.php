<?php
$conn_str= "postgres://neondb_owner:npg_do47QlhJBNcC@ep-holy-firefly-a26hg6mf-pooler.eu-central-1.aws.neon.tech/neondb?sslmode=require";

$link = pg_connect($conn_str);

if (!$link) {
    die('Error de conexión: ' . pg_last_error());
}

pg_set_client_encoding($link,"UTF8");
echo "GOOD";