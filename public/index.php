<?php
// Front controller ubicado en public/
require_once __DIR__ . '/../bootstrap.php';

use App\Http\Router;

$route = $_GET['route'] ?? (empty($_SESSION['logged']) ? 'login' : 'home');

if(!Router::dispatch($route)) {
    http_response_code(404);
    echo '<div class="container"><h2>404 - Ruta no encontrada</h2></div>';
}

// Flush buffer si se inició en bootstrap
if (function_exists('ob_get_level') && ob_get_level() > 0) { @ob_end_flush(); }
