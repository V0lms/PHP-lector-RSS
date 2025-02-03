<?php

$Repit=false;
$host="postgres://neondb_owner:npg_ito4ZxOywzF7@ep-autumn-feather-a25rwmok-pooler.eu-central-1.aws.neon.tech/neondb?sslmode=require";

$link= mysqli_connect($host);
$tildes=$link->query("SET NAMES 'utf8'");
mysqli_select_db($link,'periodicos');