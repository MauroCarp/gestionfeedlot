<?php
// Bridge hacia nueva ubicacion futura de funciones comunes.
require_once __DIR__ . '/../app/Support/functions.php'; // Contiene comprobarExisteCampo con guard

// Evitar redeclaración de todas las funciones si este archivo se incluye múltiples veces
if (defined('APP_FUNCIONES_LOADED')) {
	return; // ya cargado previamente
}
define('APP_FUNCIONES_LOADED', true);


if(!function_exists('diferenciaDias')){
function diferenciaDias($fechaProc){
	if(empty($fechaProc)){
		return 0;
	}
	try {
		$fechaProcDt = new DateTime((string)$fechaProc);
	} catch (\Exception $e) {
		return 0;
	}
	$hoyStr = date('Y-m-d');
	$hoyDt = new DateTime($hoyStr);
	$diasDiferencia = $fechaProcDt->diff($hoyDt)->days;
	return (int)$diasDiferencia;
}
}

if(!function_exists('esVencido')){
function esVencido($diferenciaDias,$procedimiento){
	$esVencido = FALSE;
	if ($procedimiento == 'Metafilaxis' AND $diferenciaDias > 7) {
		$esVencido = TRUE;
	}
	if ($procedimiento == '1er Dosis' AND $diferenciaDias > 15) {
		$esVencido = TRUE;
	}
	return $esVencido;
}
}

if(!function_exists('esProximo')){
function esProximo($diferenciaDias,$procedimiento){
	$esProximo = FALSE;
	if ($procedimiento == 'Metafilaxis' AND $diferenciaDias <= 7 AND $diferenciaDias >= 2 ) {
		$esProximo = TRUE;
	}
	if ($procedimiento == '1er Dosis' AND $diferenciaDias <= 15 AND $diferenciaDias >= 7) {
		$esProximo = TRUE;
	}
		return $esProximo;
}
}

if(!function_exists('formatearFecha')){
function formatearFecha($fecha){
	if ($fecha == NULL) {
		$fechaFormateada = '';
	}else{	
  		$fechaFormateada = date("d-m-Y",strtotime($fecha));
	}
  return $fechaFormateada;
}
}

if(!function_exists('validarCampo')){
function validarCampo($campo){
	$campoValido = array_key_exists($campo, $_POST);
	$valorCampo = "";
	if ($campoValido) {
		$valorCampo = $_POST[$campo];
	}
	return $valorCampo;
	}
}

if(!function_exists('porcentaje')){
function porcentaje($valor,$total){
	$resultadoPorcentaje = ($valor*100)/$total;
	$resultadoPorcentaje = round($resultadoPorcentaje,2);
	return $resultadoPorcentaje;
}
}

if(!function_exists('porcentajeMS')){
function porcentajeMS($porcentaje,$porcentajeMSinsumo){
	
	$porcentajeMS = $porcentaje * ($porcentajeMSinsumo/100);
	
	$porcentajeMS = round($porcentajeMS,2);
	
	return $porcentajeMS;
	
}
}

if(!function_exists('ultimaFecha')){
function ultimaFecha($insumo,$conexion){
	$sql = "SELECT MAX(fecha) AS ultimaFecha FROM insumos WHERE insumo = '$insumo'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);

	return $fila ? $fila['ultimaFecha'] : null;
}
}

if(!function_exists('traeDatos')){
function traeDatos($ultimaFecha,$insumo,$conexion){
	$sql = "SELECT * FROM insumos WHERE insumo = '$insumo' AND fecha = '$ultimaFecha'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);

	return $fila;	
}
}

if(!function_exists('nombreInsumo')){
function nombreInsumo($productoN,$productoResultado,$conexion){
	if ($productoResultado === null || $productoResultado === '') {
		return null;
	}
	$sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);
	$resultado = $fila ? $fila['insumo'] : null;
	return $resultado;
}
}

