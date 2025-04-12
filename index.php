<?php
require_once "api/core/Router.php";

    header("Content-Type: application/json");
    header('Access-Control-Allow-Origin: *'); 
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

    // Handle OPTIONS request (preflight check)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Send 200 OK for OPTIONS preflight request
    http_response_code(200);
    exit; // No further processing needed
}

    $router = new Router();
    $router->route();
?>