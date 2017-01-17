/**
 * GeekBucket 2015
 * Author: Alfredo chi
 * Define funcionalidad de la pantalla de sugerencias
 *
 */

///////////variables/////////////
var dialog;

//////////////index//////////////
$(document).on('click','.bodyMSGRectRounded',function(){ showSuggestion(this); });

$(document).on('click','#btnSuggestionDate',function(){ showSuggestionByDate(); });

///////////funciones/////////////

function showSuggestion(selector){
	
	$('.bodyRectborderless').hide();
	
	$('.bodyLoanding').html('<img src="assets/img/web/loading2.GIF" />');
	$('.bodyLoanding').show();
	
	var idMessage = $(selector).attr('value');
	var typeMessage = $(selector).attr('id');
	
	$.ajax({
		type: "POST",
		url: "suggestion/getSuggestionById",
		dataType:'json',
		data: {
			id:idMessage,
			typeM:typeMessage
		},
		success: function(data){
			item = data[0];
			$('#dateMessage2').html(item.dia + ", " + item.fechaFormat + " " + item.hora );
				
			$('#subjectMessage').html( item.asunto );
			$('#infoMessage').html( item.mensaje );
			$('#guardMessage').html( "Enviado por: " + item.nombreResidente + " " + item.apellidosResidente );
				
			$('#bodyRectborderless').show();
			$('.bodyLoanding').hide();
        },
		error: function(data){
			$('.bodyLoanding').hide();
			alert('error. Intentelo mas tarde');
        }
	});
	
}

function showSuggestionByDate(){
	
	if($('#endDateMsg').val() >= $('#iniDateMsg').val()){
	
		$.ajax({
			type: "POST",
			url: "suggestion/getSuggestionByDate",
			dataType:'json',
			data: {
				iniDate:$('#iniDateMsg').val(),
				endDate:$('#endDateMsg').val()
			},
			success: function(data){
				console.log(data);
				var items = data.items;
				if( items.length > 0 ){
					$('#tableSuggestion tbody').empty();
					for(var i=0; i< items.length; i++){
						$('#tableSuggestion tbody').append(
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

/*********************************/
/************Paginador************/
/*********************************/

$(document).ready(function() { paginadorActive(); });

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
		url: "suggestion/getSuggestionPaginador",
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
				$('#tableSuggestion tbody').empty();
				for(var i=0; i< items.length; i++){
					$('#tableSuggestion tbody').append(
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
