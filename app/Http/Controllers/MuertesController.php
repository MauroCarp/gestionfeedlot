<?php
namespace App\Http\Controllers;

use App\Services\MuertesService;

class MuertesController {
    public function index(): void {
        if(!isset($_SESSION['usuario'])) { header('Location: index.php'); exit; }
        $feedlot = $_SESSION['feedlot'] ?? '';
        $fechaHoy = date('Y-m-d');
        $service = new MuertesService($GLOBALS['conexion']);
        $totales = $service->totales($feedlot, $fechaHoy);
        $causas = $service->causas($feedlot);
        // Preparar datos para gráfico (labels y counts)
        $chartLabels = array_map(fn($r) => $r['causaMuerte'], $causas);
        $chartCounts = array_map(fn($r) => (int)$r['total'], $causas);
        $data = [
            'title' => 'Muertes',
            'feedlot' => $feedlot,
            'fechaDeHoy' => date('d-m-Y'),
            'cantMuertes' => $totales['cantMuertes'],
            'chartLabels' => $chartLabels,
            'chartCounts' => $chartCounts,
        ];
        layout_view('muertes', $data);
    }
}
