<?php

$accionValido = array_key_exists("accion", $_REQUEST);

if ($accionValido) {

  $accion = $_GET['accion'];

  if ($accion == "modificar") {

    $tropaOriginal = $_GET['tropa'];
    $fechaIngreso = $_POST['fechaIngreso'];
    $renspa = $_POST['renspa'];
    $adpv = ($_POST['adpv'] == "") ? 0 : $_POST['adpv'];
    $origen = $_POST['origen'];
    $proveedor = $_POST['proveedor'];
    $estado = $_POST['estado'];
    $corral = $_POST['corral'];
    $notas = $_POST['notas'];
    $precioCompra = $_POST['precioCompra'];

    $sqlIngreso = "UPDATE registroingresos SET
    fecha = '$fechaIngreso',
    renspa = '$renspa',
    adpv = '$adpv',
    proveedor = '$proveedor',
    estado = '$estado',
    precioCompra = '$precioCompra'
    WHERE tropa = '$tropaOriginal'";
    mysqli_query($conexion,$sqlIngreso);
    
    echo mysqli_error($conexion);

    echo "<script>
      window.location = 'verTropa.php?tropa=".$tropaOriginal."&seccion=ingresos'
      </script>";
    
  }


  if ($accion == "modificarEgreso") {

    $tropaOriginal = $_GET['tropa'];
    $fechaEgreso = $_POST['fechaEgreso'];
    $precioVenta = $_POST['precioVenta'];

    $sqlIngreso = "UPDATE registroegresos SET
    fecha = '$fechaEgreso',
    precioVenta = '$precioVenta'
    WHERE tropa = '$tropaOriginal'";
    mysqli_query($conexion,$sqlIngreso);
    
    echo mysqli_error($conexion);

    echo "<script>
      window.location = 'verTropa.php?tropa=".$tropaOriginal."&seccion=egresos'
      </script>";
    
  }

}

$tropaValido = array_key_exists("tropa", $_REQUEST);

if ($tropaValido) {

  $tropa = $_GET['tropa'];
  $seccion = $_GET['seccion'];
  $cantIng = 0;
  $cantEgr = 0;
  $cantMuertes = 0;
  $totalPesoIng = 0;
  $totalPesoEgr = 0;
  $kgIngProm = 0;
  $kgEgrProm = 0;
  $diferenciaIngEgr = 0;

  if ($seccion == 'ingresos') {

    $sqlPrecio = "SELECT precioCompra, fecha FROM registroingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";

    $queryPrecio = mysqli_query($conexion,$sqlPrecio);

    $result= mysqli_fetch_array($queryPrecio);

    $precioCompra = $result['precioCompra'];
  
    $fechaIngreso = $result['fecha'];

    $sqlIng = "SELECT renspa,adpv,peso,fecha,proveedor,estadoAnimal,origen,corral,notas, MAX(peso) as maximo, MIN(peso) as minimo, COUNT(id) as total, SUM(peso) as pesoTotal FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    $queryIng = mysqli_query($conexion,$sqlIng);
    $resultados = mysqli_fetch_array($queryIng);

      $cantIng = $resultados['total'];
      $renspa = $resultados['renspa'];
      $adpv = $resultados['adpv'];
      $totalPesoIng = $resultados['pesoTotal'];
      $estado = ($resultados['estadoAnimal'] == '') ? 'Varios' : $resultados['estadoAnimal'];
      $proveedor = $resultados['proveedor'];
      $origen = $resultados['origen'];
      $corral = $resultados['corral'];
      $notas = $resultados['notas'];
      $pesoMax = $resultados['maximo'];
      $pesoMin = $resultados['minimo'];

      $desvioEstandar = '-';

    if ($cantIng > 0) {

      $kgIngProm = ($totalPesoIng/$cantIng);

      $sqlIng = "SELECT peso FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
      $queryIng = mysqli_query($conexion,$sqlIng);

      $distanciasCuadrada = array();
      
      while($resultado = mysqli_fetch_array($queryIng)){

        $distancia = $kgIngProm - $resultado['peso'];

        $distanciasCuadrada[] = pow(abs($distancia),2);

      }

      $sumaDistanciasCuadradas = array_sum($distanciasCuadrada);

      $desvioEstandar  = $sumaDistanciasCuadradas / $cantIng;

      $desvioEstandar = number_format(sqrt($desvioEstandar),2);

    }

    $kgIngProm = round($kgIngProm, 2);

  }

  if ($seccion == 'egresos') {
    
    $sqlPrecio = "SELECT precioVenta,fecha FROM registroegresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";

    $queryPrecio = mysqli_query($conexion,$sqlPrecio);

    $result= mysqli_fetch_array($queryPrecio);
    
    $precioVenta = $result['precioVenta'];
    
    $fechaEgreso = $result['fecha'];

    $sqlEgr = "SELECT peso,fecha,destino, origen,proveedor, MAX(peso) as maximo, MIN(peso) as minimo, COUNT(id) as total, SUM(peso) as pesoTotal FROM egresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
    
    $queryEgr = mysqli_query($conexion,$sqlEgr);
    
    $resultados = mysqli_fetch_array($queryEgr);
    
    $cantEgr = $resultados['total'];
    
    $totalPesoEgr = $resultados['pesoTotal'];
    
    $destino = $resultados['destino'];
    
    $pesoMaxEgr = $resultados['maximo'];

    $pesoMinEgr = $resultados['minimo'];


    if ($cantEgr > 0) {
    $kgEgrProm = ($totalPesoEgr/$cantEgr);
    }
    $kgEgrProm = round($kgEgrProm, 2);

  }
  
}
