<?php
    
    include('../../includes/conexion.php');

    $id_insumo = $_POST['producto'];

    $sql = "SELECT porceMS FROM insumos WHERE id = '$id_insumo'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	echo $resultado['porceMS'];


?>