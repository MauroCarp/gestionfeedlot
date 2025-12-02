<?php
include('../../includes/conexion.php');
include('../../includes/funciones.php');

$id = $_POST['id'];

$sqlQuery = "SELECT * FROM mixer WHERE id = '$id'";

$query = mysqli_query($conexion,$sqlQuery);

$resultado = mysqli_fetch_array($query);

$redondeosMixer = $resultado['redondeo'];

$redondeosMixer = explode(",", $redondeosMixer);

$formulaMixer = $resultado['formula'];

$nombreFormula = utf8_encode(nombreFormula($formulaMixer,$conexion));

$redondeoValido = ($resultado['redondeo'] == "") ? false : true;

$data = array('id'=>$id,'nombreFormula'=>$nombreFormula,'margen'=>$resultado['margen'],'kilos'=>$resultado['kilos'],'redondeoValido'=>$redondeoValido);

$sqlInsumos = "SELECT * FROM mixer INNER JOIN formulas ON mixer.formula = formulas.id WHERE formulas.id = '$formulaMixer'";

$queryInsumos = mysqli_query($conexion,$sqlInsumos);

$filaInsumos = mysqli_fetch_array($queryInsumos);

/*1*/$porcentaje = $filaInsumos['por1'];

/*8*/$porcentajeMSinsumo = tomaPorcentajeMS('p1',$filaInsumos['p1'],$conexion);

/*3*/$cantKilos = round(($filaInsumos['por1']*$filaInsumos['kilos'])/100,2);

/*2*/$porcentajeMS = porcentajeMS($filaInsumos['por1'],$porcentajeMSinsumo);

$nombreInsumo = utf8_encode(nombreInsumo('p1',$filaInsumos['p1'],$conexion));

$data['p1'] = array('porcentajeMSInsumo' => $porcentajeMSinsumo,'nombre'=>$nombreInsumo,'porcentaje'=>$porcentaje." %", 'porcentajeMS'=>$porcentajeMS,'cantKilos' => $cantKilos);


if (!$redondeoValido){
    
    $data['p1']['redondeoValido'] = false;

}else{

    /*4-5*/$data['p1']['redondeoMixer'] = $redondeosMixer[0];
    
    /*6*/$kgRedondeo = $redondeosMixer[0] - (round(($filaInsumos['por1']*$filaInsumos['kilos'])/100,2))." Kg";

    /*7*/$difPorcentaje = round((($redondeosMixer[0] * 100) / (($filaInsumos['por1']*$filaInsumos['kilos'])/100)-100),2);

    /*9*/$kilosMS = round(((tomaPorcentajeMS('p1',$filaInsumos['p1'],$conexion) * $redondeosMixer[0]) / 100),2)." Kg";
    
    $data['p1']['kgRedondeo'] = $kgRedondeo;
    $data['p1']['difPorcentaje'] = $difPorcentaje;
    $data['p1']['kilosMS'] = $kilosMS;

}

for ($i=1; $i < 11 ; $i++) { 

    $producto = "p".($i+1);

    $porcentaje = "por".($i+1);

    $redondeo = "redondeo".($i+1);
    
    if($filaInsumos[$producto] == NULL){
        
        break;
        
    }
    
    $porcentajeMSinsumo = tomaPorcentajeMS($producto,$filaInsumos[$producto],$conexion);
    
    if($filaInsumos[$producto] != ''){
        
        $nombreInsumo = utf8_encode(nombreInsumo($producto,$filaInsumos[$producto],$conexion));
        
        $tipo = obtenerTipoInsumo($nombreInsumo,$conexion);

        if ($tipo == 'Premix')
            $nombreInsumo = 'Premix '.$nombreInsumo; 

        $porce = $filaInsumos[$porcentaje];
        
        $porcentajeMS = porcentajeMS($filaInsumos[$porcentaje],$porcentajeMSinsumo);
        
        $cantKilos = round(($filaInsumos[$porcentaje]*$filaInsumos['kilos'])/100,2);
        
        $data[$producto] = array('porcentajeMSInsumo' => $porcentajeMSinsumo,'nombre'=>$nombreInsumo,'porcentaje'=>$porce, 'porcentajeMS'=>$porcentajeMS,'cantKilos' => $cantKilos,'nameRedondeo'=>$redondeo);
        
        if ($redondeoValido){
        
            $data[$producto]['redondeoMixer'] = $redondeosMixer[$i];
            
            $kgRedondeo = $redondeosMixer[$i] - (round(($filaInsumos[$porcentaje]*$filaInsumos['kilos'])/100,2))." Kg";
        
            $difPorcentaje = round((($redondeosMixer[$i] * 100)/ (($filaInsumos[$porcentaje]*$filaInsumos['kilos'])/100)-100),2);
            
            $kilosMS = round((tomaPorcentajeMS($producto,$filaInsumos[$producto],$conexion) * $redondeosMixer[$i]) / 100)." Kg";

            $data[$producto]['kgRedondeo'] = $kgRedondeo;
            
            $data[$producto]['difPorcentaje'] = $difPorcentaje;
            $data[$producto]['kilosMS'] = $kilosMS;
            
        }
    
    }

}

echo json_encode($data);

?>