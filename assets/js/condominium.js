/**
 * GeekBucket 2015
 * Author: Alfredo chi
 * Define funcionalidad el condominios de booking
 *
 */

///////////variables/////////////
var dialogCondo;
var isButtonModal = true;
var idCondominio = 0;

//////////////index//////////////

//muestra el formulario para agregar condominios
$('#btnAddCondo').click(function(){ showFormAddCondo(); });

$(document).on('click', '.editCondominium', function(){ showFormEditCondo(this); });

$(document).on('click', '.btnDeleteCondo', function(){ showDeleteCondo($(this).attr('value')); });

$(document).on('click', '#btnCancelDeleteCondominium', function(){ hideDeleteCondominium(); });

$(document).on('click', '#btnAcceptDeleteCondominium', function(){ DeleteCondominium(); });

$('#btnSeachCondo').click(function() { getCondominiumsSearch(); });

$('#textSeachCondo').keyup(function(e){
    if(e.keyCode ==13){
	getCondominiumsSearch();	
    }
});

///////////funciones/////////////

$(function() {
   dialogCondo = $( "#dialog-formCondominium" ).dialog({
   		autoOpen: false,
		closeOnEscape: false,
		//open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog | ui).hide(); }
      	height: "auto",
      	width: "60%",
      	modal: true,
		dialogClass: 'dialogModal',
		buttons: [
			{
				text: "Aceptar",
				"class": 'dialogButtonAceptar',
				click: function() {
					if(isButtonModal){
						addCondominium();
					}
				}
			},
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel',
				click: function() {
					if(isButtonModal){
						dialogCondo.dialog( "close" );
					}
				}
			},
		],
      	close: function() {
			if(isButtonModal){
				dialogCondo.dialog( "close" );
			}
      	}
   	});
	
	//$('.ui-button .ui-widget .ui-state-default .ui-corner-all .ui-button-icon-only .ui-dialog-titlebar-close').hide();
});

//muestra el modal para agregar condominios
function showFormAddCondo(){
	idCondominio = 0;
	$('.bodyLoandingSend').hide();
	dialogCondo.dialog( 'open' );
	
}

//agrega un condominio a la residencial
function addCondominium(){
	
	$('#messageAlertModal').hide();
	
	if( $('#txtNameCondominio').val().trim().length == 0 ){
		
		$('#messageAlertModal').show();
		
	}else{
		
		$('.bodyLoandingSend').html('<img src="assets/img/web/loading.GIF" />');
		$('.bodyLoandingSend').show();
		
		isButtonModal = false;
		
		$.ajax({
			type: "POST",
			url: "condominium/saveCondominium",
			dataType:'json',
			data: {
				id:idCondominio,
				name:$('#txtNameCondominio').val().trim()
			},
			success: function(data){
				$('.bodyLoandingSend').hide();
				isButtonModal = true;
				dialogCondo.dialog( 'close' );
				getCondominiumsSearch();
				$("#divAlertWarningCondominium").hide();
				$('#alertCondominium').html(data);
				$('#divAlertCondominium').show(1000).delay(1500);
				$('#divAlertCondominium').hide(1000);
				//showMessageByDate();
			},
			error: function(data){
				$('.bodyLoandingSend').hide();
				isButtonModal = true;
				alert('error. Intentelo mas tarde');
				dialogCondo.dialog( 'close' );
			}
		});
		
	}
	
}

//muestra el formulario con los datos del condominio
//para editar
function showFormEditCondo(selector){
	
	idCondominio = $(selector).attr('value');
	
	dialogCondo.dialog( 'open' );
	
	$.ajax({
		type: "POST",
		url: "condominium/getCondoById",
		dataType:'json',
		data: {
			id:$(selector).attr('value')
		},
		success: function(data){
			if(data.length > 0){
				var item = data[0];
				$('#txtNameCondominio').val(item.nombre);
				
			}else{
				alert('datos no encontrados');
				dialogCondo.dialog( 'close' );
			}
			
			/*$('.bodyLoandingSend').hide();
			isButtonModal = true;
			//showMessageByDate();*/
		},
		error: function(data){
			/*$('.bodyLoandingSend').hide();
			isButtonModal = true;*/
			alert('error. Intentelo mas tarde');
		}
	});
}

