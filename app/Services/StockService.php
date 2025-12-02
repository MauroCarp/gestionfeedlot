<?php
namespace App\Services;

class StockService {
    public function computeTotals(string $feedlot, \mysqli $conexion): array {
        $cantIng = 0;
        $cantEgr = 0;
        $cantMuertes = 0;
        $pesoTotalIng = 0;
        $pesoTotalEgr = 0;
        $kgIngProm = 0;
        $kgEgrProm = 0;
        $kgMinIng = 1000000;
        $kgMaxIng = 0;
        $kgMinEgr = 1000000;
        $kgMaxEgr = 0;

        // Cantidad con Stock Inicial
        $sql = "SELECT SUM(cantidad) AS cantidadConStockInicial FROM registroingresos WHERE feedlot = '$feedlot'";
        if($query = $conexion->query($sql)) {
            $row = $query->fetch_assoc();
            $cantIngConStockInicial = (int)($row['cantidadConStockInicial'] ?? 0);
        } else { $cantIngConStockInicial = 0; }

        // Ingresos (excluyendo Stock Inicial)
        $sqlIng = "SELECT cantidad, pesoPromedio FROM registroingresos WHERE feedlot = '$feedlot' AND tropa != 'Stock Inicial'";
        if($queryIng = $conexion->query($sqlIng)) {
            while($r = $queryIng->fetch_assoc()) {
                $cantidad = (int)$r['cantidad'];
                $pesoPromedio = (float)$r['pesoPromedio'];
                $cantIng += $cantidad;
                $pesoTotalIng += ($cantidad * $pesoPromedio);
                $kgMinIng = ($kgMinIng > $pesoPromedio) ? $pesoPromedio : $kgMinIng;
                $kgMaxIng = ($kgMaxIng < $pesoPromedio) ? $pesoPromedio : $kgMaxIng;
            }
        }

        // Egresos
        $sqlEgr = "SELECT cantidad, pesoPromedio FROM registroegresos WHERE feedlot = '$feedlot'";
        if($queryEgr = $conexion->query($sqlEgr)) {
            while($r = $queryEgr->fetch_assoc()) {
                $cantidadEgr = (int)$r['cantidad'];
                $pesoPromedioEgr = (float)$r['pesoPromedio'];
                $cantEgr += $cantidadEgr;
                $pesoTotalEgr += ($cantidadEgr * $pesoPromedioEgr);
                $kgMinEgr = ($kgMinEgr > $pesoPromedioEgr) ? $pesoPromedioEgr : $kgMinEgr;
                $kgMaxEgr = ($kgMaxEgr < $pesoPromedioEgr) ? $pesoPromedioEgr : $kgMaxEgr;
            }
        }

        // Muertes
        $sqlMuertes = "SELECT COUNT(*) AS cantidad FROM muertes WHERE feedlot = '$feedlot'";
        if($queryM = $conexion->query($sqlMuertes)) {
            $row = $queryM->fetch_assoc();
            $cantMuertes = (int)($row['cantidad'] ?? 0);
        }

        if($cantIng > 0) { $kgIngProm = $pesoTotalIng / $cantIng; }
        if($cantEgr > 0) { $kgEgrProm = $pesoTotalEgr / $cantEgr; }

        $kgIngProm = round($kgIngProm,2);
        $kgEgrProm = round($kgEgrProm,2);

        $stock = 0;
        if ($cantIngConStockInicial !== 0) { $stock += $cantIngConStockInicial; }
        if ($cantEgr !== 0 && $stock !== 0) { $stock -= $cantEgr; }
        if ($cantMuertes !== 0 && $stock !== 0) { $stock -= $cantMuertes; }

        return [
            'cantIng' => $cantIng,
            'cantEgr' => $cantEgr,
            'cantMuertes' => $cantMuertes,
            'pesoTotalIng' => $pesoTotalIng,
            'pesoTotalEgr' => $pesoTotalEgr,
            'kgIngProm' => $kgIngProm,
            'kgEgrProm' => $kgEgrProm,
            'kgMinIng' => $kgMinIng == 1000000 ? 0 : $kgMinIng,
            'kgMaxIng' => $kgMaxIng,
            'kgMinEgr' => $kgMinEgr == 1000000 ? 0 : $kgMinEgr,
            'kgMaxEgr' => $kgMaxEgr,
            'stock' => $stock,
        ];
    }

