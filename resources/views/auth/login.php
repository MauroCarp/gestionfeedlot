<?php /* Vista login mejorada similar legacy */ ?>
<style>
  .login-wrapper {margin-top:40px;padding:25px;border:1px solid #ccc;border-radius:8px;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,.15);} 
  .login-header {text-align:center;margin-bottom:15px;} 
  .login-header img{max-height:120px;margin-bottom:10px;} 
  .login-footer {margin-top:15px;font-size:12px;color:#666;text-align:center;} 
  .login-wrapper input[type=text], .login-wrapper input[type=password]{width:95%;} 
  .alert {margin-top:10px;}
</style>
<div class="row">
  <div class="span4 offset4">
    <div class="login-wrapper">
      <div class="login-header">
        <img src="<?= asset('img/logo1.png') ?>" alt="Logo Feedlot" style="height:120px;">
      </div>
      <form class="form" method="POST" action="<?= route_url('login.auth') ?>">
        <label>Usuario</label>
        <input type="text" name="ingUsuario" value="" autofocus required>
        <label>Contraseña</label>
        <input type="password" name="ingPassword" required>
        <button class="btn btn-primary btn-block" type="submit" name="btnIngresar">Ingresar</button>
      </form>
      <div class="login-footer">
        <span>&copy; <?= date('Y') ?> Feedlot</span>
      </div>
    </div>
  </div>
</div>
