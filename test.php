<?php

date_default_timezone_set("UTC");

// set current date less 15 days (field CreatedAfter)
$now = new DateTime();
$fecha = $now->format(DateTime::ISO8601);
echo date_create($fecha)->modify('-15 days')->format('Y-m-d');


        