function getCondominiumsSearch(){
	
	$.ajax({
		type: "POST",
		url: "condominium/getCondominiumSearch",
		dataType:'json',
		data: {
			dato:$('#textSeachCondo').val().trim()
		},
		success: function(data){
			$('#tableCondominium tbody').empty();
			for(var i = 0;i<data.items.length; i++){
				var item = data.items[i];
				$('#tableCondominium tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td><a  class="editCondominium" value="' + item.id  + '">' + item.nombre + '</a></td>' +
						'<td>' + item.residente + '</td>' +
						'<td><a class="btnAddUserCondo" value="' + item.id + '"><img id="imgAddUser" class="imgAddUser" src="assets/img/web/user-add.png"/></a></td>' +
						'<td><a class="btnDeleteCondo" value="' + item.id + '"><img id="imgDelete" class="imgDeleteItem" src="assets/img/web/delete.png"/></a></td>' +
					'</tr>'
				);
			}
			
			totalPaginadorM = parseInt(data.total/10);
			if(data.total%10 == 0){
				totalPaginadorM = totalPaginadorM - 1;		
			}
			totalPaginadorM = totalPaginadorM + 1
					
			$('#demo1').empty();
			paginadorActive();
			
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
		}
	});
	
}

//muestra el form para eliminar condominios
function showDeleteCondo(condominiumId){
	idCondominio = condominiumId;
	getNameOfResident();
	$('#divAlertWarningCondominium').hide();
	$('#divAlertWarningCondominium').toggle(800);
	//$('#textDeleteCondominium').html('¿Desea eliminar el condominio?');
}

function hideDeleteCondominium(){
	$('#divAlertWarningCondominium').toggle(800);
	idCondominio = 0;
}

function DeleteCondominium(){
	$.ajax({
		type: "POST",
		url: "condominium/deleteCondominium",
		dataType:'json',
		data: {
			id:idCondominio
		},
		success: function(data){
			hideDeleteCondominium();
			getCondominiumsSearch();
			$('#alertCondominium').html(data);
			$('#divAlertCondominium').show(1000).delay(1500);
			$('#divAlertCondominium').hide(1000);
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
			hideDeleteCondominium();
		}
	});
}

//obtiene los nombres de los residentes del condominio
function getNameOfResident(){
	$.ajax({
		type: "POST",
		url: "condominium/getResidentByCondominium",
		dataType:'json',
		data: {
			condominioId:idCondominio
		},
		success: function(data){
			var residenteNames = "";
			for(var i = 0;i<data.length;i++){
				var item = data[i];
				residenteNames = residenteNames + "</br>" + item.nombre + " " + item.apellido;
			}
			
			$('#textDeleteCondominium').html('¿Desea eliminar el condominio? con ' + residenteNames);
		},
		error: function(data){
		}
	});
}

//////////////////////////////////////////
/////////////////Residentes///////////////
//////////////////////////////////////////

var dialogResident;
var idCondominioResi = 0;
var residentId = 0;

//////////////index//////////////

$(document).on('click', '.btnAddUserCondo', function(){ showFormResident(this); });

$(document).on('click', '.editResident', function(){ showEditResident($(this).attr('value')); });

$(document).on('click', '.btnDeleteResident', function(){ showDeleteResident($(this).attr('value')); });

$(document).on('click', '#btnCancelDeleteResident', function(){ hideDeleteResident(); });

$(document).on('click', '#btnAcceptDeleteResident', function(){ DeleteResident(); });

$(document).on('click', '.checkResidentCondo', function(){ checkResidentCondo(this); });


//////////////Funciones//////////////