if(!function_exists('precioInsumo')){
function precioInsumo($productoN,$productoResultado,$conexion){
	if ($productoResultado === null || $productoResultado === '') {
		return null;
	}
	$sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);
	$resultado = $fila ? $fila['precio'] : null;
	return $resultado;
}
}

if(!function_exists('tomaPorcentajeMS')){
function tomaPorcentajeMS($productoN,$productoResultado,$conexion){
	if ($productoResultado === null || $productoResultado === '') {
		return 0;
	}
	$sql = "SELECT * FROM formulas INNER JOIN insumos ON formulas.$productoN = insumos.id WHERE insumos.id = '$productoResultado'";
	
	$query = mysqli_query($conexion,$sql);
	
	$fila = mysqli_fetch_array($query);
	
	$resultado = $fila ? $fila['porceMS'] : 0;
	
	return $resultado;
}
}

if(!function_exists('obtenerMSinsumo')){
function obtenerMSinsumo($id_insumo,$conexion){

	$sql = "SELECT porceMS FROM insumos WHERE id = '$id_insumo'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	return $resultado ? floatval($resultado['porceMS']) : 0.0;

}
}

if(!function_exists('nombreFormula')){
function nombreFormula($id,$conexion){
	$sqlFormula = "SELECT tipo,nombre FROM formulas WHERE id = '$id'";
	$queryFormula = mysqli_query($conexion,$sqlFormula);
	$filaFormula = mysqli_fetch_array($queryFormula);
	$resultado = $filaFormula['tipo']." - ".$filaFormula['nombre'];
	return $resultado;
}
}

if(!function_exists('getLabels')){
function getLabels($feedlot,$conexion){
	$sqlLabel = "SELECT DISTINCT causaMuerte FROM muertes WHERE feedlot = '$feedlot' ORDER BY causaMuerte ASC";
	$queryLabel = mysqli_query($conexion,$sqlLabel);
	$labels = array();
	while ($label = mysqli_fetch_array($queryLabel)) {
	$labels[] = $label['causaMuerte'];
	}
	return $labels;
}
}

if(!function_exists('cantidadCausa')){
function cantidadCausa($feedlot,$conexion,$causa){

	$sql = "SELECT COUNT(*) as total FROM muertes WHERE feedlot = '$feedlot' AND causaMuerte = '$causa'";
	$query = mysqli_query($conexion,$sql);
	$resultado = mysqli_fetch_array($query);
	return $resultado ? $resultado['total'] : 0;

}
}

if(!function_exists('fechaExcel')){
/**
 * Convierte fecha de formato dd-mm-yy a yyyy-mm-dd.
 * @deprecated Migrar a normalizador en StockService para cargas CSV.
 */
function fechaExcel($fecha){
	$fechaTemp = explode("-",$fecha);
	$nuevaFecha = $fechaTemp[1]."-".$fechaTemp[0]."-".$fechaTemp[2];
	$standarddate = "20".substr($nuevaFecha,6,2) . "-" . substr($nuevaFecha,3,2) . "-" . substr($nuevaFecha,0,2);
	return $standarddate;
}
}

if(!function_exists('cantRaza')){
function cantRaza($raza,$seccion,$tropa,$conexion){
	$sql = "SELECT COUNT(raza) AS cantidad FROM $seccion WHERE raza = '$raza' AND tropa = '$tropa'";
	$query = mysqli_query($conexion,$sql);
	$resultado = mysqli_fetch_array($query);
	$cantidad = $resultado ? $resultado['cantidad'] : 0;

	return $cantidad;
}
}


if(!function_exists('cantRazaInforme')){
function cantRazaInforme($raza,$seccion,$feedlot,$desde,$hasta,$conexion){
	$sql = "SELECT COUNT(raza) AS cantidad FROM $seccion WHERE raza = '$raza' AND feedlot = '$feedlot' AND fecha BETWEEN '$desde' AND '$hasta'";
	$query = mysqli_query($conexion,$sql);
	$resultado = mysqli_fetch_array($query);
	$cantidad = $resultado ? $resultado['cantidad'] : 0;

	return $cantidad;
}
}



