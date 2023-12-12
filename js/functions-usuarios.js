
/***********************USUARIOS *******************************/

$('#tableUsuarios').DataTable();
var tableUsuarios;

document.addEventListener('DOMContentLoaded', function(){
    tableUsuarios = $('#tableUsuarios').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": "./models/usuarios/table_usuarios.php",
            "dataSrc":""
        },
        "columns": [
            {"data":"user_id"},
            {"data":"nombre"},
            {"data":"usuario"},
            {"data":"nombre_rol"},
            {"data":"estatus"},
            {"data":"options"}
        ],
        "resonsieve": true,
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0,"asc"]]
    });

    // CREAR USUARIO
    var formUser = document.querySelector('#formUser');
    formUser.onsubmit = function(e) {
        e.preventDefault();
        // se extraen los datos a enviar
        var idUser = document.querySelector('#idUser').value;
        var strNombre = document.querySelector('#txtNombre').value;
        var strUsuario = document.querySelector('#txtUsuario').value;
        var password = document.querySelector('#clave').value;
        var strRol = document.querySelector('#listRol').value;
        var intStatus = document.querySelector('#listStatus').value;

        // se valida que no se envien campos vacios
        if(strNombre == '' || strUsuario == '' || strRol == '' || intStatus == '') {
            swal("Atencion","Todos los campos son necesarios","error");
            return false;
        }

        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = './models/usuarios/ajax-usuarios.php';
        var formData = new FormData(formUser);
        request.open('POST',ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if(objData.status) {
                    $('#modalFormUser').modal('hide');
                    formUser.reset();
                    swal('Crear Usuario',objData.msg,'success');
                    tableUsuarios.ajax.reload(function(){
                        editUser();
                        delUser();
                    })
                } else {
                    swal('Atencion',objData.msg,'error');
                }
            }
        }
    }
});

function openModal() {
    document.querySelector('#idUser').value = "";
    document.querySelector('#titleModal').innerHTML = 'Nuevo Usuario';
    document.querySelector('.modal-header').classList.replace('updateRegister','headerRegister');
    document.querySelector('#btnActionForm').classList.replace('btn-info','btn-primary');
    document.querySelector('#btnText').innerHTML = 'Guardar';
    document.querySelector('#formUser').reset();
    $('#modalFormUser').modal('show');
}

window.addEventListener('load',function(){
    editUser();
    delUser();
},false);

function editUser() {
    var btnEditUser = document.querySelectorAll('.btnEditUser');
    btnEditUser.forEach(function(btnEditUser){
        btnEditUser.addEventListener('click',function(){
            document.querySelector('#titleModal').innerHTML = 'Actualizar Usuario';
            document.querySelector('.modal-header').classList.replace('headerRegister','updateRegister');
            document.querySelector('#btnActionForm').classList.replace('btn-primary','btn-info');
            document.querySelector('#btnText').innerHTML = 'Actualizar';

            var idUser = this.getAttribute('rl');
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = './models/usuarios/edit_usuarios.php?id='+idUser;
            request.open('GET',ajaxUrl,true);
            request.send();
            request.onreadystatechange = function() {
                if(request.readyState == 4 && request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if(objData.status) {
                        document.querySelector('#idUser').value = objData.data.user_id;
                        document.querySelector('#txtNombre').value = objData.data.nombre;
                        document.querySelector('#txtUsuario').value = objData.data.usuario;
                        document.querySelector('#listRol').value = objData.data.rol;
                        document.querySelector('#listStatus').value = objData.data.estatus;

                        if(objData.data.estatus == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                        }

                        if(objData.data.rol == 1) {
                            var optionRol = '<option value="1" selected class="notBlock">Administrador</option>';
                        } else {
                            var optionRol = '<option value="2" selected class="notBlock">Asistente</option>';
                        }

                        var htmlSelect = `${optionSelect}
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option> 
                                        `;
                        var htmlRol = `${optionRol}
                                        <option value="1">Administrador</option>
                                        <option value="2">Asistente</option> 
                                        `;
                        document.querySelector("#listStatus").innerHTML = htmlSelect;
                        document.querySelector("#listRol").innerHTML = htmlRol;
                        $("#modalFormUser").modal("show");
                    } else {
                        swal('Atencion',objData.msg,'error');
                    }
                }
            }
        })
    })
}

function delUser() {
    var btnDelUser = document.querySelectorAll('.btnDelUser');
    btnDelUser.forEach(function(btnDelUser){
        btnDelUser.addEventListener('click',function(){
            var idUser = this.getAttribute('rl');

            swal({
                title: "Eliminar Usuario",
                text: "Realmente desea eliminar el usuario?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, eliminar",
                cancelButtonText: "No, cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            },function(Confirm){
                if(Confirm) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxDelUser = './models/usuarios/delet_usuarios.php';
                    var strData = "idUser="+idUser;
                    request.open('POST',ajaxDelUser,true);
                    request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
                    request.send(strData);
                    request.onreadystatechange = function() {
                        if(request.readyState == 4 && request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if(objData.status) {
                                swal("Eliminar!", objData.msg , "success");
                                tableUsuarios.ajax.reload(function(){
                                    editUser();
                                    delUser();
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

/*********************** FIN USUARIOS *******************************/



