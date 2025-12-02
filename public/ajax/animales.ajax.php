<?php
    
    include('../../includes/conexion.php');

    if($_POST['accion'] == 'cargarData'){

        $id = $_POST['idAnimal'];

        $tabla = $_POST['tabla'];
         
        $sql = "SELECT * FROM  $tabla WHERE id = '$id'";
    
        $query = mysqli_query($conexion,$sql);
    
        $resultado = mysqli_fetch_array($query);
    
        echo json_encode($resultado);

    }

    if($_POST['accion'] == 'modificarData'){
        
        $data = json_decode($_POST['data'], true);

        $id = $data['idAnimal'];

        $tabla = $_POST['tabla'];

        $set = '';
        foreach ($data as $key => $value) {
            
            if($key != 'idAnimal')
                $set .= $key." = '".$value."',";
                
        }

        $set =  substr($set, 0, -1);
        
        $sql = "UPDATE $tabla SET $set WHERE id = '$id'";

        if(mysqli_query($conexion,$sql)){
            
            echo 'ok';

        }else{

            echo mysqli_error($conexion);
            echo 'error';

        };
    
    }

    if($_POST['accion'] == 'eliminarAnimal'){
        
        $arr = array();

        $feedlot = $_COOKIE['feedlot'];

        $idAnimal = $_POST['idAnimal'];

        $tabla = $_POST['tabla'];

        $tropa = $_POST['tropa'];
        
        $sql = "SELECT (cantidad * pesoPromedio) as pesoTotal FROM registroingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
        $query = mysqli_query($conexion,$sql);
        $resultado = mysqli_fetch_assoc($query);
        $pesoTotal = $resultado['pesoTotal'];

        $sql = "UPDATE registroingresos SET 
            cantidad = cantidad - 1,
            pesoPromedio = ($pesoTotal - (SELECT peso FROM ingresos WHERE id = '$idAnimal' AND feedlot = '$feedlot')) / (cantidad - 1) 
            WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
        
        if(mysqli_query($conexion,$sql)){
            
            $arr['UpdateRegistroIngresos'] = 'ok';

        }else{

            $arr['UpdateRegistroIngresos'] = mysqli_error($conexion);

        }

        $sql = "DELETE FROM $tabla WHERE id = '$idAnimal'";

        if(mysqli_query($conexion,$sql)){
            
            $arr['Delete'] = 'ok';

        }else{

            $arr['Delete'] = mysqli_error($conexion);

        }

        echo json_encode($arr);
    }

?>