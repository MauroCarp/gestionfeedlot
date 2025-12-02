<div class="modal fade" id="modal-Stock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Informe de Stock</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form style="margin-bottom: 10px;" method="POST" action="informe.php?seccion=stock">
        <div class="modal-body">
          <span style="display: block;line-height: 10px;"><b>Periodo</b></span>
          <input type="date" name="desde" required/>
          <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
          <input type="date" name="hasta" required/>
          <hr style="margin:0;">
          <div id="divComparar"  style="display:none;">
            <h4 style="cursor: pointer;" onclick="comparacion('Stock')">Comparar</h4>
            <div id="compararStock" style="display:none">  
              <span style="display: block;line-height: 10px;"><b>Periodo 2</b></span>
              <input type="date" name="desdeComp"/>
              <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
              <input type="date" name="hastaComp"/>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="padding: 0; padding-right: 15px;">
          <button type="submit" class="btn btn-primary"><b>Generar</b></button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>