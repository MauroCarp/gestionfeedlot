<?php
namespace App\Http\Controllers;

use App\Services\StockService;
use App\Services\IngresosService;
use App\Services\ReferenceService;

class StockController {
    protected StockService $service;
    protected \mysqli $conexion;

    public function __construct() {
        $this->service = new StockService();
        // Usa funcion db() expuesta por config/database.php
        if(function_exists('db')) {
            $this->conexion = db();
        } else {
            $this->conexion = new \mysqli('localhost','root','','feedlot');
        }
    }

    public function index(): void {
        $feedlot = $_SESSION['feedlot'] ?? '';
        $seccion = $_GET['seccion'] ?? '';
        // Manejo de acciones CRUD antes de renderizar
        if(isset($_REQUEST['accion'])) {
            $accion = $_REQUEST['accion'];
            $this->handleAccion($accion, $feedlot);
            return; // Los handlers redirigen
        }

        $fechaDeHoy = date('d-m-Y');
        $totals = $this->service->computeTotals($feedlot, $this->conexion);
        // Listado de registroingresos para tabla DataTables en Stock
        $ingService = new IngresosService($this->conexion);
        $listado = $ingService->listar($feedlot, 0, 1000);
        $ref = new ReferenceService($this->conexion);
        $razasIng = $ref->razas($feedlot);
        $origenesIng = $ref->origenes($feedlot,'ingresos');
        $destinosIng = $ref->destinos($feedlot,'ingresos');
        // Egresos y Muertes referencias
        $destinosEgr = $ref->destinos($feedlot,'egresos');
        $causasMuerte = $ref->causasMuertes($feedlot);
        $data = array_merge($totals, [
            'title' => 'Stock',
            'feedlot' => $feedlot,
            'fechaDeHoy' => $fechaDeHoy,
            'seccion' => $seccion === '' ? 'ingreso' : $seccion,
            'conexion' => $this->conexion,
            'listado' => $listado,
            'razasIngresos' => $razasIng,
            'origenesIngresos' => $origenesIng,
            'destinosIngresos' => $destinosIng,
            'destinosEgresos' => $destinosEgr,
            'causasMuertesRef' => $causasMuerte,
        ]);
        layout_view('stock', $data);
    }

    private function redirect(string $seccion): void {
        header('Location: public/index.php?route=stock&seccion=' . urlencode($seccion));
        exit;
    }

    private function handleAccion(string $accion, string $feedlot): void {
        switch($accion) {
            case 'egreso':
                $this->accionEgreso($feedlot);
                break;
            case 'eliminarEgreso':
                $this->accionEliminarEgreso($feedlot);
                break;
            case 'muertes':
                $this->accionMuertes($feedlot);
                break;
            case 'eliminarMuerte':
                $this->accionEliminarMuerte($feedlot);
                break;
            case 'uploadEgreso':
                $this->accionUploadEgreso($feedlot);
                break;
            case 'uploadMuertes':
                $this->accionUploadMuertes($feedlot);
                break;
            case 'uploadIngreso':
                $this->accionUploadIngreso($feedlot);
                break;
            default:
                // Accion no soportada aun
                $this->redirect('ingreso');
        }
    }

