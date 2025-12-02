<div class="modal fade" id="modal-StatusSanitario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 0">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Informe de Status</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form style="margin-bottom: 10px;" method="POST" action="imprimirStatus.php" target="_blank">
        <div class="modal-body">
          <span style="display: block;line-height: 10px;"><b>Periodo</b></span>
          <input type="date" name="desde" required/>
          <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
          <input type="date" name="hasta" required/>
        </div>
        <div class="modal-footer" style="padding: 0; padding-right: 15px;">
          <button type="submit" class="btn btn-primary">Imprimir</button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>