$(function() {
   dialogResident = $( "#dialog-formResidentes" ).dialog({
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
				text: "Nuevo Residente",
				"class": 'dialogButtonAceptar formTable',
				click: function() {
					if(isButtonModal){
						hideAlertResident();
						cleanFieldResident();
						formNewResident();
					}
				}
			},
			{
				text: "Asignar Residente",
				"class": 'dialogButtonAceptar formTable',
				click: function() {
					if(isButtonModal){
						formAssignResident();
					}
				}
			},
			{
				text: "Agregar",
				"class": 'dialogButtonAceptar formNew',
				click: function() {
					if(isButtonModal){
						addResident();
					}
				}
			},
			{
				text: "Guardar",
				"class": 'dialogButtonAceptar formEdit',
				click: function() {
					if(isButtonModal){
						editResident();
					}
				}
			},
			{
				text: "Asignar",
				"class": 'dialogButtonAceptar formAssign',
				click: function() {
					if(isButtonModal){
						assignResident();
					}
				}
			},
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel formTable',
				click: function() {
					if(isButtonModal){
						hideAlertResident();
						cleanFieldResident();
						dialogResident.dialog( "close" );
					}
				}
			},
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel formNewCancel',
				click: function() {
					if(isButtonModal){
						backFormTableResident();
					}
				}
			},
		],
      	close: function() {
			if(isButtonModal){
				dialogCondo.dialog( "close" );
			}
      	}
   	});
	
	//$('.ui-button .ui-widget .ui-state-default .ui-corner-all .ui-button-icon-only .ui-dialog-titlebar-close').hide();
});

function showFormResident(selector){

	idCondominioResi = $(selector).attr('value');
	
	getResidentByCondominium();
	
	//dialogResident.dialog( 'open' );
	
}

function formNewResident(){
	//getCondominio();
	$('#divTable').hide();
	$('#divFormResident').show();
	$('.formTable').hide();
	$('.formNew').show();
	$('.formNewCancel').show();
}

//obtiene los condominios actuvos
function getCondominio(){
	
	$.ajax({
		type: "POST",
		url: "condominium/getCondominio",
		dataType:'json',
		data: {
		},
		success: function(data){
			$('#selectCondominiumResident').empty();
			for(var i = 0; i< data.length; i++){
				var item = data[i];
				$('#selectCondominiumResident').append('<option value="' + item.id + '">' +  item.nombre + '</option>');
			}
			
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
			dialogResident.dialog( 'close' );
		}
	});
	
}

//llamat a la funcion para guardar los datos del residete
function addResident(){
	residentId = 0;
	var result = validateFieldResident();
	if(result){
		saveResidente();
	}
}

//llamat a la funcion para editar los datos del residente
function editResident(){
	var result = validateFieldResident();
	if(result){
		saveResidente();
	}
}

function validateFieldResident(){
	
	var result = true;
	
	hideAlertResident();
	
	if($('#textPassResident').val().trim().length == 0 && residentId == 0){
		$('#textPassResident').focus();
		$('#labelPassResident').addClass('error');
		$('#alertPassResident').show();
		result = false;
	}
	
	if($('#textEmailResident').val().trim().length == 0){
		$('#textEmailResident').focus();
		$('#labelEmailResident').addClass('error');
		$('#alertEmailResident').show();
		result = false;
	}
	
	if($('#textPhoneResident').val().trim().length == 0){
		$('#textPhoneResident').focus();
		$('#labelPhoneResident').addClass('error');
		$('#alertPhoneResident').show();
		result = false;
	}
	
	if($('#textLastNameResident').val().trim().length == 0){
		$('#textLastNameResident').focus();
		$('#labelLastNameResident').addClass('error');
		$('#alertLastNameResident').show();
		result = false;
	}
	
	if($('#textNameResident').val().trim().length == 0){
		$('#textNameResident').focus();
		$('#labelNameResident').addClass('error');
		$('#alertNameResident').show();
		result = false;
	}
	
	return result;
	
}

function hideAlertResident(){
	
	$('#labelNameResident').removeClass('error');
	$('#labelLastNameResident').removeClass('error');
	$('#labelPhoneResident').removeClass('error');
	$('#labelEmailResident').removeClass('error');
	$('#labelPassResident').removeClass('error');
	
	$('#alertNameResident').hide();
	$('#alertLastNameResident').hide();
	$('#alertPhoneResident').hide();
	$('#alertEmailResident').hide();
	$('#alertPassResident').hide();
	
}

function cleanFieldResident(){
	
	$('#textNameResident').val('');
	$('#textLastNameResident').val('');
	$('#textPhoneResident').val('');
	$('#textEmailResident').val('');
	$('#textPassResident').val('');
	
}

