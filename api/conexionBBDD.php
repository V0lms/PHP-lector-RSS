<?php

$Repit=false;
$host="ep-holy-firefly-a26hg6mf-pooler.eu-central-1.aws.neon.tech";
$user="neondb_owner";
$password="npg_do47QlhJBNcC";

$link= mysqli_connect($host,$user,$password);
$tildes=$link->query("SET NAMES 'utf8'");
mysqli_select_db($link,'neondb');