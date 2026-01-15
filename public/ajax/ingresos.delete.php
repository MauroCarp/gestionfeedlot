<?php
// Eliminar un registro de ingresos (registroingresos) via AJAX
// Respuesta JSON
header('Content-Type: application/json');
require_once dirname(__DIR__, 2) . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'msg' => 'Método inválido']);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    echo json_encode(['ok' => false, 'msg' => 'ID inválido']);
    exit;
}

// Seguridad básica: requerir sesión
if (empty($_SESSION['logged'])) {
    echo json_encode(['ok' => false, 'msg' => 'No autenticado']);
    exit;
}

$conexion = db();
if (!($conexion instanceof mysqli)) {
    echo json_encode(['ok' => false, 'msg' => 'Sin conexión DB']);
    exit;
}

// Verificar existencia
$sqlSel = "SELECT id FROM registroingresos WHERE id = $id LIMIT 1";
$qSel = $conexion->query($sqlSel);
if (!$qSel || $qSel->num_rows === 0) {
    echo json_encode(['ok' => false, 'msg' => 'Registro no encontrado']);
    exit;
}

// Eliminar
$sqlDel = "DELETE FROM registroingresos WHERE id = $id";
if (!$conexion->query($sqlDel)) {
    echo json_encode(['ok' => false, 'msg' => 'Error al eliminar']);
    exit;
}

echo json_encode(['ok' => true]);
