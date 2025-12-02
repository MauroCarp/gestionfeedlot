<?php
namespace App\Http\Controllers;

use App\Services\IngresosService;

class IngresosController {
    public function index(): void {
        if(!isset($_SESSION['usuario'])) { header('Location: index.php'); exit; }
        $feedlot = $_SESSION['feedlot'] ?? '';
        $fechaHoy = date('Y-m-d');
        $service = new IngresosService($GLOBALS['conexion']);
        $totales = $service->totales($feedlot, $fechaHoy);
        $page = isset($_GET['page']) ? max(0,(int)$_GET['page']) : 0;
        $perPage = 12;
        $listado = $service->listar($feedlot, $page, $perPage);
        $totalPages = $service->totalPaginas($feedlot, $perPage);
        $data = [
            'title' => 'Ingresos',
            'feedlot' => $feedlot,
            'fechaDeHoy' => date('d-m-Y'),
            'cantIng' => $totales['cantIng'],
            'pesoTotalIng' => $totales['pesoTotalIng'],
            'kgIngProm' => $totales['kgIngProm'],
            'kgMinIng' => $totales['kgMinIng'],
            'kgMaxIng' => $totales['kgMaxIng'],
            'listado' => $listado,
            'page' => $page,
            'totalPages' => $totalPages,
        ];
        layout_view('ingresos', $data);
    }
}
