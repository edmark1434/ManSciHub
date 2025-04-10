<?php
require_once "api/core/Router.php";

    header("Content-Type: application/json");
    header('Access-Control-Allow-Origin: *'); 
    $router = new Router();
    $router->route();
?>