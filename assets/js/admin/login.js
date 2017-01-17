/**
 * GeekBucket 2014
 * Author: Alfredo Chi Zum
 * Define funcionalidad del login
 *
 */
 
$('#alertLogin').hide();

$(function() {

    $("#btnlogin").click(function() {
		verifyUser();
	});
    
    $("#txtUser,#txtPassword").keypress(function(e) {
	    if(e.which == 13) { verifyUser(); }
	});
});

/**
 * Actualizamos el mensaje de alerta
 */
function showMsg(mensaje){
    $('#alertLogin').hide();
    $('#alertLogin').html(mensaje);
    $('#alertLogin').show('slow');
}


/**
 * Ejemplo de una consulta al backend
 */
function verifyUser(){
	
    if ($('#txtEmail').val().trim().length == 0
       || $('#txtPassword').val().trim().length == 0){
        showMsg('El usuario y password son requeridos.');
    }else{
        $.ajax({
            type: "POST",
            url: "../login/checkLogin2",
            dataType:'json',
            data: { 
                email: $('#txtEmail').val(),
                password: $('#txtPassword').val()
            },
            success: function(data){
				console.log(data)
                if (data.success){
                    window.location.href = URL_BASE + "admin/home";
                }else{
                    showMsg(data.message);
                }
            },
			error: function(data){
				showMsg('Error al iniciar sesión intentelo mas tarde');
            },
        });
    }
}