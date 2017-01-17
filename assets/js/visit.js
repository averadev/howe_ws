/**
 * GeekBucket 2015
 * Author: Alfredo chi
 * Define funcionalidad de mensajes visitas de booking
 *
 */

///////////variables/////////////
var dialogVisit;
var isButtonModal = true;

//////////////index//////////////

//muestra el formulario para agregar condominios

$(document).on('click', '.btnSeeMore', function(){ showInfoVisit(this); });

$('#checkboxFilter').click(function(){ showFilterCondominium(this); });

//busqueda por fecha y/o filtro
$('#btnVisitDate').click(function(){ searchByDateAndFilter(); });

///////////funciones/////////////


$(function() {
   dialogVisit = $( "#dialog-formVisit" ).dialog({
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
				text: "Cerrar",
				"class": 'dialogButtonCancel',
				click: function() {
					if(isButtonModal){
						dialogVisit.dialog( "close" );
					}
				}
			},
		],
      	close: function() {
			if(isButtonModal){
				dialogVisit.dialog( "close" );
			}
      	}
   	});
	
	//$('.ui-button .ui-widget .ui-state-default .ui-corner-all .ui-button-icon-only .ui-dialog-titlebar-close').hide();
});

//muestra u oculta los filtros de condominios
function showFilterCondominium(selector){
	
	if($(selector).prop('checked')){
		$('#FilterCodominium').show();
	}else{
		$('#FilterCodominium').hide();
	}
	
}

//realiza una busqueda por fechas y/o filtro
function searchByDateAndFilter(){
	
	var idCondominio = 0;
	if($('#checkboxFilter').prop('checked')){
		idCondominio = $('#selectCondominium').val();
	}
	
	$.ajax({
		type: "POST",
		url: "visit/getVisitByDateAndFilter",
		dataType:'json',
		data: {
			iniDate:$('#iniDateVisit').val(),
			endDate:$('#endDateVisit').val(),
			idCondominium:idCondominio
		},
		success: function(data){
			console.log(data);
			$('#tableVisit tbody').empty();
			if(data.items.length > 0){
				
				for(var i = 0;i<data.items.length; i++){
					var item = data.items[i];
					
					var provider = "";
					if( item.proveedor == 1 ){
						provider = '<img class="imgAddUser" src="assets/img/web/tick.png"/>';
					}
				
					$('#tableVisit tbody').append(
						'<tr>' +
							'<td>' + (i + 1) + '</td>' +
							'<td>' + item.nombreCondominio + '</td>' +
							'<td>' + item.fechaHora + '</td>' +
							'<td>' + item.motivo + '</td>' +
							'<td>' + item.nombreVisitante + '</td>' +
							'<td>' + provider + '</td>' +
							'<td><a class="btnSeeMore" value="' + item.id + '"><img class="imgDeleteItem" src="assets/img/web/eye.png"/></a></td>' +
						'</tr>'
					);
				
				}
				
				totalPaginadorV = parseInt(data.total/10);
				if(data.total%10 == 0){
					totalPaginadorV = totalPaginadorV - 1;		
				}
				totalPaginadorV = totalPaginadorV + 1
						
				$('#demo1').empty();
				paginadorActive();
				
			}else{
				
				$('#tableVisit tbody').append(
					'<tr >' +
						'<td colspan="8" style="text-align:center;">No se encontro visitas registradas</td>' + 
					'</tr>'
				);
				
			}
		},
		error: function(data){
			
			alert('error. Intentelo mas tarde');
		}
	});
	
}

function showInfoVisit(selector){
	
	dialogVisit.dialog( 'open' );
	
	$.ajax({
		type: "POST",
		url: "visit/getVisitById",
		dataType:'json',
		data: {
			id:$(selector).attr('value')
		},
		success: function(data){
			var item = data[0];
			console.log(item)
			$('#textGuardVisit').val( item.nameEmplado + " " + item.apellidosEmpleados );
			$('#textNameVisit').val(item.nombreVisitante);
			$('#textReasonVisit').val(item.motivo);
			$('#textCondominiumVisit').val(item.nombreCondominio);
			
			$('#dateVisit').html(item.dia + ", " + item.fechaFormat + " " + item.hora);
			
			$('#imgFrenteVisit').attr('src','assets/img/app/visit/' + item.idFrente );
			
			$('#imgAtrasVisit').attr('src','assets/img/app/visit/' + item.idVuelta );
			
			if(item.proveedor == 1){
				$('#providerVisit').html("Proveedor");
			}else{
				$('#providerVisit').html("");
			}
			
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
			dialogVisit.dialog( 'close' );
		}
	});
	
}

/*********************************/
/************Paginador************/
/*********************************/

$(document).ready(function() { paginadorActive(); });

function paginadorActive(){    
	$("#demo1").paginate({
		count: totalPaginadorV,
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
			paginadorVisit(page);
		}
	});
	$('.jPag-first').html('Primero');
	$('.jPag-last').html('Ultimo');
}

function paginadorVisit(num){
	
	var idCondominio = 0;
	if($('#checkboxFilter').prop('checked')){
		idCondominio = $('#selectCondominium').val();
	}
	
	var cantidad = (num-1) *10;
	
	$.ajax({
		type: "POST",
		url: "visit/getVisitPaginador",
		dataType:'json',
		data: {
			num:cantidad,
			iniDate:$('#iniDateVisit').val(),
			endDate:$('#endDateVisit').val(),
			idCondominium:idCondominio
		},
		success: function(data){
			console.log(data)
			$('#tableVisit tbody').empty();
				
			for(var i = 0;i<data.length; i++){
				var item = data[i];
					
				var provider = "";
				if( item.proveedor == 1 ){
					provider = '<img class="imgAddUser" src="assets/img/web/tick.png"/>';
				}
				
				$('#tableVisit tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td>' + item.nombreCondominio + '</td>' +
						'<td>' + item.fechaHora + '</td>' +
						'<td>' + item.motivo + '</td>' +
						'<td>' + item.nombreVisitante + '</td>' +
						'<td>' + provider + '</td>' +
						'<td><a class="btnSeeMore" value="' + item.id + '"><img class="imgDeleteItem" src="assets/img/web/eye.png"/></a></td>' +
					'</tr>'
				);
				
			}
		},
		error: function(data){
			alert('Error, intentelo mas tarde');
		}
	});
	
}
