/**
 * GeekBucket 2015
 * Author: Alfredo chi
 * Define funcionalidad el dashboard de booking
 *
 */

///////////variables/////////////
var dialogResidencial, dialogUser;
var isButtonModal = true;
var idResidencial = 0;
var UserId = 0;

//////////////index//////////////
//$(document).on('click','.bodyMSGRectRounded',function(){ showModalMessage(this); });
$('#btnAddResidencial').click(function(){ showFormAddResidential(); });

//activa el formulario de autocompletar
$("#textCityResidential").keyup(function() { finderAutocomplete(); });

//activa el formulario de autocompletar
$(document).on('click','.editResidencial',function(){ showFormEditResidential(this); });

//muestra el formulario para eliminar una residencia
$(document).on('click','.btnDeleteResidencial',function(){ showFormDeleteResidential(this); });

//eliminar la residecial
$('#btnAcceptDeleteResidential').click(function(){ deleteResidential(); });

//oculta el formulario para eliminar residecial
$('#btnCancelDeleteResidential').click(function(){ hideFormDeleteResidential(); });

//muestra el formulario para agregar residentes
$(document).on('click','.btnAddUserResidencial',function(){ showFormUser(this); });

//muestra el formulario para agregar residentes
$(document).on('click','.editUser',function(){ showFormEditUser(this); });

//muestra el formulario para eliminar un usuario
$(document).on('click','.btnDeleteUser',function(){ showFormDeleteUser(this); });

//oculta el formulario para eliminar un empleado
$('#btnCancelDeleteUser').click(function(){ hideFormDeleteUser(); });

//elimina el usuario selecionado
$('#btnAcceptDeleteUser').click(function(){ deleteUser(); });

///////////funciones/////////////
 
$(function() {
   dialogResidencial = $( "#dialog-Residencial" ).dialog({
   		autoOpen: false,
      	height: "auto",
      	width: "60%",
		minHeight:'500',
      	modal: true,
		dialogClass: 'dialogModal',
		buttons: [
			{
				text: "Guardar",
				"class": 'dialogButtonAceptar formAdd',
				click: function() {
					if(isButtonModal){
						hideAlertResidential();
						addResidencial();
					}
				}
			},
			{
				text: "Guardar",
				"class": 'dialogButtonAceptar formEdit',
				click: function() {
					if(isButtonModal){
						hideAlertResidential();
						editResidencial();
					}
				}
			},
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel',
				click: function() {
					if(isButtonModal){
						dialogResidencial.dialog( "close" );
					}
				}
			},
		],
      	close: function() {
			$('.bodyLoanding').empty();
      	}
   	});
	
	
	//residentes
	
	dialogUser = $( "#dialog-formUser" ).dialog({
   		autoOpen: false,
		closeOnEscape: false,
		//open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog | ui).hide(); }
      	height: "auto",
		minHeight:'500',
      	width: "80%",
      	modal: true,
		dialogClass: 'dialogModal',
		buttons: [
			{
				text: "Guardar",
				"class": 'dialogButtonAceptar formAddUser',
				click: function() {
					if(isButtonModal){
						addUser();
					}
				}
			},
			{
				text: "Guardar",
				"class": 'dialogButtonAceptar formEditUser',
				click: function() {
					if(isButtonModal){
						EditUser();
					}
				}
			},
			{
				text: "Nuevo Usuario",
				"class": 'dialogButtonAceptar formTable',
				click: function() {
					if(isButtonModal){
						hideAlertUser();
						showFormAddUser();
					}
				}
			},
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel formCancel',
				click: function() {
					if(isButtonModal){
						backFormTableUser();
					}
				}
			},
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel formTable',
				click: function() {
					if(isButtonModal){
						//backFormTableResident();
						dialogUser.dialog( "close" );
					}
				}
			},
		],
      	close: function() {
			if(isButtonModal){
				dialogUser.dialog( "close" );
			}
      	}
   	});
	
	
});

//muestra el formulario para agregar residencial
function showFormAddResidential(){
	$('.formEdit').hide();
	$('.formAdd').show();
	$('.bodyLoandingSend').empty();
	$('.bodyLoandingSend').hide();
	cleanFieldResidencial();
	dialogResidencial.dialog( "open" );
	
}

