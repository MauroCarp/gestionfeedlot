<div class="modal fade" id="modal-estadisticas" style="width:500px;" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Estadisticas <span id="titleModalEstadistica">Ingresos</span></h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form style="margin-bottom: 10px;" method="POST">
        <div class="modal-body" style="overflow-x:hidden;">
          <button class="btn iconos" type="button" id='compararEstadistica'>Comparar</button>
          <div class="row-fluid">
            <div class="span12" id="inputsEst">
              <input type="hidden" name="compararValido" id="compararValido" value='false'>
              <span style="display: block;line-height: 10px;"><b>Periodo</b></span>
              <input type="date" name="desdeEstadisticas" required/>
              <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
              <input type="date" name="hastaEstadisticas" required/>
              <div class="form-group" id="inputProveedor">
                <label for="proveedorEst">Proveedor</label>
                <select name="proveedorEst" id="proveedorEst"></select>
              </div>
              <div class="form-group" id="inputOrigen">
                <label for="origenEst">Origen</label>
                <select name="origenEst" id="origenEst"></select>
              </div>
              <div class="form-group hidden" id="inputRaza">
                <label for="razaEst">Raza</label>
                <select name="razaEst" id="razaEst"></select>
              </div>
              <div class="form-group" id="inputSexo">
                <label for="sexoEst">Sexo</label>
                <select name="sexoEst" id="sexoEst"></select>
              </div>
              <div class="form-group hidden" id="inputGMD">
                <label for="gmdEst">GMD</label>
                <input type="number" step='0.01' name="gmdEst" id="gmdEst"></input>
              </div>
              <div class="form-group hidden" id="inputGPV">
                <label for="gpvEst">GPV</label>
                <input type="number" step='0.01' name="gpvEst" id="gpvEst"></input>
              </div>
              <div class="form-group hidden" id="inputDestino">
                <label for="destinoEst">Destino</label>
                <select name="destinoEst" id="destinoEst"></select>
              </div>
              <div class="form-group hidden" id="inputCausaMuerte">
                <label for="causaMuerteEst">Causa Muerte</label>
                <select name="causaMuerteEst" id="causaMuerteEst"></select>
              </div>
            </div>
            <div class="span6 hidden" style="display:none" id="inputsEstComparar">
              <span style="display: block;line-height: 10px;"><b>Periodo</b></span>
              <input type="date" name="desdeEstadisticasComparar" required/>
              <span style="font-size: 18px;"><b>&nbsp Hasta &nbsp</b></span>
              <input type="date" name="hastaEstadisticasComparar" required/>
              <div class="form-group" id="inputProveedorComparar">
                <label for="proveedorEstComparar">Proveedor</label>
                <select name="proveedorEstComparar" id="proveedorEstComparar"></select>
              </div>
              <div class="form-group" id="inputOrigenComparar">
                <label for="origenEstComparar">Origen</label>
                <select name="origenEstComparar" id="origenEstComparar"></select>
              </div>
              <div class="form-group hidden" id="inputRazaComparar">
                <label for="razaEstComparar">Raza</label>
                <select name="razaEstComparar" id="razaEstComparar"></select>
              </div>
              <div class="form-group" id="inputSexoComparar">
                <label for="sexoEstComparar">Sexo</label>
                <select name="sexoEstComparar" id="sexoEstComparar"></select>
              </div>
              <div class="form-group hidden" id="inputGMDComparar">
                <label for="gmdEstComparar">GMD</label>
                <input type="number" step='0.01' name="gmdEstComparar" id="gmdEstComparar"></input>
              </div>
              <div class="form-group hidden" id="inputGPVComparar">
                <label for="gpvEstComparar">GPV</label>
                <input type="number" step='0.01' name="gpvEstComparar" id="gpvEstComparar"></input>
              </div>
              <div class="form-group hidden" id="inputDestinoComparar">
                <label for="destinoEstComparar">Destino</label>
                <select name="destinoEstComparar" id="destinoEstComparar"></select>
              </div>
              <div class="form-group hidden" id="inputCausaMuerteComparar">
                <label for="causaMuerteEstComparar">Causa Muerte</label>
                <select name="causaMuerteEstComparar" id="causaMuerteEstComparar"></select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="padding: 0; padding-right: 15px;">
          <button type="submit" class="btn btn-primary" id="btnInformeEstadisticas"><b>Generar Informe</b></button>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>