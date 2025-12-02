<?php
namespace App\Http\Controllers;

use App\Services\EgresosService;

class EgresosController {
    public function index(): void {
        if(!isset($_SESSION['usuario'])) { header('Location: index.php'); exit; }
        $feedlot = $_SESSION['feedlot'] ?? '';
        $fechaHoy = date('Y-m-d');
        $service = new EgresosService($GLOBALS['conexion']);
        $totales = $service->totales($feedlot, $fechaHoy);
        $data = [
            'title' => 'Egresos',
            'feedlot' => $feedlot,
            'fechaDeHoy' => date('d-m-Y'),
            'cantEgr' => $totales['cantEgr'],
            'pesoTotalEgr' => $totales['pesoTotalEgr'],
            'kgEgrProm' => $totales['kgEgrProm'],
            'kgMinEgr' => $totales['kgMinEgr'],
            'kgMaxEgr' => $totales['kgMaxEgr'],
        ];
        layout_view('egresos', $data);
    }
}
