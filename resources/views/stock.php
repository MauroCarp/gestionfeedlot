<script src="<?php echo asset('js/stock.js'); ?>"></script>

<div class="container" style="padding-top: 50px;">

  <h1 style="display: inline-block;">STOCK</h1>

  <h4 style="display: inline-block;float: right;"><?php echo "<b style='font-size:1.5em;color:#fde327;text-shadow: 1px 2px 5px rgba(100,100,100,0.95);'><i>".$feedlot."</i></b> -  Fecha: ".$fechaDeHoy;?></h4>

  <div class="hero-unit" style="padding-top: 10px;margin-bottom: 5px;">

    <h2>Stock: <?php echo number_format($stock,0,",",".");?> Animales</h2>

    <div class="bs-docs-example">

      <ul id="myTab" class="nav nav-tabs">
  
        <li <?php if($seccion == 'ingreso' OR $seccion == ''){ echo "class=\"active\"";}?>><a href="#ingresos" data-toggle="tab" id="btnIngresos"><b>Ingresos</b></a></li>

        <li <?php if($seccion == 'egreso'){ echo "class=\"active\"";}?>><a href="#egresos" data-toggle="tab" id="btnEgresos"><b>Egresos</b></a></li>

        <li <?php if($seccion == 'muerte'){ echo "class=\"active\"";}?>><a href="#muertes" data-toggle="tab" id="btnMuertes"><b>Muertes</b></a></li>

      </ul>
    
      <div id="myTabContent" class="tab-content">

        <div class="tab-pane fade <?php if($seccion == 'ingreso' OR $seccion == ''){ echo 'active in';}?>" id="ingresos">

          <div class="row-fluid">

            <div class="span6">

              <div class="bs-docs-example">
                  
                  <div class="breadcrumb">
              
                  <?php 
                    // Migrated to partial view
                    include __DIR__ . '/partials/ingreso-balanza.php';
                  ?>
            
                </div>
                
              </div>

            </div>
          
            <div class="span6">

              <div class="bs-docs-example">
                
                <div class="breadcrumb">
                
                <?php
                  include __DIR__ . '/partials/info-ingresos.php';
                ?>
                
                </div>

              </div>

            </div>
          
          </div>

          <?php 
            include __DIR__ . '/partials/tabla-ingresos.php';
          ?>
          
        </div>

        <div class="tab-pane fade <?php if($seccion == 'egreso'){ echo 'active in';}?>" id="egresos">

          <div class="row-fluid">

            <div class="span6">

              <div class="bs-docs-example">
                  
                  <div class="breadcrumb">

                    <?php 
                      include __DIR__ . '/partials/egresos-balanza.php';
                    ?>

                </div>
          
              </div>

            </div>

            <div class="span6">

                <div class="bs-docs-example">
                    
                    <div class="breadcrumb">

                      <?php 
                        include __DIR__ . '/partials/info-egresos.php';
                      ?>
  
                  </div>
            
                </div>

            </div>

          </div>
        
          <?php 
            include __DIR__ . '/partials/tabla-egresos.php';
          ?>
        </div>

        <div class="tab-pane fade <?php if($seccion == 'muerte'){ echo 'active in';}?>" id="muertes">
        
          <div class="row-fluid">

            <div class="span6">

              <div class="bs-docs-example">
                  
                  <div class="breadcrumb">

                    <?php 
                      include __DIR__ . '/partials/muertes-balanza.php';
                    ?>

                </div>

              </div>

            </div>

            <div class="span6">

                <div class="bs-docs-example">
                    
                    <div class="breadcrumb">

                      <?php 
                        include __DIR__ . '/partials/info-muertes.php';
                      ?>

                  </div>

                </div>

            </div>

          </div>

            <?php 
              include __DIR__ . '/partials/tabla-muertes.php';
            ?>
  
        </div> 


      </div>

      <hr>
  
    </div>

    <span class="ir-arriba icon-arrow-up2"></span>

   </div>

</div>

<script src="<?php echo asset('js/functions.js'); ?>"></script>
<script src="<?php echo asset('js/informes.js'); ?>"></script>
<script src="<?php echo asset('js/insumos.js'); ?>"></script>
<script src="<?php echo asset('js/premix.js'); ?>"></script>
<script src="<?php echo asset('js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo asset('js/miselect.js'); ?>"></script>
<script src="<?php echo asset('js/Chart.bundle.min.js'); ?>"></script>
<script src="<?php echo asset('js/chart/samples/utils.js'); ?>"></script>
<script src="<?php echo asset('js/chartjs-plugin-labels.min.js'); ?>"></script>

<script type="text/javascript">
    // JavaScript inline del stock.php original
    $(document).ready(function(){
          $(".causaMuerteOtro").hide();
          $("#selectCausaMuerte").change(function(){
              $(".causaMuerteOtro").hide();
              var causa = $(this).val();
              if (causa == "otro") {
                  $("#mostrarOtra").show();
              }
          });

    });

    // Funciones legacy de filtrado y paginación comentadas - ahora se usa DataTables
    // DataTables proporciona búsqueda global, filtros por columna y paginación automática

    $(document).ready(function() {      
      $('.ir-arriba').click(function(){
        $('body, html').animate({
          scrollTop: '0px'
        }, 300);
      });
      $(window).scroll(function(){
        if( $(this).scrollTop() > 0 ){
          $('.ir-arriba').slideDown(300);
        } else {
          $('.ir-arriba').slideUp(300);
        }
      });
    });

    // Event listeners legacy eliminados - las tablas ahora usan DataTables automáticamente
</script>

<!-- MODAL CARGA MANUAL -->
<div class="modal fade" id="modalCargaManual" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Aviso</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <p style="font-weight:bold"> 
          Recorda renombrar el archivo, con el nombre de la tropa.
        </p>
      </div>
      <div class="modal-footer" style="padding: 0; padding-right: 15px;">
        <a href="#" id="descargarPlanillaManual"  download="" class="btn btn-secondary"><h5>Descargar Planilla</h5></a>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo asset('js/muertes.js'); ?>"></script>
