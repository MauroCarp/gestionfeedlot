<?php
namespace App\Http\Controllers;

class HomeController {
    public function index() {
        global $conexion, $feedlot;
        
        $data = [
            'title' => 'Inicio',
            'feedlot' => $feedlot,
            'conexion' => $conexion
        ];
        layout_view('home', $data);
    }
}
