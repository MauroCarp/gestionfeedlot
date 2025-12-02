<h3><b>Muertes por balanza</b></h3>

<form name="f1" class="form-horizontal" method="POST" action="?route=stock&accion=uploadMuertes&seccion=muerte" enctype="multipart/form-data"> 

  <div class="row-fluid">
    
    <div class="span12">
    
      <div class="control-group"> 
      
        <label class="control-label" style="font-size:1.1em;"><b>Causa de Muerte:</b></label>
      
        <div class="controls">
      
            <select name="causaMuerte" id="selectCausaMuerte" class="form-control input-large">
            <option value="">Seleccionar Causa Muerte</option>
            <?php if(isset($causasMuertesRef) && is_array($causasMuertesRef) && count($causasMuertesRef)>0){
              foreach($causasMuertesRef as $c){
                echo "<option value='".htmlspecialchars($c,ENT_QUOTES)."'>".htmlspecialchars($c)."</option>";
              }
            } else {
              // Fallback legacy opciones
              $fallback = ['Accidente','Digestivo','Ingreso','Nervioso','Rechazo','Respiratorio','Sin Diagnostico','Sin Hallazgo','Otro'];
              foreach($fallback as $c){
                echo "<option value='".htmlspecialchars($c,ENT_QUOTES)."'>".htmlspecialchars($c)."</option>";
              }
            } ?>
            </select>
      
        </div>
      
      </div>           
    
    </div>

  </div>

  <div class="row-fluid">

    <div class="span4">
      
      <label for="file-uploadMuertes" class="btn btn-primary btn-block">
          <i class="fas fa-cloud-upload-alt"></i> Seleccionar archivo
      </label>
      
      <input id="file-uploadMuertes" onchange="cambiar('file-uploadMuertes','infoMuertes')" type="file" name="fileMuertes" style='display: none;' required/>
    
    </div>
    
    <div class="span5">
      
      <div class="span" id="infoMuertes" style="text-align: left;font-weight: bold;">Seleccionar archivo</div>
      
    </div>

    
    <div class="span3">

      <button type="submit" class="btn btn-primary btn-block" name="submitIng"><b>Cargar</b></button>
      
    </div>


  </div>

</form>

<hr>

<a href="#" data-toggle="modal" data-target="#modalCargaManual" class="descargarPlanillas"  seccion="muertes"><h5>Descargar Planilla Muertes Manual</h5></a>