//valida y llama a la funcion para guardar la residencial
function addResidencial(){
	var result = validateResidencial()
	if(result){
		isButtonModal = false;
		saveResidential(0);
	}
}

//valida y actualiza los datos de la residencial
function editResidencial(){
	var result = validateResidencial()
	if(result){
		isButtonModal = false;
		saveResidential(idResidencial);
	}
}

//guarda la info de la residencial
function saveResidential(id){
	
	$('.bodyLoandingSend').html('<img src="../assets/img/web/loading.GIF" />');
	$('.bodyLoandingSend').show();
	
	var valueCity = $('#textCityResidential').val().trim();
	var idCity = $('datalist option[value="' + valueCity + '"]').attr('id');
	
	var checked1 = 0;
	if( $('#checkbox1').prop('checked')) {
		checked1 = 1;
	}
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/saveResidential",
		dataType:'json',
		data: {
			id:id,
			nombre:$('#textNameResidential').val().trim(),
			ciudadesId:idCity,
			telAdministracion:$('#textTelAdminResident').val().trim(),
			telCaseta:$('#textTelCaseta').val().trim(),
			telLobby:$('#textTelLobby').val().trim(),
			nombreContacto:$('#textlNameContactResidential').val().trim(),
			telContacto:$('#textEmailContactResidential').val().trim(),
			emailContacto:$('#textTelContactResidential').val().trim(),
			requiereFoto:checked1
		},
		success: function(data){
			dialogResidencial.dialog( "close" );
			isButtonModal = true;
			$('.bodyLoandingSend').empty();
			$('.bodyLoandingSend').hide();
			$("#divAlertWarningResidential").hide();
			$('#alertResidential').html(data);
			$('#divAlertResidential').show(1000).delay(1500);
			$('#divAlertResidential').hide(1000);
			getResidencial();
        },
		error: function(data){
			alert('error al registrar una residencial. Intentelo mas tarde');
			dialogResidencial.dialog( "close" );
			isButtonModal = true;
			$('.bodyLoandingSend').empty('<img src="../assets/img/web/loading.GIF" />');
			$('.bodyLoandingSend').hide();
        }
	});
	
}


//muesrtra el formulario con los datos de la residencial
function showFormEditResidential( selector ){
	
	cleanFieldResidencial();
	$('.formAdd').hide();
	$('.formEdit').show();
	
	$('.bodyLoandingSend').html('<img src="../assets/img/web/loading.GIF" />');
	$('.bodyLoandingSend').show();
	
	dialogResidencial.dialog( "open" );
	
	idResidencial = $(selector).attr('value');
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/getResidentialById",
		dataType:'json',
		data: {
			id:$(selector).attr('value')
		},
		success: function(data){
			var item = data[0];
			$('#textNameResidential').val(item.nombre);
			$('#textTelAdminResident').val(item.telAdministracion);
			$('#textTelCaseta').val(item.telCaseta);
			$('#textTelLobby').val(item.telLobby);
			$('#textlNameContactResidential').val(item.nombreContacto);
			$('#textEmailContactResidential').val(item.telContacto);
			$('#textTelContactResidential').val(item.emailContacto);
			$('#textCityResidential').val(item.nombreCiudad);
			$('#cityList').append("<option id='" + item.ciudadesId + "' value='" +  item.nombreCiudad + "' />" );
			if(item.requiereFoto == 1){
				$('#checkbox1').attr('checked', true);
			}else{
				$('#checkbox1').attr('checked', false);
			}
			
			$('.bodyLoandingSend').empty();
			$('.bodyLoandingSend').hide();
        },
		error: function(data){
			alert('Error en mostrar los datos. Intentelo mas tarde');
			$('.bodyLoandingSend').empty();
			$('.bodyLoandingSend').hide();
			dialogResidencial.dialog( "close" );
        }
	});
	
}

//elimina el residencial selecionado
function showFormDeleteResidential(selector){
	idResidencial = $(selector).attr('value');
	$('#divAlertWarningResidential').hide();
	$('#divAlertWarningResidential').toggle(800);
}

//elimina el residencial selecionado
function hideFormDeleteResidential(){
	$('#divAlertWarningResidential').toggle(800);
	idResidencial = 0;
}

