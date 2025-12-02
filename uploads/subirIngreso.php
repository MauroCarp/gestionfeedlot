<?php
include("includes/init_session.php");
include("includes/conexion.php");
include("includes/funciones.php");

error_reporting(0);

$fechaHoy = date("Y-m-d");
$feedlot = $_SESSION['feedlot'];

//Aquí es donde seleccionamos nuestro csv
$fname = $_FILES['fileIng']['name'];

$chk_ext = explode(".",$fname);

if(strtolower(end($chk_ext)) == "csv"){
	//si es correcto, entonces damos permisos de lectura para subir
	$filename = $_FILES['fileIng']['tmp_name'];
	$handle = fopen($filename, "r");

	$adpv = (($_POST['adpv']) != "") ? $_POST['adpv'] : 0;

	$renspa = $_POST['renspa'];
	$tropaTemp = $_FILES['fileIng']['name'];
	$tropa = substr($tropaTemp,0,-4);
	$totalAnimales = 0;
	$pesoTotal = 0;	
	$contador = 0;

	$sqlTropa = "SELECT COUNT(tropa) as valido FROM ingresos WHERE tropa = '$tropa' AND feedlot = '$feedlot'";
	$queryTropa = mysqli_query($conexion,$sqlTropa);
	$tropaValido = mysqli_fetch_array($queryTropa);
	// echo mysqli_error($conexion);

	if ($tropaValido['valido'] != 0 ) { ?>

				<script type="text/javascript">
					alert("El nombre de la Tropa ya esta siendo utilizado. Cambia el nombre del Archivo de Carga.");
					window.location = 'stock.php?seccion=ingreso.php';
				</script>
				
			<?php 
				die();
			}
			
			$fecha = "";
			$raza = "Sin Registro";
			$fechaIngreso = "";
			$error = false;
	
			if($feedlot == 'San Bernardo'){

				if(isset($_POST['cargaManualIngresos'])){

					if($_POST['razaIngreso'] != 'otraRaza'){

						$raza = $_POST['razaIngreso'];

					}else{

						$raza = $_POST['otraRaza'];
						
						$sql = "INSERT INTO razas(raza,feedlot) VALUES('$raza','$feedlot')";
						mysqli_query($conexion,$sql);

					} 

					if($_POST['origenIngreso'] != 'otroOrigenIngresos'){

						$origen = $_POST['origenIngreso'];

					}else{

						$origen = $_POST['otroOrigenIngresos'];
						
						$sql = "INSERT INTO origenes(origen,feedlot,seccion) VALUES('$origen','$feedlot','ingresos')";
						mysqli_query($conexion,$sql);
						
					} 

					if($_POST['destinoIngreso'] != 'otroDestinoIngresos'){

						$destino = $_POST['destinoIngreso'];

					}else{

						$destino = $_POST['otroDestinoIngresos'];
						
						$sql = "INSERT INTO destinos(destino,feedlot,seccion) VALUES('$destino','$feedlot','ingresos')";
						mysqli_query($conexion,$sql);
						
					} 

				}

				$rowValida = (isset($_POST['cargaManualIngresos'])) ? 2 : 5;

				while (($data = fgetcsv($handle, 1000, ";")) !== FALSE){	
			
 					if ($contador >= $rowValida) {

						$IDE = $data[0];
	
						$peso = $data[1];
						$pesoTotal += $data[1];
	
						$notas = $data[2];

						if($data[3] != '')
							$data[3];
	
						if($data[4] == 'Macho' OR $data[4] == 'Hembra' OR $data[4] == ''){
							
							$sexo =  $data[4];
						
						}else{
							
							$error = true;
	
						}
	
						// $estadoAnimal = $data[5];
						$proveedor = $data[5];
						$numeroDTE = $data[6];
						$origen = $data[7];
						$destino = $data[8];
						$gdm = $data[9];
						$gpv = $data[10];
						$dias = $data[11];
						// $corral = $data[7];
						$fecha = $data[12];
						list($dia,$mes,$anio) = explode('/',$fecha);
						$fecha = $anio."-".sprintf('%02d', $mes)."-".sprintf('%02d', $dia);
						$hora = $data[13];

						if($error){
	
							echo "<script>alert('error - valor no coincide con columna')</script>";
	
							$sql = "DELETE FROM ingresos WHERE feedlot = '$feedlot' AND tropa = '$tropa'";
							mysqli_query($conexion,$sql);
							echo '<script>
							window.location = "stock.php?seccion=ingreso";
			
							</script>';
							die();
	
	
						}
						
						// echo $IDE."-".$peso."-".$notas."-".$raza."-".$sexo."-".$estadoAnimal."-".$proveedor."-".$corral."-".$numeroDTE."-".$origen."-".$fecha."-".$hora."<br>";
						//Insertamos los datos con los valores...
						$sql = "INSERT INTO ingresos(feedlot,tropa,adpv,renspa,IDE,peso,raza,sexo,numDTE,origen,proveedor,notas,fecha,hora,destino,gdm,gpv,dias) 
						VALUES('$feedlot','$tropa','$adpv','$renspa','$IDE','$peso','$raza','$sexo','$numeroDTE','$origen','$proveedor','$notas','$fecha','$hora','$destino','$gdm','$gpv','$dias')";
	
						mysqli_query($conexion,$sql);// or die('<b>Error: Compuebe que el archivo este correcto.</b><br>Intente descargandolo nuevamente, y volviendolo a cargar en el sistema.<br>Para volver a la pagina anterior, click en la flecha ATRAS del navegador.');
						echo mysqli_error($conexion);
						$totalAnimales++;
					
					} 

					$contador++;
	
				}
				
				//cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
				$sql = "INSERT INTO status(feedlot,tropa,fechaIngreso,animales) VALUES('$feedlot','$tropa','$fecha','$totalAnimales')";
				mysqli_query($conexion,$sql);
				echo mysqli_error($conexion);
	
	
				$pesoProm = $pesoTotal / $totalAnimales;	
				$pesoProm = (float)$pesoProm;
				$pesoProm =  number_format($pesoProm,2);
				$sql = "INSERT INTO registroingresos(feedlot,tropa,fecha,cantidad,pesoPromedio,renspa,proveedor,estado,adpv) VALUES('$feedlot','$tropa','$fecha','$totalAnimales','$pesoProm','$renspa','$proveedor','$estadoAnimal','$adpv')";
				mysqli_query($conexion,$sql);
				echo mysqli_error($conexion);

			}
			
		fclose($handle);
		
		echo '<script>
				window.location = "stock.php?seccion=ingreso";

				</script>';
	}

?>