//guarda los datos del residente
function saveResidente(){
	
	$.ajax({
		type: "POST",
		url: "condominium/saveResident",
		dataType:'json',
		data: {
			id:residentId,
			name:$('#textNameResident').val().trim(),
			lastName:$('#textLastNameResident').val().trim(),
			phone:$('#textPhoneResident').val().trim(),
			condominioId:idCondominioResi,
			email:$('#textEmailResident').val().trim(),
			pass:$('#textPassResident').val().trim()
		},
		success: function(data){
			alert('residente guardado');
			$('#divTable').show();
			$('#divFormResident').hide();
			$('.formTable').show();
			$('.formNew').hide();
			getResidentByCondominium();
			getCondominiumsSearch();
			$("#divAlertWarningResident").hide();
			$('#alertResident').html(data);
			$('#divAlertResident').show(1000).delay(1500);
			$('#divAlertResident').hide(1000);
			
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
			dialogResident.dialog( 'close' );
		}
	});
	
}

function getResidentByCondominium(){
	
	$.ajax({
		type: "POST",
		url: "condominium/getResidentByCondominium",
		dataType:'json',
		data: {
			condominioId:idCondominioResi
		},
		success: function(data){
			$('.formNew').hide();
			$('.formEdit').hide();
			$('.formAssign').hide();
			$('.formNewCancel').hide();
			$('#divAssign').hide();
			$('#divTable').show();
			$('#divFormResident').hide();
			$('.formTable').show();
			dialogResident.dialog( 'open' );
			
			//$('.btnNewResident').hide();
			$('#tableResident tbody').empty();
			for(var i = 0;i<data.length; i++){
				var item = data[i];
				
				$('#tableResident tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td><a  class="editResident" value="' + item.id  + '">' + item.nombre + " " + item.apellido + '</a></td>' +
						'<td class="emailResident">' + item.email + '</td>' +
						'<td><a class="btnDeleteResident" value="' + item.id + '"><img id="imgDelete" class="imgDeleteItem" src="assets/img/web/delete.png"/></a></td>' +
					'</tr>'
				);
			}
			
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
		}
	});
	
}

//muestra los datos del residente
function showEditResident(idResident){
	
	residentId = idResident
	
	$.ajax({
		type: "POST",
		url: "condominium/getResidentById",
		dataType:'json',
		data: {
			id:idResident
		},
		success: function(data){
			var item = data[0];
			
			hideAlertResident();
			cleanFieldResident();
			
			$('#textNameResident').val(item.nombre);
			$('#textLastNameResident').val(item.apellido);
			$('#textPhoneResident').val(item.telefono);
			$('#textEmailResident').val(item.email);
			$('#textPassResident').val('');
			
			$('#divTable').hide();
			$('#divFormResident').show();
			$('.formTable').hide();
			$('.formEdit').show();
			$('.formNewCancel').show();
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
		}
	});
	
}

//muestra el form para eliminar un residente
function showDeleteResident(idResident){
	
	residentId = idResident;
	$('#divAlertWarningResident').hide();
	$('#divAlertWarningResident').toggle(800);
	
}

//esconde el form para eliminar un residente
function hideDeleteResident(){
	$('#divAlertWarningResident').toggle(800);
	residentId = 0;
}

//elimina el residente selecionado
function DeleteResident(){
	
	$.ajax({
		type: "POST",
		url: "condominium/deleteResident",
		dataType:'json',
		data: {
			id:residentId
		},
		success: function(data){
			hideDeleteResident();
			getResidentByCondominium();
			$('#alertResident').html(data);
			$('#divAlertResident').show(1000).delay(1500);
			$('#divAlertResident').hide(1000);
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
		}
	});
	
}