if(!function_exists('stock')){
function stock($fecha,$feedlot,$conexion){
	
	$sqlIng = "SELECT SUM(cantidad) AS cantidad FROM registroingresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '2010-01-01' AND '$fecha'";
		$queryIng = mysqli_query($conexion,$sqlIng);
		$resultadoIng = mysqli_fetch_array($queryIng);
		$cantIng = $resultadoIng['cantidad'];


		$sqlEgr = "SELECT SUM(cantidad) AS cantidad FROM registroegresos WHERE feedlot = '$feedlot' AND fecha BETWEEN '2010-01-01' AND '$fecha'";
		$queryEgr = mysqli_query($conexion,$sqlEgr);
		$resultadoEgr = mysqli_fetch_array($queryEgr);
		$cantEgr = $resultadoEgr['cantidad'];


		$sqlMuertes = "SELECT COUNT(*) AS cantidad FROM muertes WHERE feedlot = '$feedlot' AND fecha BETWEEN '2010-01-01' AND '$fecha'";
		$queryMuertes = mysqli_query($conexion,$sqlMuertes);
		$resultadoMuertes = mysqli_fetch_array($queryMuertes);
		$cantMuertes = $resultadoMuertes['cantidad'];


		$stock = $cantIng;
		if ($cantEgr != 0) {
			$stock -= $cantEgr;
		}

		if ($cantMuertes != 0) {
			$stock -= $cantMuertes;
		}

	return $stock;

}
}

if(!function_exists('porceMS')){
function porceMS($id_producto,$porcentaje,$conexion){

	if ($id_producto === null || $id_producto === '') {
		return 0;
	}

	$sql = "SELECT porceMS FROM insumos WHERE id = '$id_producto'";

	$query = mysqli_query($conexion,$sql);
    
	$resultado = mysqli_fetch_array($query);

	if (!$resultado) {
		return 0;
	}

	$porceMSinsumo = $resultado['porceMS'];

	$porceMS = $porcentaje * ($porceMSinsumo / 100);

	return $porceMS;
}
}


if(!function_exists('traerNombreInsumo')){
/**
 * Obtiene nombre de insumo por ID.
 * @deprecated Usar nombreInsumo() o InsumoService futuro.
 */
function traerNombreInsumo($id,$conexion){
	$sqlIns = "SELECT insumo FROM insumos WHERE id = '$id'";
	$queryIns = mysqli_query($conexion,$sqlIns);
	$resultadoIns = mysqli_fetch_array($queryIns);
	$nombre = $resultadoIns['insumo'];
	return $nombre;	
}
}

if(!function_exists('paginador')){
/**
 * Genera HTML de paginación legado.
 * @deprecated Reemplazar por helper pagination_links() en vistas.
 */
function paginador($seccion,$feedlot,$conexion){

	// Fallback: delegar al nuevo helper y emitir aviso deprecación
	trigger_error('paginador() deprecated; usar pagination_links()', E_USER_DEPRECATED);
	return pagination_links($seccion,$feedlot,$conexion);
    // Código legado eliminado.
}

}

if(!function_exists('pagination_links')){
/**
 * Genera lista <li> de paginación moderna.
 * Calcula páginas con ceil y permite perPage parametrizable (default 12).
 */
function pagination_links($seccion,$feedlot,$conexion,$perPage=12){
	$sql = "SELECT COUNT(*) as cantidad FROM $seccion WHERE feedlot = '$feedlot'";
	$query = mysqli_query($conexion,$sql);
	$fila = mysqli_fetch_array($query);
	$totalRegistros = $fila ? (int)$fila['cantidad'] : 0;
	$totalPaginas = ($totalRegistros > 0) ? (int)ceil($totalRegistros / $perPage) : 1;
	$jsFunction = ($seccion === 'mixer') ? 'paginarMixer' : 'paginar';
	$out = '';
	// Botón inicial «
	$out .= '<li style="cursor:pointer;"><a onclick="'.$jsFunction.'(0,\''.$seccion.'\')">&laquo;</a></li>'."\n";
	for($i=1;$i<=$totalPaginas;$i++){
		$index = $i-1; // índice cero-based que usa JS legacy
		$out .= '<li style="cursor:pointer;"><a onclick="'.$jsFunction.'('.$index.',\''.$seccion.'\')">'.$i.'</a></li>'."\n";
	}
	return $out;
}
}

