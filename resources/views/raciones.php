<div class="container" style="padding-top: 50px;">

  <h1 style="display: inline-block;">Raciones</h1>

<h4 style="display: inline-block;float: right;"><?php echo "<b style='font-size:1.5em;color:#fde327;text-shadow: 1px 2px 5px rgba(100,100,100,0.95);'><i>".$feedlot."</i></b> -  Fecha: ".$fechaDeHoy;?></h4>

<hr style="padding:0;margin-top:0;">

<div class="hero-unit" style="padding-top: 10px;">

    <div class="bs-docs-example">

      <ul id="myTab" class="nav nav-tabs">

        <li <?php if($seccion == 'ingreso' OR $seccion == ''){ echo "class=\"active\"";}?>><a href="#ingresos" data-toggle="tab" class="labels">Ingreso</a></li>

        <li <?php if($seccion == 'insumos'){ echo "class=\"active\"";}?>><a href="#insumos" data-toggle="tab" class="labels">Insumos</a></li>

        <li <?php if($seccion == 'formulas'){ echo "class=\"active\"";}?>><a href="#formulas" data-toggle="tab" class="labels">Formulas</a></li>

        <li <?php if($seccion == 'premix'){ echo "class=\"active\"";}?>><a href="#premix" data-toggle="tab" class="labels">Premix</a></li>

        <li <?php if($seccion == 'mixer'){ echo "class=\"active\"";}?>><a href="#mixer" data-toggle="tab" class="labels">Mixer</a></li>

      </ul>

      <div id="myTabContent" class="tab-content">

        
        <div class="tab-pane fade <?php if($seccion == 'insumos'){ echo 'active in';}?>" id="insumos">

          <?php include(__DIR__ . "/partials/insumos.php");?>

        </div>


        <div class="tab-pane fade <?php if($seccion == 'formulas'){ echo 'active in';}?>" id="formulas">

          <?php 
          if ($accionValido) {

            if ($accion == "modificar") {

              $id = $_GET['id'];

              include(__DIR__ . "/partials/modificarFormula.php");

            }

          }else{

            include(__DIR__ . "/partials/formulas.php");

          }

          ?>

        </div>

        <div class="tab-pane fade <?php if($seccion == 'mixer'){ echo 'active in';}?>" id="mixer">

        <?php include(__DIR__ . "/partials/mixer.php");?>

        </div>
        
        <div class="tab-pane fade <?php if($seccion == 'premix'){ echo 'active in';}?>" id="premix">

        <?php 
        
        if ($accionValido) {
          
          if ($accion == "modificarPremix") {
            
            $id = $_GET['id'];
            
            include(__DIR__ . "/partials/modificarPremix.php");
            
          }
          
        }else{
          
          include(__DIR__ . "/partials/premix.php");

        }
        
        ?>

        </div>
       
        <div class="tab-pane fade <?php if($seccion == 'ingreso' OR $seccion == ''){ echo 'active in';}?>" id="ingresos">

          <?php include(__DIR__ . "/partials/ingresoRacion.php");?>

        </div>

      </div>
    </div>
  </div>

</div> <!-- /container -->

<script src="<?php echo asset('js/functions.js'); ?>?v=<?php echo time(); ?>"></script>
<script src="<?php echo asset('js/informes.js'); ?>?v=<?php echo time(); ?>"></script>
<script src="<?php echo asset('js/insumos.js'); ?>?v=<?php echo time(); ?>"></script>
<script src="<?php echo asset('js/premix.js'); ?>?v=<?php echo time(); ?>"></script>
<!-- Bootstrap ya se carga en head.php, no duplicar -->
<script src="<?php echo asset('js/miselect.js'); ?>"></script>
<!-- Chart.js ya se carga en head.php, no duplicar -->

<script type="text/javascript">

    var mixer = (document).getElementById('selectMixer');
    
    mixer.addEventListener('change',()=>{

      var tipoMixer = $('#selectMixer').val();

      if(tipoMixer == 'mixer2'){

        $('#mixer2cantidad').css('display','block');

        $('form').attr('action','ingresoMixer2.php');

      }else{

        $('form').attr('action','ingresoMixer1.php');

        $('#mixer2cantidad').css('display','none');


      }

    });

    $('.collapse').css('display','block');
    

    $(document).ready(function() {
        $('.mi-selector').select2();
    });
    
</script>
