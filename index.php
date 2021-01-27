<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");



require_once 'app\services\Router.php';

/*
* Парсим адресную строку и отбираем параметры
*/

$type = explode('/', $_GET['q']);


route($_SERVER['REQUEST_METHOD'], $type);

?>