if(!function_exists('nombreMes')){
function nombreMes($numero){
	include('arrays.php');
	$mes = "";
	foreach ($nombreMes as $num => $nombre) {
		if ($numero == $num) {
			$mes = "'".$nombre."'";
		}
	}
	return $mes;
}
}

if(!function_exists('formatearNum')){
function formatearNum($numero){
	$numeroFormateado = number_format($numero,2,",",".");
	return $numeroFormateado;
}
}

if(!function_exists('labelsCantAnimales')){
function labelsCantAnimales($fechaDesde,$fechaHasta){
	  $numeroDesde = date("n", strtotime($fechaDesde));
	  $numeroHasta = date("n", strtotime($fechaHasta));

	  $cantMeses = $numeroHasta - $numeroDesde;
	  $meses[$numeroDesde] = nombreMes($numeroDesde);
	  $contador = $numeroDesde;
	  for ($i=1; $i < $cantMeses; $i++) { 
	    $numero = $contador + $i; 
	    $meses[$numero] = nombreMes($numero);
	  }
	  $meses[$numeroHasta] = nombreMes($numeroHasta);

	  return $meses;
	
}
}


if(!function_exists('obtenerMax')){
function obtenerMax($campo,$tabla,$conexion){
	$sql = "SELECT MAX($campo) as maximo FROM $tabla";
	$query = mysqli_query($conexion,$sql);
	echo mysqli_error($conexion);
	$resultado = mysqli_fetch_array($query);
	$maximo = ($resultado['maximo'] != '') ? $resultado['maximo'] : 0;
	return $maximo;
}
}


if(!function_exists('dataInsumoPremix')){
function dataInsumoPremix($id,$campo,$conexion){

	$sql = "SELECT $campo FROM insumospremix WHERE id = '$id'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	return $resultado[$campo];
}	
}

if(!function_exists('obtenerTipoInsumo')){
function obtenerTipoInsumo($nombreInsumo,$conexion){

	if ($nombreInsumo === null || $nombreInsumo === '') {
		return null;
	}

	$sql = "SELECT tipo FROM insumos WHERE insumo = '$nombreInsumo'";

	$query = mysqli_query($conexion,$sql);

	$resultado = mysqli_fetch_array($query);

	return $resultado ? $resultado['tipo'] : null;

}
}

// Deprecated legacy CSV helper shims (removed during refactor).
// Reintroduced to avoid fatal errors in remaining legacy upload scripts.
// Use new StockService parsing instead for future code.
if(!function_exists('registroVacioString')){
function registroVacioString($valor){
	trigger_error('registroVacioString() deprecated; migrate to StockService sanitization', E_USER_DEPRECATED);
	$valor = trim((string)$valor);
	return $valor; // legacy behavior: empty stays empty string
}
}

if(!function_exists('registroVacioNumero')){
function registroVacioNumero($valor){
	trigger_error('registroVacioNumero() deprecated; migrate to StockService sanitization', E_USER_DEPRECATED);
	$valor = trim((string)$valor);
	if($valor === '' || !is_numeric($valor)){
		return 0; // legacy fallback
	}
	return (float)$valor;
}
}

if(!function_exists('registroVacioFecha')){
function registroVacioFecha($valor){
	trigger_error('registroVacioFecha() deprecated; migrate to StockService sanitization', E_USER_DEPRECATED);
	$valor = trim((string)$valor);
	if($valor === ''){
		return date('Y-m-d');
	}
	$valor = str_replace('/','-',$valor);
	$ts = strtotime($valor);
	return $ts ? date('Y-m-d',$ts) : date('Y-m-d');
}
}


?>

