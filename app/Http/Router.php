<?php
namespace App\Http;

class Router {
    protected static array $routes = [
        'home' => [\App\Http\Controllers\HomeController::class, 'index'],
        'stock' => [\App\Http\Controllers\StockController::class, 'index'],
        'status' => [\App\Http\Controllers\StatusController::class, 'index'],
        'raciones' => [\App\Http\Controllers\RacionesController::class, 'index'],
        'usuarios' => [\App\Http\Controllers\UsuariosController::class, 'index'],
        'ingresos' => [\App\Http\Controllers\IngresosController::class, 'index'],
        'egresos' => [\App\Http\Controllers\EgresosController::class, 'index'],
        'muertes' => [\App\Http\Controllers\MuertesController::class, 'index'],
        'api' => [\App\Http\Controllers\ApiController::class, 'index'],
        'login' => [\App\Http\Controllers\LoginController::class, 'index'],
        'login.auth' => [\App\Http\Controllers\LoginController::class, 'authenticate'],
        'logout' => [\App\Http\Controllers\LogoutController::class, 'index'],
    ];

    protected static array $protectedRoutes = [
        'home','stock','status','raciones','usuarios','ingresos','egresos','muertes','api'
    ];

    public static function add(string $name, string $controllerClass, string $method = 'index'): void {
        self::$routes[$name] = [$controllerClass, $method];
    }

    public static function dispatch(string $route): bool {
        if(!isset(self::$routes[$route])) {
            return false;
        }
        [$controllerClass, $method] = self::$routes[$route];
        // Protección de rutas: redirigir si no autenticado
        if(in_array($route, self::$protectedRoutes, true) && empty($_SESSION['logged'])) {
            header('Location: '.(function_exists('route_url')? route_url('login') : 'login.php'));
            return true;
        }
        if(!class_exists($controllerClass)) {
            return false;
        }
        $controller = new $controllerClass();
        if(!method_exists($controller, $method)) {
            return false;
        }
        $controller->$method();
        return true;
    }
}
