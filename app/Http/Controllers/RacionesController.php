<?php
namespace App\Http\Controllers;

class RacionesController {
    public function index() {
        global $conexion, $feedlot, $fechaDeHoy;
        
        // Backend lógico existente
        require __DIR__ . '/../../../backend/raciones.backend.php';
        
        $data = [
            'title' => 'Raciones',
            'feedlot' => $feedlot ?? '',
            'fechaDeHoy' => $fechaDeHoy ?? date("d-m-Y"),
            'seccion' => $seccion ?? '',
            'accionValido' => $accionValido ?? false,
            'accion' => $accion ?? ''
        ];
        
        layout_view('raciones', $data);
    }
}
