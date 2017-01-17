/**
 * GeekBucket 2015
 * Author: Alfredo chi
 * Define funcionalidad el dashboard de booking
 *
 */

///////////variables/////////////
var dialog;

//////////////index//////////////
$(document).on('click','.bodyMSGRectRounded',function(){ showModalMessage(this); });

///////////funciones/////////////
 
$(function() {
   dialog = $( "#dialog-Message" ).dialog({
   		autoOpen: false,
      	height: "auto",
      	width: "60%",
      	modal: true,
		dialogClass: 'dialogModal',
		buttons: [
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel',
				click: function() {
					dialog.dialog( "close" );
				}
			},
		],
      	close: function() {
			$('.bodyLoanding').empty();
      	}
   	});
});

function showModalMessage(selector){
	
	$('.bodyLoanding').append('<img src="assets/img/web/loading.GIF" />');
	$('.bodyLoanding').show();

	
	var idMessage = $(selector).attr('value');
	var typeMessage = $(selector).attr('id');
	
	if(typeMessage == "message"){
		//$('dialog-Message').attr('title','Notificaciones de seguridad');
		$('.ui-dialog-title').html('Notificaciones de seguridad');
	}else if(typeMessage == "visit"){
		//$('dialog-Message').attr('title','Notificaciones de visitas');
		$('.ui-dialog-title').html('Notificaciones de visitas');
	}
	
	dialog.dialog( "open" );
	
	$.ajax({
		type: "POST",
		url: "dashboard/getMessageById",
		dataType:'json',
		data: {
			id:idMessage,
			typeM:typeMessage
		},
		success: function(data){
			console.log(data)
			item = data[0];
			$('#dateMessage').html(item.dia + ", " + item.fechaFormat + " " + item.hora );
			if(typeMessage == "message"){
				
				$('#subjectMessage').html( item.asunto );
				$('#infoMessage').html( item.mensaje );
				$('#guardMessage').html( item.nombreEmpleado + " " + item.apellidosEmpleado );
				
				
				
				$('#messageAdmin').show();
				$('#messageVisit').hide();
			}else if(typeMessage == "visit"){
				
				$('#nameVisit').html( item.nombreVisitante );
				$('#reasonVisit').html( item.motivo );
				$('#guardVisit').html( item.nombreEmpleado + " " + item.apellidosEmpleado );
				$('#condominiusVisit').html( item.nombreCondominio );
				
				$('#messageVisit').show();
				$('#messageAdmin').hide();
			}
			$('.bodyLoanding').hide();
        },
		error: function(data){
			console.log(data)
			alert('error');
        }
	});
	
	
}


/*********************************/
/************Paginador************/
/*********************************/

$(function () {            
	$("#demo5").paginate({
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
			$('._current', '#paginationdemoA').removeClass('_current').hide();
			$('#p' + page).addClass('_current').show();
			paginador(page, "dashboardMessage", "");
		}
	});
	$('.jPag-first').html('Primero');
	$('.jPag-last').html('Ultimo');
			
	$("#demo4").paginate({
		count: totalPaginadorV,
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
			paginador(page, "dashboardVisit", "");
		}
	});
	$('.jPag-first').html('Primero');
	$('.jPag-last').html('Ultimo');
});

function paginador(num, type, dato){
	
	var url = "";
	switch(type){
		case "dashboardMessage":
			url = "dashboard/getMessagePaginador";
		break;
		case "dashboardVisit":
			url = "dashboard/getVisitPaginador";
		break;
	}
	
	getInfoPaginador(num, type, url, dato);	
}

function getInfoPaginador(num, type, url, dato){
	
	var cantidad = (num-1) *10;
	
	$.ajax({
		type: "POST",
		url: url,
		dataType:'json',
		data: {
			num:cantidad,
			dato:dato
		},
		success: function(data){
			total = data.length;
			switch(type){
				case "dashboardMessage":     
					$('#tableMessageDash tbody').empty();
					for(var i = 0;i<total;i++){
						var item = data[i];
						$('#tableMessageDash tbody').append("<tr>" + 
							"<td>" +
								'<div class="bodyMSGRectRounded" value="' + item.id + '" id="message">' + 
									'<div class="labeDateRectRounded">' + item.dia + ", " + item.fechaFormat + '</div>' +
									'<div class="labeInfoRectRounded">' + item.asunto + '</div>' +
								'</div>' +
							"</td>"+
						"</tr>");
					}
				break;
				case "dashboardVisit":     
					$('#tableVisitDash tbody').empty();
					for(var i = 0;i<total;i++){
						var item = data[i];
						var proveedor = "";
						if(item.proveedor == 1){
							proveedor = "PROVEDOR";
						}
						$('#tableVisitDash tbody').append("<tr>" + 
							"<td>" +
								'<div class="bodyMSGRectRounded" value="' + item.id + '" id="visit">' +
									'<div class="labeProviderRectRounded">' + proveedor +'</div>' +
									'<div class="labeDateRectRounded">' + item.dia + ", " + item.fechaFormat + '</div>' +
									'<div class="labeInfoRectRounded">CONDO ' + item.nameCondominium + ': ' + item.motivo + '</div>' +
								'</div>' +
							"</td>"+
						"</tr>");
					}
				break;
			}
		}
		,
		error: function(data){
			alert('Error, intentelo mas tarde');
		}
	});
	
}