//elimina la residencial selecionada
function deleteResidential(){
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/deleteResidencial",
		dataType:'json',
		data: {
			id:idResidencial
		},
		success: function(data){
			$("#divAlertWarningResidential").hide();
			$('#alertResidential').html(data);
			$('#divAlertResidential').show(1000).delay(1500);
			$('#divAlertResidential').hide(1000);
			getResidencial();
        },
		error: function(){
			$("#divAlertWarningResidential").hide();
			alert('Error al eliminar la residencia. Intentelo mas tarde');
        }
	});
	
}

//obtiene la info de la residencial
function getResidencial(){
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/getResidencial",
		dataType:'json',
		data: {
		},
		success: function(data){
			var items = data.items;
			$('#tableResidencial tbody').empty();
			for(var i = 0;i<items.length; i++ ){
				$('#tableResidencial tbody').append(
					'<tr>' +
						'<td>' + (i + 1) +'</td>' +
						'<td><a  class="editResidencial" value="' + items[i].id + '">' + items[i].nombre + '</a></td>' +
						'<td>' + items[i].nombreContacto + '</td>' +
						'<td>' +  items[i].totalUsuarios + '</td>' +
						'<td ><a class="btnAddUserResidencial" value="' + items[i].id + '"><img id="imgAddUser" class="imgAddUser" src="../assets/img/web/user-add.png"/></a></td>'+
						'<td ><a class="btnDeleteResidencial" value="' + items[i].id + '"><img id="imgDelete" class="imgDeleteItem" src="../assets/img/web/delete.png"/></a></td>'+
					'</tr>'
				);
			}
			
			totalPaginadorR = parseInt(data.totalR/10);
			if(data.totalR%10 == 0){
				totalPaginadorR = totalPaginadorR - 1;		
			}
			totalPaginadorR = totalPaginadorR + 1
					
			$('#demo5').empty();
			paginadorActive();
        },
		error: function(data){
        }
	});
	
}

//valida los campos de la residencial
function validateResidencial(){
	
	var result = true;
	
	hideAlertResidential();
	
	//valida que el campo tel contacto no este vacio
	if($('#textTelContactResidential').val().trim().length == 0){
		$('#alertTelContactResidential').show();
		$('#labelTelContactResidential').addClass('error');
		$('#textTelContactResidential').focus();
		result = false;
	}
	
	//valida que el campo email contacto no este vacio
	if($('#textEmailContactResidential').val().trim().length == 0){
		$('#alertEmailContactResidential').show();
		$('#labelEmailContactResidential').addClass('error');
		$('#textEmailContactResidential').focus();
		result = false;
	}
	
	//valida que el campo nombre contacto no este vacio
	if($('#textlNameContactResidential').val().trim().length == 0){
		$('#alertlNameContactResidential').show();
		$('#labelNameContactResidential').addClass('error');
		$('#textlNameContactResidential').focus();
		result = false;
	}
	
	//valida que se haya selecionado una ciudad
	valueCity = $('#textCityResidential').val().trim();
	idCity = $('datalist option[value="' + valueCity + '"]').attr('id');
	//valida que el partner selecionado no este vacio y que exista
	if(idCity == undefined){
		$('#alertCityResidential').show();
		$('#labelCityResidential').addClass('error');
		$('#textCityResidential').focus();
		result = false;
	}
	
	//valida que el campo tel caseta no este vacio
	if($('#textTelLobby').val().trim().length == 0){
		$('#alertTelLobby').show();
		$('#labelTelLobby').addClass('error');
		$('#textTelLobby').focus();
		result = false;
	}
	
	//valida que el campo tel caseta no este vacio
	if($('#textTelCaseta').val().trim().length == 0){
		$('#alertTelCaseta').show();
		$('#labelTelCaseta').addClass('error');
		$('#textTelCaseta').focus();
		result = false;
	}
	
	//valida que el campo tel admin no este vacio
	if($('#textTelAdminResident').val().trim().length == 0){
		$('#alertTelAdminResident').show();
		$('#labelTelAdminResident').addClass('error');
		$('#textTelAdminResident').focus();
		result = false;
	}
	
	//valida que el campo nombre no este vacio
	if($('#textNameResidential').val().trim().length == 0){
		$('#alertNameResidential').show();
		$('#labelNameResidential').addClass('error');
		$('#textNameResidential').focus();
		result = false;
	}
	
	return result;
}

