<?php
include('../../includes/conexion.php');
include("../includes/init_session.php");

    $sql = "SELECT id,nombre FROM insumospremix WHERE feedlot = '$feedlot' ORDER BY nombre ASC";

    $query = mysqli_query($conexion,$sql);

    
    while($resultado = mysqli_fetch_array($query)){
        
        $id = $resultado['id']; 

        $nombre = $resultado['nombre'];

        echo "<option value='$id'>$nombre</option>";

    }

?>