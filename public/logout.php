<?php
// Compatibilidad legacy: acceder a /public/logout.php
require_once dirname(__DIR__) . '/bootstrap.php';
header('Location: index.php?route=logout');
exit;