    private function accionEgreso(string $feedlot): void {
        $tropa = $_POST['tropa'] ?? '';
        $fechaEgreso = $_POST['fechaEgreso'] ?? date('Y-m-d');
        $cantidad = (int)($_POST['cantidad'] ?? 0);
        $raza = $_POST['raza'] ?? '';
        $peso = (float)($_POST['peso'] ?? 0);
        $corral = $_POST['corral'] ?? '';
        $destino = $_POST['destino'] ?? '';
        $hoy = date('Y-m-d');
        if($fechaEgreso > $hoy) {
            $this->redirect('egreso');
        }
        if(!empty($_POST['otraRaza'])) {
            $raza = $_POST['otraRaza'];
            $sqlRaza = "INSERT INTO razas(raza) VALUES('" . $this->conexion->real_escape_string($raza) . "')";
            $this->conexion->query($sqlRaza);
        }
        if($cantidad > 0) {
            $pesoPromedio = $peso / $cantidad;
            for($i=0; $i<$cantidad; $i++) {
                $sql = "INSERT INTO egresos(feedlot,tropa,fecha,corral,raza,destino,peso) VALUES ('" .
                    $this->conexion->real_escape_string($feedlot) . "','" .
                    $this->conexion->real_escape_string($tropa) . "','" .
                    $this->conexion->real_escape_string($fechaEgreso) . "','" .
                    $this->conexion->real_escape_string($corral) . "','" .
                    $this->conexion->real_escape_string($raza) . "','" .
                    $this->conexion->real_escape_string($destino) . "','" .
                    $this->conexion->real_escape_string($pesoPromedio) . "')";
                $this->conexion->query($sql);
            }
        }
        $this->redirect('egreso');
    }

    private function accionEliminarEgreso(string $feedlot): void {
        $tropa = $_GET['tropa'] ?? '';
        if($tropa !== '') {
            $tropaEsc = $this->conexion->real_escape_string($tropa);
            $this->conexion->query("DELETE FROM egresos WHERE tropa = '$tropaEsc' AND feedlot = '" . $this->conexion->real_escape_string($feedlot) . "'");
            $this->conexion->query("DELETE FROM registroegresos WHERE tropa = '$tropaEsc' AND feedlot = '" . $this->conexion->real_escape_string($feedlot) . "'");
        }
        $this->redirect('egreso');
    }

    private function accionMuertes(string $feedlot): void {
        $fechaMuerte = $_POST['fechaMuerte'] ?? date('Y-m-d');
        $muertes = (int)($_POST['muertes'] ?? 0);
        $causaMuerte = $_POST['causaMuerte'] ?? '';
        $otra = $_POST['causaMuerteOtro'] ?? '';
        if($causaMuerte === 'otro' && $otra !== '') {
            $causaMuerte = $otra;
            $sqlNueva = "INSERT INTO causas(causa) VALUES ('" . $this->conexion->real_escape_string($causaMuerte) . "')";
            $this->conexion->query($sqlNueva);
        }
        if($muertes > 0) {
            $sql = "INSERT INTO muertes(feedlot,fecha,muertes,causaMuerte) VALUES ('" .
                $this->conexion->real_escape_string($feedlot) . "','" .
                $this->conexion->real_escape_string($fechaMuerte) . "','" .
                $this->conexion->real_escape_string($muertes) . "','" .
                $this->conexion->real_escape_string($causaMuerte) . "')";
            $this->conexion->query($sql);
        }
        $this->redirect('muerte');
    }

    private function accionEliminarMuerte(string $feedlot): void {
        $id = $_GET['id'] ?? '';
        if($id !== '' && ctype_digit($id)) {
            $idEsc = $this->conexion->real_escape_string($id);
            $this->conexion->query("DELETE FROM muertes WHERE id = '$idEsc' AND feedlot = '" . $this->conexion->real_escape_string($feedlot) . "'");
        }
        $this->redirect('muerte');
    }

    private function accionUploadEgreso(string $feedlot): void {
        $_SESSION['feedlot'] = $feedlot;
        $res = $this->service->uploadEgresoCSV($feedlot, $this->conexion, $_FILES);
        $_SESSION['flash'][] = $res;
        $this->redirect('egreso');
    }

    private function accionUploadMuertes(string $feedlot): void {
        $_SESSION['feedlot'] = $feedlot;
        $res = $this->service->uploadMuertesCSV($feedlot, $this->conexion, $_POST, $_FILES);
        $_SESSION['flash'][] = $res;
        $this->redirect('muerte');
    }

    private function accionUploadIngreso(string $feedlot): void {
        $_SESSION['feedlot'] = $feedlot;
        $res = $this->service->uploadIngresoCSV($feedlot, $this->conexion, $_POST, $_FILES);
        $_SESSION['flash'][] = $res;
        $this->redirect('ingreso');
    }
}
