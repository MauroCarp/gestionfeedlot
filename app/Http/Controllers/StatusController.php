<?php
namespace App\Http\Controllers;

class StatusController {
    public function index() {
        global $conexion, $feedlot, $fechaDeHoy;
        
        // Backend lógico existente
        require __DIR__ . '/../../../backend/status.backend.php';
        
        $data = [
            'title' => 'Status Sanitario',
            'feedlot' => $feedlot ?? '',
            'fechaDeHoy' => $fechaDeHoy ?? date("d-m-Y"),
            'conexion' => $conexion
        ];
        
        layout_view('status', $data);
    }
}
