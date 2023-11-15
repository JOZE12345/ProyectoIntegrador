<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="modalFormUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                <form id="formUser" name="formUser">
                    <input type="hidden" name="idUser" id="idUser" value="">
                    <div class="form-group">
                    <label class="control-label">Nombre</label>
                    <input class="form-control" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del usuario" required>
                    </div>
                    <div class="form-group">
                    <label class="control-label">Usuario</label>
                    <input type="text" class="form-control" id="txtUsuario" name="txtUsuario" placeholder="Usuario" required>
                    </div>
                    <div class="form-group">
                    <label class="control-label">Contraseña</label>
                    <input type="password" class="form-control validPass" id="clave" name="clave" placeholder="Contraseña">
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Rol</label>
                        <select class="form-control" name="listRol" id="listRol" required>
                            <option value="1">Administrador</option>
                            <option value="2">Asistente</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Estado</label>
                        <select class="form-control" name="listStatus" id="listStatus" required>
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>