function hideAlertResidential(){
	
	$('#alertNameResidential').hide()
	$('#alertTelAdminResident').hide()
	$('#alertTelCaseta').hide();
	$('#alertTelLobby').hide();
	$('#alertCityResidential').hide();
	$('#alertlNameContactResidential').hide();
	$('#alertEmailContactResidential').hide();
	$('#alertTelContactResidential').hide();
		
	$('#labelNameResidential').removeClass('error');
	$('#labelTelAdminResident').removeClass('error');
	$('#labelTelCaseta').removeClass('error');
	$('#labelTelLobby').removeClass('error');
	$('#labelCityResidential').removeClass('error');
	$('#labelNameContactResidential').removeClass('error');
	$('#labelEmailContactResidential').removeClass('error');
	$('#labelTelContactResidential').removeClass('error');
	
}

function cleanFieldResidencial(){
	$('#textNameResidential').val("");
	$('#textTelAdminResident').val("");
	$('#textTelCaseta').val("");
	$('#textTelLobby').val("");
	$('#textlNameContactResidential').val("");
	$('#textEmailContactResidential').val("");
	$('#textTelContactResidential').val("");
	$('#textCityResidential').val("");
	$('#cityList').empty();
	$('#checkbox1').attr('checked', false);
	idResidencial = 0;
}

//despliega el formulario de autocompletar
function finderAutocomplete(){
	
	$.ajax({
		type: "POST",
		url: "dashboard/getCities",
		dataType:'json',
		data: {
			dato:$("#textCityResidential").val()
		},
		success: function(data){
			$('#cityList').empty();
			for(var i = 0;i<data.length;i++){
				$('#cityList').append(
					"<option id='" + data[i].id + "' value='" +  data[i].nombre + "' />"
				);
			}
        }
	});
	
}

//muestra el formulario para agregar usuarios
function showFormUser(selector){
	cleanFieldUser();
	//alert($(selector).attr('value'))
	idResidencial = $(selector).attr('value');
	dialogUser.dialog( 'open' );
	$('#divTableUser').show();
	$('#divFormUser').hide();
	$('.formTable').show();
	$('.formCancel').hide();
	$('.formAddUser').hide();
	$('.formEditUser').hide();
	$('.bodyLoandingSend').html('<img src="../assets/img/web/loading.GIF" />');
	$('.bodyLoandingSend').show();
	
	
	getUserByResidencial();
	
}

function getUserByResidencial(){
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/getUserByResidencial",
		dataType:'json',
		data: {
			residencialId:idResidencial
		},
		success: function(data){
			$('#tableUser tbody').empty();
			for(i = 0;i<data.length;i++){
				var item = data[i];
				console.log(item)
				$('#tableUser tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td><a  class="editUser" value="' + item.id + '">' + item.nombre + " " + item.apellidos + '</a></td>' +
						'<td>' + item.email + '</td>' +
						'<td ><a class="btnDeleteUser" value="' + item.id + '"><img id="imgDelete" class="imgDeleteItem" src="../assets/img/web/delete.png"/></a></td>'+
					'</tr>'
				);
			}
			$('.bodyLoandingSend').empty();
			$('.bodyLoandingSend').hide();
        },
		error: function(){
			alert('Error al mostrar los usuarios. Intentelo mas tarde')
			dialogUser.dialog( 'close' );
        }
	});
	
}

//muestra el formulario de agregar usuarios
function showFormAddUser(){
	$('#divTableUser').hide();
	$('#divFormUser').show();
	$('.formTable').hide();
	$('.formCancel').show();
	$('.formAddUser').show();
	$('.formEditUser').hide();
}

//muestra el formulario de agregar usuarios
function addUser(){
	UserId = 0;
	var result = validateUser();
	if(result){
		saveUser(0);
	}
}

//edita los datos del empleado
function EditUser(){
	var result = validateUser();
	if(result){
		saveUser(UserId);
	}
}

function backFormTableUser(){
	$('#divTableUser').show();
	$('#divFormUser').hide();
	$('.formTable').show();
	$('.formCancel').hide();
	$('.formAddUser').hide();
	$('.formEditUser').hide();
}

