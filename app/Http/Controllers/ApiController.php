<?php
namespace App\Http\Controllers;

class ApiController {
    public function index(): void {
        header('Content-Type: application/json; charset=utf-8');
        $action = isset($_GET['action']) ? preg_replace('/[^a-zA-Z0-9_]/','',$_GET['action']) : '';
        $base = dirname(__DIR__,3); // raiz del proyecto
        $legacyMap = [
            'status' => $base . '/backend/status.backend.php',
            'stock' => $base . '/backend/stock.backend.php',
            'raciones' => $base . '/backend/raciones.backend.php',
            'usuarios' => $base . '/backend/usuarios.backend.php',
        ];
        if(!$action || !isset($legacyMap[$action])) {
            http_response_code(404);
            echo json_encode(['error' => 'Accion no encontrada']);
            return;
        }
        // Capturar salida legacy y devolverla como payload transitorio
        ob_start();
        include $legacyMap[$action];
        $raw = ob_get_clean();
        // Intentar detectar JSON ya emitido
        $decoded = json_decode($raw, true);
        if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            echo json_encode(['data' => $decoded]);
        } else {
            echo json_encode(['html' => $raw]);
        }
    }
}
