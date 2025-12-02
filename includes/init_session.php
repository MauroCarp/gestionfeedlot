<?php
// Inicialización de sesión segura (evita doble session_start)
if (!defined('APP_SESSION_INIT')) {
	define('APP_SESSION_INIT', true);
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
}

// No forzar redirección aquí: protección centralizada en Router.
if(!array_key_exists('logged', $_SESSION)){
	// Dejar variables vacías; Router decidirá si redirigir.
	$feedlot = '';
	$tipoSesion = '';
} else {
	$feedlot = $_SESSION['feedlot'] ?? '';
	$tipoSesion = $_SESSION['tipo'] ?? '';
}

$fechaDeHoy = date("d-m-Y");
$feedlot = $_SESSION['feedlot'] ?? ($feedlot ?? '');
?>