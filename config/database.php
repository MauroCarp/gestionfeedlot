<?php
// Nueva capa de acceso a datos centralizada
// Mantiene compatibilidad creando funcion db() y variable $conexion cuando se incluye desde legacy

class Database {
    private static ?\mysqli $instance = null;

    public static function connection(): \mysqli {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: 'localhost';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASS') ?: '';
            $name = getenv('DB_NAME') ?: 'feedlot';
            $conn = @new \mysqli($host, $user, $pass, $name);
            if ($conn->connect_errno) {
                // Lanzar excepcion controlada (legacy espera $conexion, asi que solo logueamos)
                error_log('[Database] Error de conexion: ' . $conn->connect_error);
            }
            self::$instance = $conn;
        }
        return self::$instance;
    }
}

function db(): \mysqli {
    return Database::connection();
}

// Compatibilidad con codigo existente que usa $conexion global
if (!isset($conexion)) {
    $conexion = db();
}
