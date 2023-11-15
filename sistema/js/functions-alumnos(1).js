$('#tableAlumnos').DataTable();
var tableAlumnos;

document.addEventListener('DOMContentLoaded',function(){
    tableAlumnos = $('#tableAlumnos').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "./models/alumnos/table_alumnos.php",
            "dataSrc":""
        },
        "columns": [
            {"data":"alumno_id"},
            {"data":"nombre"},
            {"data":"apellido"},
            {"data":"edad"},
            {"data":"direccion"},
            {"data":"cedula"},
            {"data":"telefono"},
            {"data":"correo"},
            {"data":"fecha_nac"},
            {"data":"estatus"},
            {"data":"options"}
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
    });

    // CREAR ALUMNOS
    var formALumnos = document.querySelector('#formAlumno');
    formALumnos.onsubmit = function(e) {
        e.preventDefault();
        var idAlumno = document.querySelector('#idAlumno').value;
        var nombre = document.querySelector('#txtNombre').value;
        var apellido = document.querySelector('#txtApellido').value;
        var edad = document.querySelector('#edad').value;
        var direccion = document.querySelector('#txtDireccion').value;
        var cedula = document.querySelector('#cedula').value;
        var telefono = document.querySelector('#telefono').value;
        var email = document.querySelector('#email').value;
        var fechaNac = document.querySelector('#fechaNac').value;
        var status = document.querySelector('#listStatus').value;

        if(nombre == '' || apellido == '' || edad == '' || direccion == '' || cedula == '' || telefono == '' || email == '' || fechaNac == '' || status == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/alumnos/ajax-alumnos.php';
        var formAlumno = new FormData(formALumnos);
        request.open('POST',ajaxUrl,true);
        request.send(formAlumno);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormAlumno').modal('hide');
                    formALumnos.reset();
                    swal('Crear ALumno',objData.msg,'success');
                    tableAlumnos.ajax.reload(function(){
                        editAlumno();
                        delAlumno();
                    })
                } else {
                    swal('Atencion',objData.msg,'error');
                }
            }
        }
    }
});

window.addEventListener('load',function(){
    editAlumno();
    delAlumno();
},false);

function editAlumno() {
    var btnEditAlumno = document.querySelectorAll('.btnEditAlumno');
    btnEditAlumno.forEach(function(btnEditAlumno){
        btnEditAlumno.addEventListener('click',function(){
            document.querySelector('#titleModal').innerHTML = 'Actualizar Alumno';
            document.querySelector('.modal-header').classList.replace('headerRegister','updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary','btn-info');
            document.querySelector('#btnText').innerHTML = 'Actualizar';

            var idAlumno = this.getAttribute('rl');

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/alumnos/edit_alumnos.php?id='+idAlumno;
            //var strData = 'idAlumno='+idAlumno;
            request.open('GET',ajaxUrl,true);
            request.send();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    if(request.status) {
                        var objData = JSON.parse(request.responseText);
                        document.querySelector('#idAlumno').value = objData.data.alumno_id;
                        document.querySelector('#txtNombre').value = objData.data.nombre;
                        document.querySelector('#txtApellido').value = objData.data.apellido;
                        document.querySelector('#edad').value = objData.data.edad;
                        document.querySelector('#txtDireccion').value = objData.data.direccion;
                        document.querySelector('#cedula').value = objData.data.cedula;
                        document.querySelector('#telefono').value = objData.data.telefono;
                        document.querySelector('#email').value = objData.data.correo;
                        document.querySelector('#fechaNac').value = objData.data.fecha_nac;
                        document.querySelector('#listStatus').value = objData.data.estatus;

                        $('#modalFormAlumno').modal('show');
                    } else {
                        swal('Atencion',objData.msg,'error');
                    }
                }
            }
        });
    });
};

function delAlumno() {
    var btnDelAlumno = document.querySelectorAll('.btnDelAlumno');
    btnDelAlumno.forEach(function(btnDelAlumno){
        btnDelAlumno.addEventListener('click',function(){
            var idAlumno = this.getAttribute('rl');
            swal({
                title: "Eliminar Alumno",
                text: "Realmente desea eliminar el alumno?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },function(confirm){
                if(confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = './models/alumnos/del_alumnos.php';
                    var strData = 'idAlumno='+idAlumno;
                    request.open('POST',ajaxUrl,true);
                    request.setRequestHeader('Content-type','Application/x-www-form-urlencoded');
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if(request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if(objData.status) {
                                swal("Eliminar!", objData.msg , "success");
                                tableAlumnos.ajax.reload(function(){
                                    editAlumno();
                                    delAlumno();
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

function openModalAlumno() {
    document.querySelector('#idAlumno').value = "";
    document.querySelector('#titleModal').innerHTML = 'Nuevo ALumno';
    document.querySelector('.modal-header').classList.replace('updateUpdate','headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info','btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#formAlumno').reset();
    $('#modalFormAlumno').modal('show');
}