    public function uploadIngresoCSV(string $feedlot, \mysqli $conexion, array $post, array $files): array {
        if(!isset($files['fileIng']) || $files['fileIng']['error'] !== UPLOAD_ERR_OK) {
            return ['ok'=>false,'seccion'=>'ingreso','msg'=>'Archivo no recibido'];
        }
        $fname = $files['fileIng']['name'];
        $ext = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
        if($ext !== 'csv') { return ['ok'=>false,'seccion'=>'ingreso','msg'=>'Formato inválido']; }
        $adpv = ($post['adpv'] ?? '') !== '' ? (float)$post['adpv'] : 0;
        $renspa = $post['renspa'] ?? '';
        $tropa = substr($fname,0,-4);
        $tropaEsc = $conexion->real_escape_string($tropa);
        $feedlotEsc = $conexion->real_escape_string($feedlot);
        $sqlCheck = "SELECT COUNT(tropa) AS c FROM ingresos WHERE tropa='$tropaEsc' AND feedlot='$feedlotEsc'";
        if(($res = $conexion->query($sqlCheck)) && ($row=$res->fetch_assoc()) && (int)$row['c'] !== 0) {
            return ['ok'=>false,'seccion'=>'ingreso','msg'=>'Tropa ya utilizada'];
        }
        $filePath = $files['fileIng']['tmp_name'];
        $fh = fopen($filePath,'r');
        if(!$fh) { return ['ok'=>false,'seccion'=>'ingreso','msg'=>'No se pudo abrir archivo']; }
        $totalAnimales=0; $pesoTotal=0; $contador=0; $error=false; $proveedor=''; $estadoAnimal=''; $fecha='';
        $manual = isset($post['cargaManualIngresos']);
        $raza = 'Sin Registro';
        if($feedlot === 'San Bernardo' && $manual) {
            if(($post['razaIngreso'] ?? '') === 'otraRaza') {
                $raza = $post['otraRaza'] ?? 'Sin Registro';
                if($raza !== '') { $conexion->query("INSERT INTO razas(raza,feedlot) VALUES('".$conexion->real_escape_string($raza)."','$feedlotEsc')"); }
            } else { $raza = $post['razaIngreso'] ?? 'Sin Registro'; }
        }
        while(($data = fgetcsv($fh,1000,';')) !== false) {
            if($contador >= ($manual?2:5)) {
                $IDE = $data[0] ?? '';
                $peso = (float)($data[1] ?? 0); $pesoTotal += $peso;
                $notas = $data[2] ?? '';
                $sexo = $data[4] ?? '';
                if(!in_array($sexo,['Macho','Hembra',''])) { $error=true; break; }
                $proveedor = $data[5] ?? '';
                $numeroDTE = $data[6] ?? '';
                $origen = $data[7] ?? '';
                $destino = $data[8] ?? '';
                $gdm = $data[9] ?? 0; $gpv = $data[10] ?? 0; $dias = $data[11] ?? 0;
                $fechaRaw = $data[12] ?? '';
                if($fechaRaw) { [$d,$m,$y] = array_pad(explode('/',$fechaRaw),3,''); $fecha = "$y-".sprintf('%02d',$m)."-".sprintf('%02d',$d); }
                $hora = $data[13] ?? '';
                $sqlIns = "INSERT INTO ingresos(feedlot,tropa,adpv,renspa,IDE,peso,raza,sexo,numDTE,origen,proveedor,notas,fecha,hora,destino,gdm,gpv,dias) VALUES ('".
                    $feedlotEsc."','".$conexion->real_escape_string($tropa)."','$adpv','".$conexion->real_escape_string($renspa)."','".$conexion->real_escape_string($IDE)."','$peso','".$conexion->real_escape_string($raza)."','".$conexion->real_escape_string($sexo)."','".$conexion->real_escape_string($numeroDTE)."','".$conexion->real_escape_string($origen)."','".$conexion->real_escape_string($proveedor)."','".$conexion->real_escape_string($notas)."','".$conexion->real_escape_string($fecha)."','".$conexion->real_escape_string($hora)."','".$conexion->real_escape_string($destino)."','".$conexion->real_escape_string($gdm)."','".$conexion->real_escape_string($gpv)."','".$conexion->real_escape_string($dias)."')";
                $conexion->query($sqlIns);
                $totalAnimales++;
            }
            $contador++;
        }
        fclose($fh);
        if($error) { $conexion->query("DELETE FROM ingresos WHERE feedlot='$feedlotEsc' AND tropa='".$conexion->real_escape_string($tropa)."'"); return ['ok'=>false,'seccion'=>'ingreso','msg'=>'Error en CSV (sexo)']; }
        if($totalAnimales>0) {
            $conexion->query("INSERT INTO status(feedlot,tropa,fechaIngreso,animales) VALUES('$feedlotEsc','".$conexion->real_escape_string($tropa)."','".$conexion->real_escape_string($fecha)."','$totalAnimales')");
            $pesoProm = $pesoTotal/$totalAnimales; $pesoProm = number_format($pesoProm,2,'.','');
            $conexion->query("INSERT INTO registroingresos(feedlot,tropa,fecha,cantidad,pesoPromedio,renspa,proveedor,estado,adpv) VALUES('$feedlotEsc','".$conexion->real_escape_string($tropa)."','".$conexion->real_escape_string($fecha)."','$totalAnimales','$pesoProm','".$conexion->real_escape_string($renspa)."','".$conexion->real_escape_string($proveedor)."','".$conexion->real_escape_string($estadoAnimal)."','$adpv')");
        }
        return ['ok'=>true,'seccion'=>'ingreso','msg'=>'Ingreso cargado'];
    }

