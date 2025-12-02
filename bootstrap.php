<?php
// bootstrap.php: punto único de arranque
// Iniciar buffering para permitir header() después de salida parcial durante migración
if (!headers_sent()) { ob_start(); }
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/funciones.php';
require_once __DIR__ . '/includes/init_session.php';
// Composer autoload (si se agrega PSR-4)
$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require_once $autoload;
}
// Helper para cargar vistas simples
function view($name, $data = []) {
    $file = __DIR__ . '/resources/views/' . $name . '.php';
    if (!file_exists($file)) {
        http_response_code(500);
        echo 'Vista no encontrada: ' . htmlspecialchars($name);
        return;
    }
    extract($data, EXTR_SKIP);
    include $file;
}

// Helper de assets: ajusta path relativo si estamos dentro de /public
function asset(string $path): string {
    $clean = ltrim($path,'/');
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $inPublic = strpos($script, '/public/') !== false;
    $rootFs = dirname(__FILE__);
    $publicFs = $rootFs . '/public/' . $clean;
    $legacyFs = $rootFs . '/' . $clean;
    // Base URL calculada a partir del script actual
    $scriptDir = rtrim(str_replace('\\','/',dirname($script)),'/'); // ej /gestionfeedlot/public
    if ($inPublic) {
        $baseUrl = $scriptDir; // /gestionfeedlot/public
    } else {
        $baseUrl = $scriptDir . '/public'; // /gestionfeedlot + /public
    }
    // Preferir archivo en public
    if (file_exists($publicFs)) {
        return $baseUrl . '/' . $clean; // devolver ruta absoluta relativa al host
    }
    // Compat: archivo aún en raíz del proyecto
    if (file_exists($legacyFs)) {
        return $inPublic ? $scriptDir . '/../' . $clean : $scriptDir . '/' . $clean;
    }
    // Fallback: apuntar a public aunque no exista (para visualizar 404 en consola)
    return $baseUrl . '/' . $clean;
}

// Genera URL para rutas MVC (front controller en public/index.php)
function route_url(string $route): string {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $inPublic = strpos($script, '/public/') !== false;
    // Construir siempre referencia explícita a index.php para evitar bucles de query relativa
    return $inPublic ? 'index.php?route=' . urlencode($route) : 'public/index.php?route=' . urlencode($route);
}

// Render con layout: incluye head y luego la vista como contenido
function layout_view(string $name, array $data = []): void {
    $file = __DIR__ . '/resources/views/' . $name . '.php';
    if (!file_exists($file)) {
        http_response_code(500);
        echo 'Vista no encontrada: ' . htmlspecialchars($name);
        return;
    }
    extract($data, EXTR_SKIP);
    // Exponer conexion legacy dentro del scope de funcion para includes procedurales
    global $conexion;
    if (!isset($conexion) || !($conexion instanceof \mysqli)) {
        $conexion = db();
    }
    // head abre <html><body> y nav
    require __DIR__ . '/resources/views/partials/head.php';
    echo "\n<div class=\"container\">"; // wrapper principal como en legacy
    // Mensajes flash
    if(!empty($_SESSION['flash']) && is_array($_SESSION['flash'])) {
        foreach($_SESSION['flash'] as $flash) {
            $ok = $flash['ok'] ?? false;
            $msg = htmlspecialchars($flash['msg'] ?? '');
            $sec = htmlspecialchars($flash['seccion'] ?? '');
            $class = $ok ? 'alert-success' : 'alert-danger';
            echo "<div class='alert $class'><strong>".$sec."</strong> - $msg</div>";
        }
        unset($_SESSION['flash']);
    }
    include $file;
    echo "\n</div>\n  </body>\n</html>"; // cerrar documento
}