function saveUser(id){
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/saveUser",
		dataType:'json',
		data: {
			id:id,
			nombre:$('#textNameUser').val().trim(),
			apellidos:$('#textLastNameUser').val().trim(),
			contrasena:$('#textPassUser').val().trim(),
			telefono:$('#textPhoneUser').val().trim(),
			direccion:$('#textAddressUser').val().trim(),
			ciudad:$('#textCityUser').val().trim(),
			estado:$('#textStateUser').val().trim(),
			email:$('#textEmailUser').val().trim(),
			residencialId:idResidencial,
		},
		success: function(data){
			backFormTableUser();
			$('#alertUser').html(data);
			$('#divAlertUser').show(1000).delay(1500);
			$('#divAlertUser').hide(1000);
			getUserByResidencial();
			cleanFieldUser();
			
        },
		error: function(){
			alert('Error al guardar los datos. Intentelo mas tarde')
        }
	});
}

//muestra la info del empleado selecionado
function showFormEditUser(selector){
	cleanFieldUser();
	UserId = $(selector).attr('value');
	
	$('#divTableUser').hide();
	$('#divFormUser').show();
	$('.formTable').hide();
	$('.formCancel').show();
	$('.formAddUser').hide();
	$('.formEditUser').show();
	$('.bodyLoandingSend').html('<img src="../assets/img/web/loading.GIF" />');
	$('.bodyLoandingSend').show();
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/getUserById",
		dataType:'json',
		data: {
			id:$(selector).attr('value')
		},
		success: function(data){
			var item = data[0];
			$('#textNameUser').val(item.nombre);
			$('#textLastNameUser').val(item.apellidos);
			$('#textPhoneUser').val(item.telefono);
			$('#textAddressUser').val(item.direccion);
			$('#textStateUser').val(item.estado);
			$('#textCityUser').val(item.ciudad);
			$('#textEmailUser').val(item.email);
			$('#textPassUser').val("");
			$('.bodyLoandingSend').empty();
			$('.bodyLoandingSend').hide();
        },
		error: function(data){
			alert('Error en mostrar los datos. Intentelo mas tarde');
			$('.bodyLoandingSend').empty();
			$('.bodyLoandingSend').hide();
			backFormTableUser();
        }
	});
}

//muestra ek formulario para eliinar usuarios
function showFormDeleteUser(selector){
	UserId = $(selector).attr('value');
	$('#divAlertWarningUser').hide();
	$('#divAlertWarningUser').toggle(800);
}

//elimina el residencial selecionado
function hideFormDeleteUser(){
	$('#divAlertWarningUser').toggle(800);
	UserId = 0;
}

//elimina la residencial selecionada
function deleteUser(){
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/deleteUser",
		dataType:'json',
		data: {
			id:UserId
		},
		success: function(data){
			$("#divAlertWarningUser").hide();
			$('#alertUser').html(data);
			$('#divAlertUser').show(1000).delay(1500);
			$('#divAlertUser').hide(1000);
			getUserByResidencial();
        },
		error: function(){
			$("#divAlertWarningResidential").hide();
			alert('Error al eliminar la residencia. Intentelo mas tarde');
        }
	});
	
}


//valida los campos de usuarios
function validateUser(){
	
	hideAlertUser();
	
	var result = true;
	
	//valida que el campo email no este vacio
	if($('#textPassUser').val().trim().length == 0 && UserId == 0){
		$('#alertPassUser').show();
		$('#labelPassUser').addClass('error');
		$('#textPassUser').focus();
		result = false;
	}
	
	//valida que el campo email no este vacio
	if($('#textEmailUser').val().trim().length == 0){
		$('#alertEmailUser').show();
		$('#labelEmailUser').addClass('error');
		$('#textEmailUser').focus();
		result = false;
	}
	
	//valida que el campo ciudad no este vacio
	if($('#textCityUser').val().trim().length == 0){
		$('#alertCityUser').show();
		$('#labelCityUser').addClass('error');
		$('#textCityUser').focus();
		result = false;
	}
	
	//valida que el campo estado no este vacio
	if($('#textStateUser').val().trim().length == 0){
		$('#alertStateUser').show();
		$('#labelStateUser').addClass('error');
		$('#textStateUser').focus();
		result = false;
	}
	
	//valida que el campo direccion no este vacio
	if($('#textAddressUser').val().trim().length == 0){
		$('#alertAddressUser').show();
		$('#labelAddressUser').addClass('error');
		$('#textAddressUser').focus();
		result = false;
	}
	
	//valida que el campo telefono no este vacio
	if($('#textPhoneUser').val().trim().length == 0){
		$('#alertPhoneUser').show();
		$('#labelPhoneUser').addClass('error');
		$('#textPhoneUser').focus();
		result = false;
	}
	
	//valida que el campo apellido no este vacio
	if($('#textLastNameUser').val().trim().length == 0){
		$('#alertLastNameUser').show();
		$('#labelLastNameUser').addClass('error');
		$('#textLastNameUser').focus();
		result = false;
	}
	
	//valida que el campo nombre no este vacio
	if($('#textNameUser').val().trim().length == 0){
		$('#alertNameUser').show();
		$('#labelNameUser').addClass('error');
		$('#textNameUser').focus();
		result = false;
	}
	
	return result;
}