    public function uploadEgresoCSV(string $feedlot, \mysqli $conexion, array $files): array {
        if(!isset($files['fileEgr'])||$files['fileEgr']['error']!==UPLOAD_ERR_OK){return ['ok'=>false,'seccion'=>'egreso','msg'=>'Archivo no recibido'];}
        $fname=$files['fileEgr']['name']; $ext=strtolower(pathinfo($fname,PATHINFO_EXTENSION)); if($ext!=='csv'){return ['ok'=>false,'seccion'=>'egreso','msg'=>'Formato inválido'];}
        $archivo = substr($fname,0,-4); $archivoEsc=$conexion->real_escape_string($archivo); $feedlotEsc=$conexion->real_escape_string($feedlot);
        $check="SELECT COUNT(tropa) c FROM egresos WHERE tropa='$archivoEsc' AND feedlot='$feedlotEsc'"; if(($r=$conexion->query($check))&&($rw=$r->fetch_assoc())&&(int)$rw['c']!==0){return ['ok'=>false,'seccion'=>'egreso','msg'=>'Tropa ya utilizada'];}
        $fh=fopen($files['fileEgr']['tmp_name'],'r'); if(!$fh){return ['ok'=>false,'seccion'=>'egreso','msg'=>'No se pudo abrir'];}
        $totalAnimales=0; $pesoTotal=0; $contador=0; $totalGdm=0; $totalGpv=0; $animalesPromediar=0; $destino=''; $fecha='';
        while(($data=fgetcsv($fh,1000,';'))!==false){ if($contador>=1){ $IDE=$data[0]??''; $peso=(float)($data[1]??0); $pesoTotal+=$peso; $notas=$data[2]??''; $raza=$data[3]??''; $sexo=$data[4]??''; $proveedor=$data[5]??''; $numeroDTE=$data[6]??''; $origen=$data[7]??''; $destino=$data[8]??''; $gdmTotal=(float)($data[9]??0); $gpvTotal=(float)($data[10]??0); if($gdmTotal!=0){$totalGdm+=$gdmTotal; $totalGpv+=$gpvTotal; $animalesPromediar++;} $diasTotal=$data[11]??0; $fraw=$data[12]??''; if($fraw){$parts=explode('/',$fraw); $fecha=$parts[2]."-".$parts[1]."-".$parts[0];} $hora=$data[13]??''; $sql="INSERT INTO egresos(feedlot,tropa,IDE,peso,raza,sexo,proveedor,numeroDTE,origen,destino,notas,gdmTotal,gpvTotal,diasTotal,fecha,hora) VALUES('$feedlotEsc','$archivoEsc','".$conexion->real_escape_string($IDE)."','$peso','".$conexion->real_escape_string($raza)."','".$conexion->real_escape_string($sexo)."','".$conexion->real_escape_string($proveedor)."','".$conexion->real_escape_string($numeroDTE)."','".$conexion->real_escape_string($origen)."','".$conexion->real_escape_string($destino)."','".$conexion->real_escape_string($notas)."','$gdmTotal','$gpvTotal','$diasTotal','".$conexion->real_escape_string($fecha)."','".$conexion->real_escape_string($hora)."')"; $conexion->query($sql); $totalAnimales++; }
            $contador++; }
        fclose($fh);
        if($totalAnimales>0){ $pesoProm=$pesoTotal/$totalAnimales; $pesoProm=number_format($pesoProm,2,'.',''); $gdmProm=$animalesPromediar?number_format($totalGdm/$animalesPromediar,2,'.',''):0; $gpvProm=$animalesPromediar?number_format($totalGpv/$animalesPromediar,2,'.',''):0; $conexion->query("INSERT INTO registroegresos(feedlot,tropa,fecha,cantidad,destino,pesoPromedio,gmdPromedio,gpvPromedio) VALUES('$feedlotEsc','$archivoEsc','".$conexion->real_escape_string($fecha)."','$totalAnimales','".$conexion->real_escape_string($destino)."','$pesoProm','$gdmProm','$gpvProm')"); }
        return ['ok'=>true,'seccion'=>'egreso','msg'=>'Egreso cargado'];
    }

