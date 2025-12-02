<script src="<?php echo asset('js/usuarios.js'); ?>"></script>

<div class="container" style="padding-top: 50px;">
    <h1 style="display: inline-block;">USUARIOS</h1>
    <h4 style="display: inline-block;float: right;">
        <?php echo "<b style='font-size:1.5em;color:#fde327;text-shadow: 1px 2px 5px rgba(100,100,100,0.95);'><i>".$feedlot."</i></b> -  Fecha: ".$fechaDeHoy;?>
    </h4>
    <hr>

    <?php if(!empty($flash_success)): ?>
        <div class="alert alert-success"><?php echo $flash_success; ?></div>
    <?php endif; ?>
    <?php if(!empty($flash_error)): ?>
        <div class="alert alert-error"><?php echo $flash_error; ?></div>
    <?php endif; ?>

    <div class="hero-unit" style="padding-top:10px;">
        <button data-toggle="modal" data-target="#modalNuevoUsuario" class="btn btn-primary"><b>Nuevo Usuario</b></button>
        <hr>
        <table class="table table-striped tablaUsuarios">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Feedlot</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuariosData as $u): ?>
                    <tr>
                        <td><?php echo $u['nombre']; ?></td>
                        <td><?php echo $u['user']; ?></td>
                        <td><?php echo $u['feedlot']; ?></td>
                        <td>
                            <div class='btn-group btn-group-lg' role='group'>
                                <button type='button' class='btn btn-danger btnEliminarUsuario' idUsuario='<?php echo $u['id']; ?>'>
                                    <span class='icon-bin2 iconos'></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Nuevo Usuario -->
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="<?php echo route_url('usuarios'); ?>&accion=nuevoUsuario" method="post">
        <div class="modal-body">
          <div class="bs-example">
            <div class="form-group">
              <label for="nombreUsuario">Nombre</label>
              <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Nombre">
            </div>
            <div class="form-group">
              <label for="userUsuario">Usuario</label>
              <input type="text" class="form-control" id="userUsuario" name="userUsuario" placeholder="Usuario">
            </div>
            <div class="form-group">
              <label for="passwordUsuario">Contrase&ntilde;a</label>
              <input type="password" class="form-control" id="passwordUsuario" name="passwordUsuario" placeholder="Contraseña">
            </div>
            <div class="form-group">
              <label for="feedlotUsuario">Feedlot</label>
              <select name="feedlotUsuario" id="feedlotUsuario" class="form-control">
                <?php foreach($feedlotsData as $f): ?>
                  <option value="<?php echo $f['feedlot']; ?>"><?php echo $f['feedlot']; ?></option>
                <?php endforeach; ?>
                <option value='nuevoFeedlot'>Nuevo</option>
              </select>
              <input type="text" name="nuevoFeedlot" id="nuevoFeedlot" class="form-control hidden" placeholder="Nuevo Feedlot">
            </div>
          </div>
        </div>
        <div class="modal-footer" style="padding: 0; padding-right: 15px;">
          <button id="btnNuevoUsuario" class="btn btn-secondary"><b>Cargar Usuario</b></button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="<?php echo asset('js/functions.js'); ?>"></script>
<script src="<?php echo asset('js/miselect.js'); ?>"></script>