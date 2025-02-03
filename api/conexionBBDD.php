<?php

$Repit=false;
$str_con="postgres://neondb_owner:npg_do47QlhJBNcC@ep-holy-firefly-a26hg6mf-pooler.eu-central-1.aws.neon.tech/neondb?sslmode=require";

$link= pg_connect($str_con);
pg_set_client_encoding($link,"UTF8");
