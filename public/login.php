<?php
// Bridge /public/login.php -> front controller sin loop.
// Evitar usar route_url aquí porque devuelve solo '?route=login' y repite login.php.
require_once dirname(__DIR__) . '/bootstrap.php';
header('Location: index.php?route=login');
exit;
