$(document).ready(function(){
    $('#loginusuario').on('click',function(){
        loginusuario();
    });
    $('#loginadmin').on('click',function(){
        loginadmin();
    });
})

function loginusuario(){
    var login = $('#usuario').val();
    var pass = $('#pass').val();

    $.ajax({
        url: './includes/loginusuario.php',
        method:'POST',
        data:{
            login:login,
            pass:pass
        },
        success: function(data){
            $('#messageUsuario').html(data);
            if(data.indexOf('Redireccionando') >= 0){
                window.location = 'usuario/';
            }
        }
    
    })
}

function loginadmin(){
    var admin = $('#admin').val();
    var passadmin = $('#passadmin').val();

    $.ajax({
        url: './includes/loginadmin.php',
        method:'POST',
        data:{
            admin:admin,
            passadmin:passadmin
        },
        success: function(data){
            $('#messageAdministrador').html(data);
            if(data.indexOf('Redireccionando') >= 0){
                window.location = 'administrador/';
            }
        }
    
    })
}