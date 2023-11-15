$('#tableCursos').DataTable();
var tableCursos;

document.addEventListener('DOMContentLoaded',function(){
    tableCursos = $('#tableCursos').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "./models/cursos/table_cursos.php",
            "dataSrc": ""
        },
        "columns": [
            {"data":"curso_id"},
            {"data":"nombre_materia"},
            {"data":"nombre"},
            {"data":"estatusC"},
            {"data":"options"},
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
    });

    // CREAR CURSO
    var formCurso = document.querySelector('#formCurso');
    formCurso.onsubmit = function(e) {
        e.preventDefault();
        var idCurso = document.querySelector('#idCurso').value;
        var materia = document.querySelector('#listMateria').value;
        var profesor = document.querySelector('#listProfesor').value;
        var status = document.querySelector('#listStatus').value;

        if(materia == '' || profesor == ''|| status == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/cursos/ajax-cursos.php';
        request.open('POST',ajaxUrl,true);
        var strData = new FormData(formCurso);
        request.send(strData);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormCurso').modal('hide');
                    formCurso.reset();
                    swal('Crear Curso',objData.msg,'success');
                    tableCursos.ajax.reload(function(){
                       delCurso();
                       editCurso();
                    })
                } else {
                    swal('Atencion',objData.msg,'error');
                }
            }
        }
    }
});

window.addEventListener('load',function(){
    delCurso();
    editCurso();
    getOptionsMaterias();
    getOptionsProfesores()
},false);

function getOptionsMaterias() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = './models/options/options-materia.php';
    request.open('GET',ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var option = JSON.parse(request.responseText);
            option.forEach(function(valor){
               option += '<option value="'+valor.materia_id+'">'+valor.nombre_materia+'</option>';  
            });
            document.querySelector('#listMateria').innerHTML = option;
        }
    }
}
function getOptionsProfesores() {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = './models/options/options-profesor.php';
    request.open('GET',ajaxUrl,true);
    request.send();
    request.onreadystatechange = function() {
        if(request.readyState == 4 && request.status == 200) {
            var option = JSON.parse(request.responseText);
            option.forEach(function(valor){
               option += '<option value="'+valor.profesor_id+'">'+valor.nombre+' '+valor.apellido+'</option>';  
            });
            document.querySelector('#listProfesor').innerHTML = option;
        }
    }
}

function editCurso() {
    var btnEditCurso = document.querySelectorAll('.btnEditCurso');
    btnEditCurso.forEach(function(btnEditCurso){
        btnEditCurso.addEventListener('click',function(){
            document.querySelector('#titleModal').innerHTML = 'Actualizar Curso';
            document.querySelector('.modal-header').classList.replace('headerRegister','updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary','btn-info');
            document.querySelector('#btnText').innerHTML = 'Actualizar';

            var idCurso = this.getAttribute('rl');

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/cursos/edit_cursos.php?id='+idCurso;
            request.open('GET',ajaxUrl,true);
            request.send();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        document.querySelector('#idCurso').value = objData.data.curso_id;
                        document.querySelector('#listMateria').value = objData.data.materia_id;
                        document.querySelector('#listProfesor').value = objData.data.profesor_id;
                        document.querySelector('#listStatus').value = objData.data.estatusC;

                        if(objData.data.estatusC == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                        }
                        var htmlOption = `${optionSelect}
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                        `;
                        document.querySelector('#listStatus').innerHTML = htmlOption;

                        $('#modalFormCurso').modal('show');
                    } else {
                        swal('Atencion',objData.msg,'error');
                    }
                }
            }
        })
    })
}

function delCurso() {
    var btnDelCurso = document.querySelectorAll('.btnDelCurso');
    btnDelCurso.forEach(function(btnDelCurso){
        btnDelCurso.addEventListener('click',function(){
            var idCurso = this.getAttribute('rl');

            swal({
                title: "Eliminar Curso",
                text: "Realmente desea eliminar el curso?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },function(Confirm){
                if(Confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxDelCurso = './models/cursos/delet_curso.php';
                    var strData = "idCurso="+idCurso;
                    request.open('POST',ajaxDelCurso,true);
                    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if(request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if(objData.status) {
                                swal("Eliminar!", objData.msg , "success");
                                tableCursos.ajax.reload(function(){
                                    delCurso();
                                    editCurso();
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

function openModalCurso() {
    document.querySelector('#idCurso').value = "";
    document.querySelector('#titleModal').innerHTML = 'Crear Curso';
    document.querySelector('.modal-header').classList.replace('updateRegister','headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info','btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    $('#modalFormCurso').modal('show');
}
