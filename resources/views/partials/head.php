
<!DOCTYPE html>

<html lang="es">

  <head>

    <meta charset="utf-8">

    <title>JORGE CORNALE - GESTION DE FEEDLOT</title>

    <link rel="icon" href="<?php echo asset('img/ico.ico'); ?>" type="image/x-icon"/>

    <link rel="shortcut icon" href="<?php echo asset('img/ico.ico'); ?>" type="image/x-icon"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
      $script = $_SERVER['SCRIPT_NAME'] ?? '';
      if (strpos($script,'/public/') !== false) {
        echo '<base href="/gestionfeedlot/public/">';
      }
    ?>

    <script src="<?php echo asset('js/jquery-2.2.4.min.js'); ?>"></script>
    <!-- Cargar Bootstrap JS global para dropdowns y collapse -->
    <script src="<?php echo asset('js/bootstrap.min.js'); ?>"></script>

    <link href="<?php echo asset('css/bootstrap.css'); ?>" rel="stylesheet">
    
    <link href="<?php echo asset('css/style.css'); ?>" rel="stylesheet">

    <link href="<?php echo asset('css/bootstrap-responsive.css'); ?>" rel="stylesheet">

    <link href="<?php echo asset('css/miselect.css'); ?>" rel="stylesheet">
    
    <script src="<?php echo asset('js/menu.js'); ?>"></script>

    <script src="<?php echo asset('js/chart/samples/utils.js'); ?>"></script>

    <script src="<?php echo asset('js/Chart.bundle.min.js'); ?>"></script>

    <script src="<?php echo asset('js/chartjs-plugin-labels.min.js'); ?>"></script>

    <script src="<?php echo asset('js/mixer.js'); ?>"></script>
    
    <script src="<?php echo asset('js/formulas.js'); ?>"></script>
    <!-- DataTables local fallback (prefer local to avoid CDN bloqueo) -->
    <link rel="stylesheet" href="<?php echo asset('vendor/datatables/jquery.dataTables.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo asset('vendor/datatables/fixedHeader.dataTables.min.css'); ?>"/>
    <link rel="stylesheet" href="<?php echo asset('css/datatables-custom.css'); ?>"/>
    <script src="<?php echo asset('vendor/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo asset('vendor/datatables/dataTables.fixedHeader.min.js'); ?>"></script>
    <!-- (Opcional) CDN para cuando haya conectividad -->
    <link rel="preload" as="style" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" onerror="this.remove()"/>
    <link rel="preload" as="style" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css" onerror="this.remove()"/>
    <script src="<?php echo asset('js/datatables-init.js'); ?>"></script>
    <script>
      // Fallback si DataTables no está disponible por algún motivo
      if(window.jQuery && !jQuery.fn.DataTable){
        console.warn('DataTables no disponible; intentando cargar fallback local nuevamente');
      }
    </script>
    <!-- Diagnóstico: verificar carga de plugin dropdown -->
    <script>
      document.addEventListener('DOMContentLoaded', function(){
        if(!window.jQuery){console.warn('jQuery no cargado');}
        else if(!jQuery.fn.dropdown){console.warn('Bootstrap dropdown no disponible');}
        else {console.log('Bootstrap dropdown OK');}
          // Diagnóstico adicional: listar hojas de estilo cargadas y reglas
          try {
            [].forEach.call(document.styleSheets, function(ss){
              var href = ss.href || '[inline]';
              var rulesCount = 0;
              try { rulesCount = ss.cssRules ? ss.cssRules.length : 0; } catch(e){ rulesCount = 'inaccesible'; }
              console.log('CSS:', href, 'rules:', rulesCount);
            });
          } catch(e){ console.warn('Inspección CSS falló', e); }
      });
    </script>
    
    <?php 
      // Mejor detección de login:
      // 1. Si la vista cargada es 'auth/login' (variable $name disponible desde layout_view)
      // 2. O si NO hay sesión iniciada y no viene route explícito (index.php fuerza login por defecto)
      $currentRouteParam = $_GET['route'] ?? null;
      $isLogin = false;
      if (isset($name) && $name === 'auth/login') {
        $isLogin = true;
      } elseif (empty($_SESSION['logged']) && ($currentRouteParam === null || $currentRouteParam === 'login')) {
        $isLogin = true;
      }
    ?>
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
        height:100%;
        <?php if($isLogin): ?>
        background: url('<?php echo asset('img/login-bg1.jpg'); ?>') no-repeat center center fixed;
        background-size: cover;
        <?php else: ?>
        background: rgb(255,245,173);
        background: linear-gradient(0deg, rgb(255, 245, 173) 0%, rgba(226,226,226,1) 30%);
        <?php endif; ?>
      }
      <?php if($isLogin): ?>
      body.login-page { padding-top:20px; }
      <?php endif; ?>
    </style>

  </head>

  <body class="<?php echo $isLogin ? 'login-page' : ''; ?>">

    <?php if(!$isLogin): ?>
    <div class="navbar navbar-inverse navbar-fixed-top">
    
      <div class="navbar-inner">
      
        <div class="container">
      
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
      
            <span class="icon-bar"></span>
      
            <span class="icon-bar"></span>
      
            <span class="icon-bar"></span>
      
          </button>
      
          <?php
          
          include(__DIR__ . "/../../../includes/nav.php");
          
          ?>
      
        </div>
    
      </div>
    
    </div>
    <?php endif; ?>