$('#tableMaterias').DataTable();
var tableMaterias;

document.addEventListener('DOMContentLoaded',function(){
    tableMaterias = $('#tableMaterias').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "./models/materias/table_materias.php",
            "dataSrc": ""
        },
        "columns": [
            {"data":"materia_id"},
            {"data":"nombre_materia"},
            {"data":"estatus"},
            {"data":"options"},
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
    });

    // CREAR MATERIA
    var formMateria = document.querySelector('#formMateria');
    formMateria.onsubmit = function(e) {
        e.preventDefault();
        var idMateria = document.querySelector('#idMateria').value;
        var nombre = document.querySelector('#txtNombre').value;
        var status = document.querySelector('#listStatus').value;

        if(nombre == '' || status == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/materias/ajax-materias.php';
        request.open('POST',ajaxUrl,true);
        var strData = new FormData(formMateria);
        request.send(strData);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormMateria').modal('hide');
                    formMateria.reset();
                    swal('Crear Materia',objData.msg,'success');
                    tableMaterias.ajax.reload(function(){
                        editMateria();
                        delMateria();
                    })
                } else {
                    swal('Atencion',objData.msg,'error');
                }
            }
        }
    }
});

window.addEventListener('load',function(){
    editMateria();
    delMateria();
},false);

function editMateria() {
    var btnEditMateria = document.querySelectorAll('.btnEditMateria');
    btnEditMateria.forEach(function(btnEditMateria){
        btnEditMateria.addEventListener('click',function(){
            document.querySelector('#titleModal').innerHTML = 'Actualizar Materia';
            document.querySelector('.modal-header').classList.replace('headerRegister','updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary','btn-info');
            document.querySelector('#btnText').innerHTML = 'Actualizar';

            var idMateria = this.getAttribute('rl');

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/materias/edit_materias.php?id='+idMateria;
            request.open('GET',ajaxUrl,true);
            request.send();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        document.querySelector('#idMateria').value = objData.data.materia_id;
                        document.querySelector('#txtNombre').value = objData.data.nombre_materia;
                        document.querySelector('#listStatus').value = objData.data.estatus;

                        if(objData.data.estatus == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                        }
                        var htmlOption = `${optionSelect}
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>
                                        `;
                        document.querySelector('#listStatus').innerHTML = htmlOption;

                        $('#modalFormMateria').modal('show');
                    } else {
                        swal('Atencion',objData.msg,'error');
                    }
                }
            }
        })
    })
}

function delMateria() {
    var btnDelMateria = document.querySelectorAll('.btnDelMateria');
    btnDelMateria.forEach(function(btnDelMateria){
        btnDelMateria.addEventListener('click',function(){
            var idMateria = this.getAttribute('rl');

            swal({
                title: "Eliminar Materia",
                text: "Realmente desea eliminar la materia?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },function(Confirm){
                if(Confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxDelMateria = './models/materias/delet_materia.php';
                    var strData = "idMateria="+idMateria;
                    request.open('POST',ajaxDelMateria,true);
                    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if(request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if(objData.status) {
                                swal("Eliminar!", objData.msg , "success");
                                tableMaterias.ajax.reload(function(){
                                    editMateria();
                                    delMateria();
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

function openModalMateria() {
    document.querySelector('#idMateria').value = "";
    document.querySelector('#titleModal').innerHTML = 'Nueva Materia';
    document.querySelector('.modal-header').classList.replace('updateRegister','headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info','btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#formMateria').reset();
    $('#modalFormMateria').modal('show');
}