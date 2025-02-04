<?php

$Repit = false;
$link = pg_connect("host=ep-holy-firefly-a26hg6mf-pooler.eu-central-1.aws.neon.tech dbname=neondb user=neondb_owner password=npg_do47QlhJBNcC");

if (!$link) {
    die('Error: ' . pg_last_error());
}

pg_set_client_encoding($link, "UTF8");
echo "Conexión exitosa";