    public function uploadMuertesCSV(string $feedlot, \mysqli $conexion, array $post, array $files): array {
        if(!isset($files['fileMuertes'])||$files['fileMuertes']['error']!==UPLOAD_ERR_OK){return ['ok'=>false,'seccion'=>'muerte','msg'=>'Archivo no recibido'];}
        $fname=$files['fileMuertes']['name']; $ext=strtolower(pathinfo($fname,PATHINFO_EXTENSION)); if($ext!=='csv'){return ['ok'=>false,'seccion'=>'muerte','msg'=>'Formato inválido'];}
        $tropa=substr($fname,0,-4); $tropaEsc=$conexion->real_escape_string($tropa); $feedlotEsc=$conexion->real_escape_string($feedlot);
        $check="SELECT COUNT(tropa) c FROM muertes WHERE tropa='$tropaEsc' AND feedlot='$feedlotEsc'"; if(($r=$conexion->query($check))&&($rw=$r->fetch_assoc())&&(int)$rw['c']!==0){return ['ok'=>false,'seccion'=>'muerte','msg'=>'Tropa ya utilizada'];}
        $fh=fopen($files['fileMuertes']['tmp_name'],'r'); if(!$fh){return ['ok'=>false,'seccion'=>'muerte','msg'=>'No se pudo abrir'];}
        $contador=0; $fecha=''; $causaMuerte=$post['causaMuerte']??''; while(($data=fgetcsv($fh,1000,';'))!==false){ if($contador>=1){ $IDE=$data[0]??''; $peso=(float)($data[1]??0); $notas=$data[2]??''; $sexo=$data[3]??''; $proveedor=$data[4]??''; $corral=$data[5]??''; $origen=$data[6]??''; $diasTotal=$data[7]??0; $causaMuerteAnimal=$data[8]??''; $fraw=$data[9]??''; if($fraw){$parts=explode('/',$fraw); $fecha=$parts[2]."-".$parts[1]."-".$parts[0];} $hora=$data[10]??''; $sql="INSERT INTO muertes(feedlot,tropa,IDE,peso,sexo,proveedor,corral,origen,totalDias,causaMuerte,fecha,hora) VALUES('$feedlotEsc','$tropaEsc','".$conexion->real_escape_string($IDE)."','$peso','".$conexion->real_escape_string($sexo)."','".$conexion->real_escape_string($proveedor)."','".$conexion->real_escape_string($corral)."','".$conexion->real_escape_string($origen)."','$diasTotal','".$conexion->real_escape_string($causaMuerteAnimal)."','".$conexion->real_escape_string($fecha)."','".$conexion->real_escape_string($hora)."')"; $conexion->query($sql); }
            $contador++; }
        fclose($fh); return ['ok'=>true,'seccion'=>'muerte','msg'=>'Muertes cargadas'];
    }
}