function hideAlertUser(){
	
	$('#alertNameUser').hide()
	$('#alertLastNameUser').hide()
	$('#alertPhoneUser').hide();
	$('#alertAddressUser').hide();
	$('#alertStateUser').hide();
	$('#alertCityUser').hide();
	$('#alertEmailUser').hide();
	$('#alertPassUser').hide();
		
	$('#labelNameUser').removeClass('error');
	$('#labelLastNameUser').removeClass('error');
	$('#labelPhoneUser').removeClass('error');
	$('#labelAddressUser').removeClass('error');
	$('#labelStateUser').removeClass('error');
	$('#labelCityUser').removeClass('error');
	$('#labelEmailUser').removeClass('error');
	$('#labelPassUser').removeClass('error');
	
}

function cleanFieldUser(){
	$('#textNameUser').val("");
	$('#textLastNameUser').val("");
	$('#textPhoneUser').val("");
	$('#textAddressUser').val("");
	$('#textStateUser').val("");
	$('#textCityUser').val("");
	$('#textEmailUser').val("");
	$('#textPassUser').val("");
}


/*********************************/
/************Paginador************/
/*********************************/

$(document).ready(function() { paginadorActive(); });

function paginadorActive(){    
	$("#demo5").paginate({
		count: totalPaginadorR,
		start: 1,
		display: 4,
		border: true,
		border_color: '#90b16c',
		text_color: '#0000',
		background_color: '#FFFFFF',
		border_hover_color: '#90b16c',
		text_hover_color: '#90b16c',
		background_hover_color: '#FFFFFF',
		images: false,
		mouse: 'press',
		onChange: function (page) {
			$('._current', '#paginationdemoA').removeClass('_current').hide();
			$('#p' + page).addClass('_current').show();
			getInfoPaginador(page);
		}
	});
	$('.jPag-first').html('Primero');
	$('.jPag-last').html('Ultimo');
}

function paginador(num){
	
	var url = "";
	switch(type){
		case "dashboardMessage":
			url = "dashboard/getMessagePaginador";
		break;
		case "dashboardVisit":
			url = "dashboard/getVisitPaginador";
		break;
	}
	
	getInfoPaginador(num);	
}

function getInfoPaginador(num, type, url, dato){
	
	var cantidad = (num-1) *10;
	
	$.ajax({
		type: "POST",
		url: "../admin/dashboard/getResidencialPaginador",
		dataType:'json',
		data: {
			num:cantidad,
			dato:dato
		},
		success: function(data){
			total = data.length;
			$('#tableResidencial tbody').empty();
			for(var i = 0;i<total;i++){
				var item = data[i];
				$('#tableResidencial tbody').append(
					'<tr>' +
						'<td>' + (i + 1) +'</td>' +
						'<td><a  class="editResidencial" value="' + item.id + '">' + item.nombre + '</a></td>' +
						'<td>' + item.nombreContacto + '</td>' +
						'<td>' +  item.totalUsuarios + '</td>' +
						'<td ><a class="btnAddUserResidencial" value="' + item.id + '"><img id="imgAddUser" class="imgAddUser" src="../assets/img/web/user-add.png"/></a></td>'+
						'<td ><a class="btnDeleteResidencial" value="' + item.id + '"><img id="imgDelete" class="imgDeleteItem" src="../assets/img/web/delete.png"/></a></td>'+
					'</tr>'
				);
			}
		},
		error: function(data){
			alert('Error, intentelo mas tarde');
		}
	});
	
}
