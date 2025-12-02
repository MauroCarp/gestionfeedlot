<?php

$menu = array();

$menu['Stock'] = route_url('stock');

$menu['Estadisticas'] = '';

$menu['Status Sanitario'] = route_url('status');

$menu['Raciones'] = route_url('raciones');

if(isset($_SESSION['usuario']) && in_array($_SESSION['usuario'], ['Jcornale','Tecnico'], true)){
  $menu['Usuarios'] = route_url('usuarios');
}

$menu['Salir'] = route_url('logout');


 ?>

 <a class="brand" href="index.php" style="font-size:20px;"><b>GESTION DE FEEDLOT - J CORNALE</b></a>

 <div class="nav-collapse collapse">
  
  <ul class="nav">
    <?php
        foreach ($menu as $titulo => $valor) { 
          
          if ($titulo == 'Raciones' OR $titulo == 'Usuarios' OR $titulo == 'Salir') { ?>
          
            <li class="nav-item dropdown">
            
              <a 
              class="nav-link dropdown-toggle"
              style="font-size:20px;"
              href="<?php echo $valor;?>"><b><?php echo $titulo; ?></b>
              </a>

            </li>

        <?php }else{
        
          $id = ($titulo != 'Stock') ? 'Status' : $titulo;

        ?>

          
          <li class="nav-item dropdown">
           
            <a class="nav-link dropdown-toggle flecha" id="btn<?php echo $id;?>" style="font-size:20px;" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><b><?php echo $titulo;?></b></a>
            
            <ul class="dropdown-menu" id="menu<?php echo $id?>">

              <?php

              if ($titulo == 'Status Sanitario') { ?>
              
                
                <li><a class="dropdown-item" style="font-size:18px;" href="<?php echo $valor;?>">Registros</a></li>
                
                <li><a class="dropdown-item" style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modal-StatusSanitario">Imprimir Status</a></li>

                <?php

              }

              if($titulo == 'Estadisticas'){ ?>

                <li><a class="dropdown-item menuEst" style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modal-estadisticas" seccion="ingresos">Ingresos</a></li>
                <li><a class="dropdown-item menuEst" style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modal-estadisticas" seccion="egresos">Egresos</a></li>
                <li><a class="dropdown-item menuEst" style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modal-estadisticas" seccion="muertes">Muertes</a></li>

                <?php 
              }
              
              if($titulo == 'Stock'){
              ?>

                <li><a class="dropdown-item" style="font-size:18px;" href="<?php echo $valor;?>">Ingresar Registro</a></li>
                <li><a class="dropdown-item" id="btnInformeStock" style="cursor:pointer;font-size:18px;" data-toggle="modal" data-target="#modal-<?php echo $titulo;?>">Informe</a></li>

              <?php
              }
              ?>

            </ul>

          </li>

        <?php

        }}

      ?>
  </ul>

</div>
<?php
// Modales extraídos a parciales para evitar duplicación
require __DIR__ . '/../resources/views/partials/modal-stock.php';
require __DIR__ . '/../resources/views/partials/modal-status.php';
require __DIR__ . '/../resources/views/partials/modal-raciones.php';
require __DIR__ . '/../resources/views/partials/modal-estadisticas.php';
?>



