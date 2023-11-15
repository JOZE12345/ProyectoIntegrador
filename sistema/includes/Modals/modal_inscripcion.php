<div class="modal fade" id="modalFormInscripcion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Inscripcion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="tile-body">
                <form id="formInscripcion" name="formInscripcion">
                    <input type="hidden" name="idInscripcion" id="idInscripcion" value="">
                    <div class="form-group">
                        <label for="exampleSelect1">Seleccione Alumno</label>
                        <select class="form-control" name="listAlumno" id="listAlumno" required>
                        
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Seleccione el Curso</label>
                        <select class="form-control" name="listCurso" id="listCurso" required>
                        
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelect1">Turno</label>
                        <select class="form-control" name="listTurno" id="listTurno" required>
                        
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