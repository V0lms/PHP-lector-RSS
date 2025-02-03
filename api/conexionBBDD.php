<?php
$Repit=false;
$link= mysqli_connect('postgres://neondb_owner:npg_do47QlhJBNcC@ep-holy-firefly-a26hg6mf-pooler.eu-central-1.aws.neon.tech/neondb?sslmode=require');
$tildes=$link->query("SET NAMES 'utf8'");
mysqli_select_db($link,'periodicos');
