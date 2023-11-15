$('#tableInscripciones').DataTable();
var tableInscripciones;

window.addEventListener('DOMContentLoaded',function(){
    tableInscripciones = $('#tableInscripciones').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "./models/inscripciones/table_inscripciones.php",
            "dataSrc": ""
        },
        "columns": [
            {"data":"inscripcion_id"},
            {"data":"nombre"},
            {"data":"nombre_materia"},
            {"data":"tipo_turno"},
            {"data":"estatusI"},
            {"data":"options"},
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
    });

    // CREAR INSCRIPCION
    var formInscripcion = document.querySelector('#formInscripcion');
    formInscripcion.onsubmit = function(e) {
        e.preventDefault();

        var idInscripcion = document.querySelector('#idInscripcion').value;
        var alumno = document.querySelector('#listAlumno').value;
        var curso = document.querySelector('#listCurso').value;
        var turno = document.querySelector('#listTurno').value;
        var status = document.querySelector('#listStatus').value;

        if(alumno == '' || curso == '' || turno == '' || status == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/inscripciones/ajax_inscripciones.php';
        var formData = new FormData(formInscripcion);
        request.open('POST',ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormInscripcion').modal('hide');
                    formInscripcion.reset();
                    swal('Crear Inscripcion',objData.msg,'success');
                    tableInscripciones.ajax.reload(function(){
                        editInscripcion();
                        delInscripcion();
                    })
                } else {
                    swal('Atencion',objData.msg,'error');
                }
            }
        }

    }
});

window.addEventListener('load',function(){
    editInscripcion();
    delInscripcion();
    getOptionAlumnos();
    getOptionCursos();
    getOptionTurnos();
},false);

function getOptionAlumnos() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = './models/options/options-alumnos.php';
    request.open('GET',ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var option = JSON.parse(request.responseText);
            option.forEach(function(valor){
               option += '<option value="'+valor.alumno_id+'">'+valor.nombre+' '+valor.apellido+'</option>';  
            });
            document.querySelector('#listAlumno').innerHTML = option;
        }
    }
}
function getOptionCursos() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = './models/options/options-cursos.php';
    request.open('GET',ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var option = JSON.parse(request.responseText);
            option.forEach(function(valor){
               option += '<option value="'+valor.curso_id+'">Materia: '+valor.nombre_materia+', Profesor: '+valor.nombre+'</option>';  
            });
            document.querySelector('#listCurso').innerHTML = option;
        }
    }
}
function getOptionTurnos() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = './models/options/options-turnos.php';
    request.open('GET',ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var option = JSON.parse(request.responseText);
            option.forEach(function(valor){
               option += '<option value="'+valor.turno_id+'">'+valor.tipo_turno+'</option>';  
            });
            document.querySelector('#listTurno').innerHTML = option;
        }
    }
}

function editInscripcion() {
    var btnEditInscripcion = document.querySelectorAll('.btnEditInscripcion');
    btnEditInscripcion.forEach(function(btnEditInscripcion){
        btnEditInscripcion.addEventListener('click',function(){
            document.querySelector('#titleModal').innerHTML = 'Actualizar Inscripcion';
            document.querySelector('.modal-header').classList.replace('headerRegister','updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary','btn-info');
            document.querySelector('#btnText').innerHTML = 'Actualizar';

            var idInscripcion = this.getAttribute('rl');

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/inscripciones/edit_inscripciones.php?id='+idInscripcion;
            request.open('GET',ajaxUrl,true);
            request.send();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        document.querySelector('#idInscripcion').value = objData.data.inscripcion_id;
                        document.querySelector('#listAlumno').value = objData.data.alumno_id;
                        document.querySelector('#listCurso').value = objData.data.curso_id;
                        document.querySelector('#listTurno').value = objData.data.turno_id;
                        document.querySelector('#listStatus').value = objData.data.estatusI;

                        if(objData.data.estatusI == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                        }
                        var htmlOption = `${optionSelect}
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                        `;
                        document.querySelector('#listStatus').innerHTML = htmlOption;

                        $('#modalFormInscripcion').modal('show');
                    } else {
                        swal('Atencion',objData.msg,'error');
                    }
                }
            }
        })
    })
}

function delInscripcion() {
    var btnDelInscripcion = document.querySelectorAll('.btnDelInscripcion');
    btnDelInscripcion.forEach(function(btnDelInscripcion){
        btnDelInscripcion.addEventListener('click',function(){
            var idInscripcion = this.getAttribute('rl');

            swal({
                title: "Eliminar Inscripcion",
                text: "Realmente desea eliminar la inscripcion?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },function(Confirm){
                if(Confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxDelInscripcion = './models/inscripciones/delet_inscripcion.php';
                    var strData = "idInscripcion="+idInscripcion;
                    request.open('POST',ajaxDelInscripcion,true);
                    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if(request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if(objData.status) {
                                swal("Eliminar!", objData.msg , "success");
                                tableInscripciones.ajax.reload(function(){
                                    delInscripcion();
                                    editInscripcion();
                                });
                            } else {
                                swal("Atencion",objData.msg,"error");
                            }
                        }
                    }
                }
            })
        })
    })
}

function openModalInscripcion() {
    document.querySelector('#idInscripcion').value = "";
    document.querySelector('#titleModal').innerHTML = 'Nueva Inscripcion';
    document.querySelector('.modal-header').classList.replace('updateRegister','headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info','btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#formInscripcion').reset();
    $('#modalFormInscripcion').modal('show');
}
