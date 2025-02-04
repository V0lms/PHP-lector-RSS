<?php
$host = getenv('PGHOST');
$db = getenv('PGDATABASE');
$user = getenv('PGUSER');
$password = getenv('PGPASSWORD');
$sslmode = getenv('PGSSLMODE');

$link = pg_connect("host=$host dbname=$db user=$user password=$password sslmode=$sslmode");

if (!$link) {
    die('Error de conexión: ' . pg_last_error());
}
