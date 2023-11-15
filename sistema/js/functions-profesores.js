$('#tableProfesores').DataTable();
var tableProfesores;

document.addEventListener('DOMContentLoaded',function(){
    tableProfesores = $('#tableProfesores').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "./models/profesores/table_profesores.php",
            "dataSrc":""
        },
        "columns": [
            {"data":"profesor_id"},
            {"data":"nombre"},
            {"data":"apellido"},
            {"data":"direccion"},
            {"data":"cedula"},
            {"data":"telefono"},
            {"data":"correo"},
            {"data":"nivel_est"},
            {"data":"estatus"},
            {"data":"options"}
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
    });

    // CREAR PROFESOR
    var formProfesor = document.querySelector('#formProfesor');
    formProfesor.onsubmit = function(e) {
        e.preventDefault();
        var idProfesor = document.querySelector('#idProfesor').value;
        var nombre = document.querySelector('#txtNombre').value;
        var apellido = document.querySelector('#txtApellido').value;
        var direccion = document.querySelector('#txtDireccion').value;
        var cedula = document.querySelector('#cedula').value;
        var telefono = document.querySelector('#telefono').value;
        var email = document.querySelector('#email').value;
        var nivelEst = document.querySelector('#nivelEst').value;
        var status = document.querySelector('#listStatus').value;

        if(nombre == '' || apellido == '' || direccion == '' || cedula == '' || telefono == '' || email == '' || nivelEst == '' || status == '') {
            swal('Atencion','Todos los campos son necesarios','error');
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/profesores/ajax-profesores.php';
        var formData = new FormData(formProfesor);
        request.open('POST',ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormProfesor').modal('hide');
                    formProfesor.reset();
                    swal('Crear Profesor',objData.msg,'success');
                    tableProfesores.ajax.reload(function(){
                        editProfesor();
                        delProfesor();
                    });
                } else {
                    swal('Atencion',objData.msg,'error');
                }
            }
        }
    }
});

function editProfesor() {
    var btnEditProfesor = document.querySelectorAll('.btnEditProfesor');
    btnEditProfesor.forEach(function(btnEditProfesor){
        btnEditProfesor.addEventListener('click',function(){
            document.querySelector('#titleModal').innerHTML = 'Actualizar Profesor';
            document.querySelector('.modal-header').classList.replace('headerRegister','updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary','btn-info');
            document.querySelector('#btnText').innerHTML = 'Actualizar';

            var idProfesor = this.getAttribute('rl');

            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/profesores/edit_profesores.php?id='+idProfesor;
            request.open('GET',ajaxUrl,true);
            request.send();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        document.querySelector('#idProfesor').value = objData.data.profesor_id;
                        document.querySelector('#txtNombre').value = objData.data.nombre;
                        document.querySelector('#txtApellido').value = objData.data.apellido;
                        document.querySelector('#txtDireccion').value = objData.data.direccion;
                        document.querySelector('#cedula').value = objData.data.cedula;
                        document.querySelector('#telefono').value = objData.data.telefono;
                        document.querySelector('#email').value = objData.data.correo;
                        document.querySelector('#nivelEst').value = objData.data.nivel_est;
                        document.querySelector('#listStatus').value = objData.data.estatus;

                        if(objData.data.estatus == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                        }

                        var htmlSelect = `${optionSelect}
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option> 
                                        `;
                        document.querySelector("#listStatus").innerHTML = htmlSelect;
                        
                        $("#modalFormProfesor").modal("show");
                    } else {
                        swal('Atencion',objData.msg,'error');
                    }
                }
            }
        })
    })
};

function delProfesor() {
    var btnDelProfesor = document.querySelectorAll('.btnDelProfesor');
    btnDelProfesor.forEach(function(btnDelProfesor){
        btnDelProfesor.addEventListener('click',function(){
            var idProfesor = this.getAttribute('rl');
            swal({
                title: "Eliminar Profesor",
                text: "Realmente desea eliminar el profesor?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },function(Confirm){
                if(Confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxDelProfesor = './models/profesores/delet_profesor.php';
                    var strData = "idProfesor="+idProfesor;
                    request.open('POST',ajaxDelProfesor,true);
                    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if(request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if(objData.status) {
                                swal("Eliminar!", objData.msg , "success");
                                tableProfesores.ajax.reload(function(){
                                    editProfesor();
                                    delProfesor();
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

window.addEventListener('load',function(){
    editProfesor();
    delProfesor();
},false);

function openModalProfesor() {
    document.querySelector('#idProfesor').value = "";
    document.querySelector('#titleModal').innerHTML = 'Nuevo Profesor';
    document.querySelector('.modal-header').classList.replace('updateRegister','headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info','btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#formProfesor').reset();
    $('#modalFormProfesor').modal('show');
}