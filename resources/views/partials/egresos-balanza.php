<h3><b>Egresos por balanza</b></h3>

<form name="f1" class="form-horizontal" method="POST" action="?route=stock&accion=uploadEgreso&seccion=egreso" enctype="multipart/form-data"> 
  
<div class="row-fluid">
  
  <div class="span4">
  
    <label for="file-uploadEgr" class="btn btn-primary btn-block"><i class="fas fa-cloud-upload-alt"></i>Seleccionar archivo</label>
    
    <input id="file-uploadEgr" onchange="cambiar('file-uploadEgr','infoEgr')" type="file" name="fileEgr" style='display: none;' required/>
  
  </div>
  
  <div class="span5" id="infoEgr" style="text-align: left;font-weight: bold;">Seleccionar Archivo</div>
  
  <div class="span3">

    <button type="submit" class="btn btn-primary btn-block" name="submitEgr"><b>Cargar</b></button>

  </div>
  
  </div>
  
</form>

<hr>

<a href="#" data-toggle="modal" data-target="#modalCargaManual" class="descargarPlanillas"  seccion="egresos"><h5>Descargar Planilla Egresos Manual</h5></a>
<?php if(isset($destinosEgresos) && is_array($destinosEgresos) && count($destinosEgresos)>0){ ?>
  <div class="row-fluid" style="margin-top:10px;">
    <div class="span6">
      <label><b>Destino:</b></label>
      <select name="destinoEgreso" form="f1">
        <?php foreach($destinosEgresos as $d){ echo "<option value='".htmlspecialchars($d,ENT_QUOTES)."'>".htmlspecialchars($d)."</option>"; } ?>
        <option value="otroDestinoEgresos">Otro</option>
      </select>
      <input type="text" name="otroDestinoEgresos" id="otroDestinoEgresos" style="display:none;" placeholder="Otro Destino">
    </div>
  </div>
<?php } ?>