//muestra el fosrm para asignar residentes
function formAssignResident(){
	
	$.ajax({
		type: "POST",
		url: "condominium/getResidentByResidential",
		dataType:'json',
		data: {
			condominioId:idCondominioResi
		},
		success: function(data){
			console.log(data);
			$('.formNew').hide();
			$('#divTable').hide();
			$('#divFormResident').hide();
			$('.formTable').hide();
			$('#divAssign').show();
			$('.formAssign').show();
			$('.formNewCancel').show();
			
			$('#tableAssignResident tbody').empty();
			for(var i = 0;i<data.length; i++){
				var item = data[i];
				
				$('#tableAssignResident tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td><a  class="editResident" value="' + item.id  + '">' + item.nombre + " " + item.apellido + '</a></td>' +
						'<td>' + item.email + '</td>' +
						'<td><input type="checkbox" id="checkRC' + item.id + '" class="checkResidentCondo" ' +
						'idUser="' + item.id + '" />' +
						'</td>' +
					'</tr>'
				);
				
				$('#tableResident tbody tr').each(function(index, element) {
					var emailResident = "";
					$(this).children("td").each(function (index2){
						switch (index2){
							case 2:
								emailResident = $(this).text();
                            break;
						}
					});
            		
					if(item.email == emailResident){
						$('#checkRC' + item.id).prop('checked', true);
						$('#checkRC' + item.id).prop('disabled', true);
					}	 
          		});
				
			}
			
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
		}
	});
	
}

function checkResidentCondo(selector){
	//alert($(selector).attr('idUser'));
	if($(selector).prop('checked')){
		$('#tableAssignResidentId tbody').append('<tr id="' + $(selector).attr('idUser') + '"><td>' + $(selector).attr('idUser') + '</td></tr>');
	}else{
		$('#' + $(selector).attr('idUser')).remove();
	}
}

function assignResident(){
	var arrayResidentId = new Array();
	$('#tableAssignResidentId tbody tr').each(function(index, element) {
		$(this).children("td").each(function (index2){
			switch (index2){
				case 0:
					arrayResidentId.push($(this).text());
				break;
			}
		});
	});
	
	if(arrayResidentId.length > 0){
		var idResidentAdd = JSON.stringify(arrayResidentId);
		
		$.ajax({
			type: "POST",
			url: "condominium/assignResident",
			dataType:'json',
			data: {
				ResidentId:idResidentAdd,
				condominioId:idCondominioResi
			},
			success: function(data){
				$('#tableAssignResidentId tbody').empty();
				getResidentByCondominium();
				getCondominiumsSearch();
				$("#divAlertWarningResident").hide();
				$('#alertResident').html(data);
				$('#divAlertResident').show(1000).delay(1500);
				$('#divAlertResident').hide(1000);
				
			},
			error: function(data){
				alert('error. Intentelo mas tarde');
			}
		});
		
	}else{
		
	}
}

//regresa a la tabla residentes
function backFormTableResident(){
	$('.formNew').hide();
	$('.formEdit').hide();
	$('.formAssign').hide();
	$('.formNewCancel').hide();
	$('#divAssign').hide();
	$('#divTable').show();
	$('#divFormResident').hide();
	$('.formTable').show();
}

$(document).ready(function() { paginadorActive(); });


/*********************************/
/************Paginador************/
/*********************************/

function paginadorActive(){    
	$("#demo1").paginate({
		count: totalPaginadorM,
		start: 1,
		display: 6,
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
			$('._current', '#paginationdemo').removeClass('_current').hide();
			$('#p' + page).addClass('_current').show();
			paginadorCondo(page);
		}
	});
	$('.jPag-first').html('Primero');
	$('.jPag-last').html('Ultimo');
}

function paginadorCondo(num){
	
	var cantidad = (num-1) *10;
	
	$.ajax({
		type: "POST",
		url: "condominium/getCondominiumPaginador",
		dataType:'json',
		data: {
			num:cantidad,
			dato:$('#textSeachCondo').val(),
		},
		success: function(data){
			console.log(data)
			$('#tableCondominium tbody').empty();
			for(var i = 0;i<data.length; i++){
				var item = data[i];
				$('#tableCondominium tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td><a  class="editCondominium" value="' + item.id  + '">' + item.nombre + '</a></td>' +
						'<td>' + item.residente + '</td>' +
						'<td><a class="btnAddUserCondo" value="' + item.id + '"><img id="imgAddUser" class="imgAddUser" src="assets/img/web/user-add.png"/></a></td>' +
						'<td><a class="btnDeleteCondo" value="' + item.id + '"><img id="imgDelete" class="imgDeleteItem" src="assets/img/web/delete.png"/></a></td>' +
					'</tr>'
				);
			}
		},
		error: function(data){
			alert('Error, intentelo mas tarde');
		}
	});
	
}