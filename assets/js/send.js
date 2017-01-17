/**
 * GeekBucket 2015
 * Author: Alfredo chi
 * Define funcionalidad el dashboard de booking
 *
 */

///////////variables/////////////
var dialogAdmin;
var isButtonModal = true

//////////////index//////////////
//muestra los datos del mensaje
$(document).on('click','.bodyMSGRectRounded',function(){ showMessage(this); });

//realiza una busqueda por fecha
$(document).on('click','#btnMessageDate',function(){ showMessageByDate(); });

//muestra el formulario para mandar un mensaje nuevo
$(document).on('click','#btmAddMsgAdmin',function(){ showFormNewMessageAdmin(); });

///////////funciones/////////////
 
$(function() {
   dialogAdmin = $( "#dialog-MessageAdmin" ).dialog({
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
						sendMessaje();
					}
				}
			},
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel',
				click: function() {
					if(isButtonModal){
						dialogAdmin.dialog( "close" );
					}
				}
			},
		],
      	close: function() {
			if(isButtonModal){
				dialogAdmin.dialog( "close" );
			}
      	}
   	});
	
	//$('.ui-button .ui-widget .ui-state-default .ui-corner-all .ui-button-icon-only .ui-dialog-titlebar-close').hide();
});

function showMessage(selector){
	
	$('.bodyRectborderless').hide();
	
	$('.bodyLoanding').html('<img src="assets/img/web/loading2.GIF" />');
	$('.bodyLoanding').show();
	
	var idMessage = $(selector).attr('value');
	var typeMessage = $(selector).attr('id');
	
	$.ajax({
		type: "POST",
		url: "send/getMessageAdminById",
		dataType:'json',
		data: {
			id:idMessage,
			typeM:typeMessage
		},
		success: function(data){
			console.log(data)
			item = data[0];
			$('#dateMessage2').html(item.dia + ", " + item.fechaFormat + " " + item.hora );
				
			$('#subjectMessage').html( item.asunto );
			$('#infoMessage').html( item.mensaje );
			$('#guardMessage').html( "Enviado por: " + item.nombreEmpleado + " " + item.apellidosEmpleado );
				
			$('#bodyRectborderless').show();
			$('.bodyLoanding').hide();
        },
		error: function(data){
			$('.bodyLoanding').hide();
			alert('error. Intentelo mas tarde');
        }
	});
	
}

function showMessageByDate(){
	
	if($('#endDateMsg').val() >= $('#iniDateMsg').val()){
	
		$.ajax({
			type: "POST",
			url: "send/getMessageAdminByDate",
			dataType:'json',
			data: {
				iniDate:$('#iniDateMsg').val(),
				endDate:$('#endDateMsg').val()
			},
			success: function(data){
				var items = data.items;
				if( items.length > 0 ){
					$('#tableSend tbody').empty();
					for(var i=0; i< items.length; i++){
						$('#tableSend tbody').append(
							'<tr>' +
								'<td>' +
									'<div class="bodyMSGRectRounded" value="' + items[i].id +'" id="message">' +
										'<div class="labeDateRectRounded">' + items[i].dia + ", " + items[i].fechaFormat +'</div>' +
										'<div class="labeInfoRectRounded">' + items[i].asunto +'</div>' +
									'</div>' +
								'</td>' +
							'</tr>'
						);
					}
					
					totalPaginadorM = parseInt(data.total/10);
					if(data.total%10 == 0){
						totalPaginadorM = totalPaginadorM - 1;		
					}
					totalPaginadorM = totalPaginadorM + 1
					console.log(totalPaginadorM)
					
					$('#demo1').empty();
					paginadorActive();
					
				}else{
					
				}
				
			},
			error: function(data){
				console.log(data);
				alert('error. Intentelo mas tarde');
			}
		});
	}else{
		alert('El campo fecha final debe ser mayor o igual al campo fecha inicio')
	}
	
}

//muestra el formulario para mandar un nuevo mensaje
function showFormNewMessageAdmin(){
	
	$('#txtSubjectMSGAdmin').val("");
	$('#txtMessageMSGAdmin').val("");
	dialogAdmin.dialog( 'open' );
	
}

function sendMessaje(){
	
	$('#messageAlertModal').hide();
	if( $('#txtSubjectMSGAdmin').val().trim().length == 0 || $('#txtMessageMSGAdmin').val().trim().length == 0){
		$('#messageAlertModal').show();
	}else{
		
		$('.bodyLoandingSend').html('<img src="assets/img/web/loading.GIF" />');
		$('.bodyLoandingSend').show();
		
		isButtonModal = false;
		
		$.ajax({
			type: "POST",
			url: "send/sendMessageOfAdmin",
			dataType:'json',
			data: {
				subject:$('#txtSubjectMSGAdmin').val(),
				message:$('#txtMessageMSGAdmin').val()
			},
			success: function(data){
				$('.bodyLoandingSend').hide();
				isButtonModal = true;
				dialogAdmin.dialog( 'close' );
				showMessageByDate();
			},
			error: function(data){
				$('.bodyLoandingSend').hide();
				isButtonModal = true;
				alert('error. Intentelo mas tarde');
				dialogAdmin.dialog( 'close' );
			}
		});
		
	}
}

$(document).ready(function() { paginadorActive(); });


/*********************************/
/************Paginador************/
/*********************************/

function paginadorActive(){    
	$("#demo1").paginate({
		count: totalPaginadorM,
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
			$('._current', '#paginationdemo').removeClass('_current').hide();
			$('#p' + page).addClass('_current').show();
			paginadorMessage(page);
		}
	});
	$('.jPag-first').html('Primero');
	$('.jPag-last').html('Ultimo');
}

function paginadorMessage(num){
	
	var cantidad = (num-1) *10;
	
	$.ajax({
		type: "POST",
		url: "send/getMessagePaginador",
		dataType:'json',
		data: {
			num:cantidad,
			iniDate:$('#iniDateMsg').val(),
			endDate:$('#endDateMsg').val()
		},
		success: function(data){
			total = data.length;
			var items = data;
			if( items.length > 0 ){
				$('#tableSend tbody').empty();
				for(var i=0; i< items.length; i++){
					$('#tableSend tbody').append(
						'<tr>' +
							'<td>' +
								'<div class="bodyMSGRectRounded" value="' + items[i].id +'" id="message">' +
									'<div class="labeDateRectRounded">' + items[i].dia + ", " + items[i].fechaFormat +'</div>' +
									'<div class="labeInfoRectRounded">' + items[i].asunto +'</div>' +
								'</div>' +
							'</td>' +
						'</tr>'
					);
				}
			}else{
				
			}	
		},
		error: function(data){
			alert('Error, intentelo mas tarde');
		}
	});
	
}
