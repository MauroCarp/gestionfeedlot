<?php
namespace App\Http\Controllers;

use App\Services\AuthService;

class LoginController {
    protected \mysqli $conexion;
    public function __construct(){
        if(function_exists('db')){ $this->conexion = db(); } else { $this->conexion = new \mysqli('localhost','root','','feedlot'); }
    }

    public function index(): void {
        // Si ya logueado redirigir
        if(!empty($_SESSION['logged'])) { header('Location: '.route_url('home')); return; }
        layout_view('auth/login',[ 'title'=>'Ingresar' ]);
    }

    public function authenticate(): void {
        $user = $_POST['ingUsuario'] ?? '';
        $pass = $_POST['ingPassword'] ?? '';
        $svc = new AuthService($this->conexion);
        $result = $svc->attempt($user,$pass);
        if(!$result['ok']){
            $_SESSION['flash'][] = ['ok'=>false,'seccion'=>'login','msg'=>$result['msg']];
            header('Location: '.route_url('login')); return;
        }
        $_SESSION['logged'] = true;
        $_SESSION['feedlot'] = $result['feedlot'];
        $_SESSION['usuario'] = $result['user'];
        $_SESSION['tipo'] = $result['tipo'];
        setcookie('feedlot',$result['feedlot'], time()+86400);
        setcookie('tipo',$result['tipo'], time()+86400);
        $_SESSION['flash'][] = ['ok'=>true,'seccion'=>'login','msg'=>'Acceso correcto'];
        header('Location: '.route_url('home'));
    }
}
