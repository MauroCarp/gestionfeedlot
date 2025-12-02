<?php
namespace App\Http\Controllers;

class LogoutController {
    public function index(): void {
        if(session_status() === PHP_SESSION_NONE) { session_start(); }
        $_SESSION = [];
        if(isset($_COOKIE['feedlot'])) { setcookie('feedlot','',time()-3600); }
        if(isset($_COOKIE['tipo'])) { setcookie('tipo','',time()-3600); }
        session_destroy();
        if(function_exists('route_url')) {
            header('Location: '.route_url('login'));
        } else {
            header('Location: login.php');
        }
    }
}
