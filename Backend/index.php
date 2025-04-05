<?php
require_once "api/core/Router.php";

    header("Content-Type: application/json");
    $router = new Router();
    $router->route();
?>