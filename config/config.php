<?php

define('host', 'localhost');
define('user', 'root');
define('password', '');
define('database', 'agenda');
define('app_name', 'SIS | CITAS');
define('app_url', 'http://localhost/agenda2');
define('BASE_PATH', dirname(__DIR__));

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fechaHora = date('Y-m-d H:i:s');

$fechaActual = date('Y-m-d');
$diaActual = date('d');
$mes = date('m');
$anio = date('Y');
