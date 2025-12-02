<?php
namespace App\Http\Controllers;

class UsuariosController {
    public function index() {
        // Control de acceso
        $autorizados = ['Jcornale','Tecnico'];
        if(!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario'], $autorizados, true)) {
            header('Location: index.php');
            exit;
        }

        $accion = $_GET['accion'] ?? null;
        $conexion = $GLOBALS['conexion'] ?? null;

        // Acciones (crear / eliminar)
        if($accion === 'nuevoUsuario') {
            $nombreUsuario = $_POST['nombreUsuario'] ?? '';
            $userUsuario = $_POST['userUsuario'] ?? '';
            $passwordUsuario = isset($_POST['passwordUsuario']) ? crypt($_POST['passwordUsuario'], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$') : '';
            $feedlotUsuario = (!empty($_POST['nuevoFeedlot'])) ? $_POST['nuevoFeedlot'] : ($_POST['feedlotUsuario'] ?? '');

            if($nombreUsuario && $userUsuario && $passwordUsuario && $feedlotUsuario) {
                $sqlUserValido = "SELECT COUNT(*) AS c FROM login WHERE user = '".mysqli_real_escape_string($conexion,$userUsuario)."' AND feedlot = '".mysqli_real_escape_string($conexion,$feedlotUsuario)."'";
                $queryUserValido = mysqli_query($conexion,$sqlUserValido);
                $userValido = mysqli_fetch_assoc($queryUserValido);
                if(($userValido['c'] ?? 0) > 0) {
                    $_SESSION['flash_error'] = 'Ya existe un usuario con ese nombre para ese feedlot';
                } else {
                    $sqlInsert = "INSERT INTO login(nombre,user,pass,feedlot,tipo) VALUES ('".mysqli_real_escape_string($conexion,$nombreUsuario)."','".mysqli_real_escape_string($conexion,$userUsuario)."','".mysqli_real_escape_string($conexion,$passwordUsuario)."','".mysqli_real_escape_string($conexion,$feedlotUsuario)."','balanza')";
                    mysqli_query($conexion,$sqlInsert);
                    $_SESSION['flash_success'] = 'Usuario creado correctamente';
                }
            }
            header('Location: '.route_url('usuarios'));
            exit;
        }
        if($accion === 'eliminarUsuario') {
            $id = $_GET['id'] ?? null;
            if($id) {
                $idEsc = mysqli_real_escape_string($conexion,$id);
                mysqli_query($conexion,"DELETE FROM login WHERE id = '$idEsc'");
                $_SESSION['flash_success'] = 'Usuario eliminado';
            }
            header('Location: '.route_url('usuarios'));
            exit;
        }

        // Listados
        $usuariosData = [];
        $feedlotsData = [];
        $queryUsuarios = mysqli_query($conexion,"SELECT * FROM login ORDER BY nombre ASC");
        while($row = mysqli_fetch_assoc($queryUsuarios)) { $usuariosData[] = $row; }
        $queryFeedlots = mysqli_query($conexion,"SELECT DISTINCT(feedlot) FROM login ORDER BY feedlot ASC");
        while($row = mysqli_fetch_assoc($queryFeedlots)) { $feedlotsData[] = $row; }

        $data = [
            'title' => 'Usuarios',
            'feedlot' => $feedlot ?? '',
            'fechaDeHoy' => $fechaDeHoy ?? date('d-m-Y'),
            'usuariosData' => $usuariosData,
            'feedlotsData' => $feedlotsData,
            'flash_success' => $_SESSION['flash_success'] ?? null,
            'flash_error' => $_SESSION['flash_error'] ?? null,
        ];
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        layout_view('usuarios', $data);
    }
}
