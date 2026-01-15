<?php
// Eliminar registros por tropa: borra en registroingresos (resumen) y ingresos (detalle)
header('Content-Type: application/json');
require_once dirname(__DIR__, 2) . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'msg' => 'Método inválido']);
    exit;
}

$tropa = isset($_POST['tropa']) ? trim((string)$_POST['tropa']) : '';
if ($tropa === '') {
    echo json_encode(['ok' => false, 'msg' => 'Tropa inválida']);
    exit;
}

if (empty($_SESSION['logged'])) {
    echo json_encode(['ok' => false, 'msg' => 'No autenticado']);
    exit;
}

$feedlot = $_SESSION['feedlot'] ?? '';
$conexion = db();
if (!($conexion instanceof mysqli)) {
    echo json_encode(['ok' => false, 'msg' => 'Sin conexión DB']);
    exit;
}

$t = $conexion->real_escape_string($tropa);
$f = $conexion->real_escape_string((string)$feedlot);

$conexion->begin_transaction();
try {
    // Borrar detalle uno-a-muchos
    $sqlDelDet = "DELETE FROM ingresos WHERE tropa = '$t' AND feedlot = '$f'";
    if(!$conexion->query($sqlDelDet)) { throw new Exception('Error al eliminar detalle ingresos'); }

    // Borrar resumen registroingresos
    $sqlDelReg = "DELETE FROM registroingresos WHERE tropa = '$t' AND feedlot = '$f'";
    if(!$conexion->query($sqlDelReg)) { throw new Exception('Error al eliminar registro de ingresos'); }

    $conexion->commit();
    echo json_encode(['ok' => true]);
} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(['ok' => false, 'msg' => $e->getMessage()]);
}
