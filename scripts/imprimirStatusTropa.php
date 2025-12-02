<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("lib/fpdf/fpdf.php");

function formatearFecha($fecha){
	if ($fecha == NULL) {
		$fechaFormateada = '';
	}else{	
  		$fechaFormateada = date("d-m-Y",strtotime($fecha));
	}
  return $fechaFormateada;
}

$tropa = $_GET['tropa'];

$sql = "SELECT * FROM status WHERE feedlot = '$feedlot' AND tropa = '$tropa' ORDER BY fechaIngreso DESC, tropa DESC"; 

$query = mysqli_query($conexion,$sql);

$resultado = mysqli_fetch_array($query);

	$pdf = new FPDF('P','mm','A4');	
	$pdf->AddPage();
	$pdf->SetFillColor(222,222,222);
	$pdf->SetTitle(utf8_decode('Status Sanitario'));
	$pdf->SetDisplayMode('fullpage', 'single');
	$pdf->SetAutoPageBreak(1,1);
	$pdf->SetFont('Times','B',11);
	$pdf->SetX(10);
	$pdf->Cell(130,7,utf8_decode('Gestión de Feedlot'),0,0,'L',0);
	$pdf->Cell(60,7,utf8_decode('Jorge Cornale'),0,1,'R',0);
	$pdf->Ln(1);
	$pdf->SetFont('Times','B',18);
	$pdf->Cell(190,10,'Feedlot: '.$feedlot,0,1,'L',0);
	$pdf->Cell(190,10,utf8_decode('Status Sanitario - Tropa: '.$tropa),0,1,'L',0);
	$pdf->SetFont('helvetica','B',12);
	$pdf->SetX(10);
	$pdf->Cell(27,10,'Fecha Ing.',0,0,'L',0);
	$pdf->Cell(22,10,'Cantidad',0,0,'L',0);
	$pdf->Cell(25,10,'Operario',0,0,'L',0);
	$pdf->Cell(27,10,'Metafilaxis',0,0,'L',0);
	$pdf->Cell(30,10,'1er Dosis',0,0,'L',0);
	$pdf->Cell(20,10,'Refuerzo',0,1,'L',0);
	$pdf->SetX(10);
	$pdf->Cell(190,.01,'',1,1,'L',0);
	$pdf->SetX(10);

    $pdf->SetFont('Arial','B',11);
	$pdf->SetX(10);

    $pdf->Cell(27,10,formatearFecha($resultado['fechaIngreso']),0,0,'L',0);
    $pdf->Cell(23,10,$resultado['animales'],0,0,'C',0);
    $pdf->Cell(25,10,$resultado['operario'],0,0,'L',0);

    if($resultado['metafilaxis']){ 
        $pdf->SetTextColor(0,255,0);
        $pdf->Cell(27,10,'V',0,0,'C',0);
    }else{ 
        $pdf->SetTextColor(255,0,0);
        $pdf->Cell(27,10,'X',0,0,'C',0);
    }

    if($resultado['vacuna']){ 
        $pdf->SetTextColor(0,255,0);
        $pdf->Cell(30,10,'V',0,0,'C',0);
    }else{ 
        $pdf->SetTextColor(255,0,0);
        $pdf->Cell(30,10,'X',0,0,'C',0);
    }

    if($resultado['refuerzo']){ 
        $pdf->SetTextColor(0,255,0);
        $pdf->Cell(20,10,'V',0,1,'C',0);
    }else{ 
        $pdf->SetTextColor(255,0,0);
        $pdf->Cell(20,10,'X',0,1,'C',0);
    }
    $pdf->Cell(190,.01,'',1,1,'L',0);

    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('helvetica','B',12);
	$pdf->SetX(10);
	$pdf->Cell(40,10,'Tropa:',0,0,'L',0);
	$pdf->Cell(27,10,$tropa,0,1,'L',0);
	$pdf->Cell(40,10,'Status:',0,0,'L',0);
	$pdf->Cell(27,10,$resultado['procedimiento'],0,1,'L',0);
	$pdf->Cell(40,10,'Operario:',0,0,'L',0);
	$pdf->Cell(27,10,$resultado['operario'],0,1,'L',0);
	$pdf->Cell(40,10,'Fecha Realizado:',0,0,'L',0);
	$pdf->Cell(27,10,formatearFecha($resultado['fechaRealizado']),0,1,'L',0);

	$pdf->Ln(5);
    
	$pdf->SetFillColor(200,200,200);

	$pdf->Cell(40,10,'Procedimiento',0,0,'L',1);
	$pdf->Cell(40,10,'Fecha Realizado',0,0,'L',1);
	$pdf->Cell(40,10,'Operario',0,1,'L',1);
    

	$odd = true;
	$pdf->SetFillColor(220,220,220);

    if ($resultado['metafilaxis'] == 1) { 

		if($odd)
		$pdf->SetFillColor(220,220,220);
		else
		$pdf->SetFillColor(250,250,250);
		

        $pdf->Cell(40,10,'Metafilaxis',0,0,'L',1);
        $pdf->Cell(40,10,formatearFecha($resultado['fechaMetafilaxis']),0,0,'L',1);
        $pdf->Cell(40,10,$resultado['operario1'],0,1,'L',1);
        
		$odd = !$odd;
		
    }
    
    if ($resultado['vacuna'] == 1) {

		if($odd)
		$pdf->SetFillColor(220,220,220);
		else
		$pdf->SetFillColor(250,250,250);

        $pdf->Cell(40,10,'1er Dosis',0,0,'L',1);
        $pdf->Cell(40,10,formatearFecha($resultado['fechaVacuna']),0,0,'L',1);
        $pdf->Cell(40,10,$resultado['operario2'],0,1,'L',1);

		$odd = !$odd;

    }

    if ($resultado['refuerzo'] == 1) { 

		if($odd)
		$pdf->SetFillColor(220,220,220);
		else
		$pdf->SetFillColor(250,250,250);

        $pdf->Cell(40,10,'Refuerzo',0,0,'L',1);
        $pdf->Cell(40,10,formatearFecha($resultado['fechaRefuerzo']),0,0,'L',1);
        $pdf->Cell(40,10,$resultado['operario3'],0,1,'L',1);

		$odd = !$odd;

    }

	$pdf->Ln(5);

	$pdf->Cell(40,10,'Otros Tratamientos',0,1,'L',0);
	
	$pdf->SetFillColor(200,200,200);

	$pdf->Cell(40,10,'Tratamiento',0,0,'L',1);
	$pdf->Cell(40,10,'Fecha Realizado',0,0,'L',1);
	$pdf->Cell(40,10,'Operario',0,1,'L',1);
    
	  
	
	
	$otrosTratamientos = json_decode('['.substr($resultado['otroTratamiento'],0,-1).']',true);
	
	for ($i=0; $i < sizeof($otrosTratamientos) ; $i++) { 
		
		if($odd)
		$pdf->SetFillColor(220,220,220);
		else
		$pdf->SetFillColor(250,250,250);

		$pdf->Cell(40,10,$otrosTratamientos[$i]['tratamiento'],0,0,'L',1);
		$pdf->Cell(40,10,$otrosTratamientos[$i]['fecha'],0,0,'L',1);
		$pdf->Cell(40,10,$otrosTratamientos[$i]['operario'],0,1,'L',1);
	
		$odd = !$odd;

	}

	$pdf->SetFont('Helvetica','',11);

	$pdf->Output();
	
?>