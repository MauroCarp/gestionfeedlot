<?php


// USUARIOS
$sql = "SELECT * FROM login ORDER BY nombre ASC";

$query = mysqli_query($conexion,$sql);


// FEEDLOTS

$sqlFeedlots = "SELECT DISTINCT(feedlot) FROM login ORDER BY feedlot ASC";

$queryFeedlots = mysqli_query($conexion,$sqlFeedlots);


// NUEVO USUARIO

if(isset($_GET['accion'])){

    if($_GET['accion'] == 'nuevoUsuario'){

        $nombreUsuario = $_POST['nombreUsuario'];
        $userUsuario = $_POST['userUsuario'];
        $passwordUsuario = crypt($_POST["passwordUsuario"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
        $feedlotUsuario = ($_POST['nuevoFeedlot'] == '') ? $_POST['feedlotUsuario'] : $_POST['nuevoFeedlot'];
        
        $sqlUserValido = "SELECT COUNT(*) FROM login WHERE user = '$userUsuario' AND feedlot = '$feedlotUsuario'";

        $queryUserValido = mysqli_query($conexion,$sqlUserValido);

        $userValido = mysqli_fetch_array($queryUserValido);

        if($userValido[0] > 0){

             
            echo "<script>
            
            alert('Ya hay un usuario registrado con ese nombre de usuario')

            window.location = 'usuarios.php'

            </script>";
           

        }else{

            $sql = "INSERT INTO login(nombre,user,pass,feedlot,tipo) VALUES ('$nombreUsuario','$userUsuario','$passwordUsuario','$feedlotUsuario','balanza')";
            
            mysqli_query($conexion,$sql);
            
            echo "<script>
            window.location = 'usuarios.php'
            </script>";
            
            die();
        
        }
        
    }
    
    if($_GET['accion'] == 'eliminarUsuario'){
    
        $id = $_GET['id'];

        $sql = "DELETE FROM login WHERE id = '$id'";

        mysqli_query($conexion,$sql);

        echo "<script>
        window.location = 'usuarios.php'
        </script>";
        
        die();
        
    }
}


?>
