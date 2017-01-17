/**
 * GeekBucket 2015
 * Author: Alfredo chi
 * Define funcionalidad el condominios de booking
 *
 */

///////////variables/////////////
var dialogGuard;
var isButtonModal = true;
var idGuard = 0;
var lokedButton = 0;

//////////////index//////////////

//muestra el formulario para agregar condominios
$('#btnAddGuard').click(function(){ showFormAddCondo(); });

$(document).on('click', '.editGuard', function(){ showFormEditGuard(this); });

$(document).on('click', '.imageDeleteMessage', function(){ showFormDeleteGuard(this); });

$(document).on('click', '#btnCancelDeleteGuard', function(){ hideFormDeleteGuard(this); });

$(document).on('click', '#btnAcceptDeleteGuard', function(){ deleteGuard(this); });

$("#imgImagen").click(function() {changeImage()});

$('#btnSeachGuard').click(function() { getGuardSearch(); });

$('#textSeachGuard').keyup(function(e){
    if(e.keyCode ==13){
	getGuardSearch();	
    }
});

///////////funciones/////////////

$(function() {
   dialogGuard = $( "#dialog-formGuard" ).dialog({
   		autoOpen: false,
		//open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog | ui).hide(); }
      	height: "auto",
		minHeight:'500',
      	width: "90%",
      	modal: true,
		dialogClass: 'dialogModal',
		buttons: [
			{
				text: "Guardar",
				"class": 'dialogButtonAceptar',
				click: function() {
					if(isButtonModal){
						isButtonModal = false;
						addGuard();
					}
				}
			},
			{
				text: "Cancelar",
				"class": 'dialogButtonCancel',
				click: function() {
					if(isButtonModal){
						dialogGuard.dialog( "close" );
					}
				}
			},
		],
      	close: function() {
			if(isButtonModal){
				dialogGuard.dialog( "close" );
			}
      	}
   	});
	
	//$('.ui-button .ui-widget .ui-state-default .ui-corner-all .ui-button-icon-only .ui-dialog-titlebar-close').hide();
});

//muestra el modal para agregar condominios
function showFormAddCondo(){
	cleanFieldGuard();
	hideAlertGuard();
	idGuard = 0;
	$('.bodyLoandingSend').hide();
	dialogGuard.dialog( 'open' );
	
}

//llama a los formuarios para agregar guardias
function addGuard(){
	
	//saveGuard("aaa",0);
	if(validateGuard()){
		if(idGuard == 0){
			uploadImage(0);
		}else{
			if(document.getElementById('fileImagen').value == "" ){
				saveGuard($('#imagenName').val(),idGuard);
			}else{
				uploadImage(idGuard);
			}
			
		}
	}else{
		isButtonModal = true
	}
}

//sube la imagen al servidor
function uploadImage(id){
	
	//creamos la variable Request 
	if(window.XMLHttpRequest) {
 		var Req = new XMLHttpRequest(); 
 	}else if(window.ActiveXObject) { 
 		var Req = new ActiveXObject("Microsoft.XMLHTTP"); 
 	}	
	
	var data = new FormData(); 
		
	var ruta;
		
	if(document.getElementById('fileImagen').value != ""){
		var archivos = document.getElementById("fileImagen");//Damos el valor del input tipo file
 		var archivo = archivos.files; //obtenemos los valores de la imagen
		data.append('image',archivo[0]);
		ruta = "assets/img/app/user/";
	}
	
	//rutaJson = JSON.stringify(ruta);
	data.append('ruta',ruta);
		
	data.append('nameImage',$('#imagenName').val());
		
	//cargamos los parametros para enviar la imagen
	Req.open("POST", "guard/uploadImage", true);
		
	//nos devuelve los resultados
	Req.onload = function(Event) {
			//Validamos que el status http sea ok 
	if (Req.status == 200) {
 	 	//Recibimos la respuesta de php
  		var nameImage = Req.responseText;
			saveGuard(nameImage,id);
		} else { 
  			alert(Req.status); //Vemos que paso.
		} 	
	};
		
	//Enviamos la petición 
 	Req.send(data);
}

//agrega un condominio a la residencial
function saveGuard(nameImage, id){
		
	$('.bodyLoandingSend').html('<img src="assets/img/web/loading.GIF" />');
	$('.bodyLoandingSend').show();
		
	isButtonModal = false;
		
	$.ajax({
		type: "POST",
		url: "guard/saveGuard",
		dataType:'json',
		data: {
			id:id,
			nombre:$('#textNameGuard').val(),
			apellidos:$('#textLastNameGuard').val(),
			telefono:$('#textPhoneGuard').val(),
			direccion:$('#textAddressGuard').val(),
			ciudad:$('#textCityGuard').val(),
			estado:$('#textStateGuard').val(),
			email:$('#textEmailGuard').val(),
			contrasena:$('#textPassGuard').val(),
			foto:nameImage,
		},
		success: function(data){
			$('.bodyLoandingSend').hide();
			isButtonModal = true;
			dialogGuard.dialog( 'close' );
			$('#alertGuard').html(data);
			$('#divAlertGuard').show(1000).delay(1500);
			$('#divAlertGuard').hide(1000);
			getGuardSearch();
			//getCondominiumsSearch();
			//showMessageByDate();
		},
		error: function(data){
			$('.bodyLoandingSend').hide();
			isButtonModal = true;
			alert('error. Intentelo mas tarde');	
			dialogGuard.dialog( 'close' );
		}
	});
	
}

//muestra el formulario con los datos del condominio
//para editar
function showFormEditGuard(selector){
	hideAlertGuard();
	cleanFieldGuard();
	idGuard = $(selector).attr('value');
	
	dialogGuard.dialog( 'open' );
	
	$.ajax({
		type: "POST",
		url: "guard/getGuardById",
		dataType:'json',
		data: {
			id:$(selector).attr('value')
		},
		success: function(data){
			if(data.length > 0){
				var item = data[0];
				$('#textNameGuard').val(item.nombre);
				$('#textLastNameGuard').val(item.apellidos);
				$('#textPhoneGuard').val(item.telefono);
				$('#textAddressGuard').val(item.direccion);
				$('#textCityGuard').val(item.ciudad);
				$('#textStateGuard').val(item.estado);
				$('#textEmailGuard').val(item.email);
				
				$('#imgImagen').attr("src",URL_IMG + "app/user/" + item.foto + "?version=" + (new Date().getTime()))
				$('#imagenName').val(item.foto);
				
			}else{
				alert('datos no encontrados');
				dialogGuard.dialog( 'close' );
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

function getGuardSearch(){
	
	$.ajax({
		type: "POST",
		url: "guard/getGuardSearch",
		dataType:'json',
		data: {
			dato:$('#textSeachGuard').val().trim()
		},
		success: function(data){
			
			$('#tableGuard tbody').empty();
			for(var i = 0;i<data.items.length; i++){
				var item = data.items[i];
				$('#tableGuard tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td><a  class="editGuard" value="' + item.id  + '">' + item.nombre + " " + item.apellidos + '</a></td>' +
						'<td><a class="imageDeleteMessage" value="' + item.id + '"><img id="imgDelete" class="imgDeleteItem" src="assets/img/web/delete.png"/></a></td>' +
					'</tr>'
				);
			}
			
			totalPaginadorG = parseInt(data.total/10);
			if(data.total%10 == 0){
				totalPaginadorG = totalPaginadorG - 1;		
			}
			totalPaginadorG = totalPaginadorG + 1
						
			$('#demo1').empty();
			paginadorActive();
			
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
		}
	});
	
}

//valida el formulario de guardias nuevos
function validateGuard(){
	
	var result = true;
	
	hideAlertGuard();
	
	//valida que se haya selecionado una imagen
    //sizeImage = imgRealSize($("#imgImagen"));
    if($('#imagenName').val() == 0 && $('#fileImagen').val().length == 0){
		$('#alertImageGuard').html("Campo vacio. Selecione una imagen");
		$('#alertImageGuard').show();
		$('#labelImage').addClass('error');
		result = false;
	//valida el tamaño de la imagen
	}/*else if(sizeImage.width != 140 || sizeImage.height != 140){
        $('#alertImage').html("El tamaño no corresponde: 140x140");
        $('#alertImage').show();
        $('#labelImage').addClass('error');
        result = false;
    }*/
	
	if($('#textPassGuard').val().trim().length == 0 && idGuard == 0){
		$('#textPassGuard').focus();
		$('#labelPassGuard').addClass('error');
		$('#alertPassGuard').show();
		result = false;
	}
	
	if($('#textEmailGuard').val().trim().length == 0){
		$('#textEmailGuard').focus();
		$('#labelEmailGuard').addClass('error');
		$('#alertEmailGuard').show();
		result = false;
	}
	
	if($('#textStateGuard').val().trim().length == 0){
		$('#textStateGuard').focus();
		$('#labelStateGuard').addClass('error');
		$('#alertStateGuard').show();
		result = false;
	}
	
	if($('#textCityGuard').val().trim().length == 0){
		$('#textCityGuard').focus();
		$('#labelCityGuard').addClass('error');
		$('#alertCityGuard').show();
		result = false;
	}
	
	if($('#textAddressGuard').val().trim().length == 0){
		$('#textAddressGuard').focus();
		$('#labelPhoneGuard').addClass('error');
		$('#alertAddressGuard').show();
		result = false;
	}
	
	if($('#textPhoneGuard').val().trim().length == 0){
		$('#textPhoneGuard').focus();
		$('#labelPhoneGuard').addClass('error');
		$('#alertPhoneGuard').show();
		result = false;
	}
	
	if($('#textLastNameGuard').val().trim().length == 0){
		$('#textLastNameGuard').focus();
		$('#labelLastNameGuard').addClass('error');
		$('#alertLastNameGuard').show();
		result = false;
	}
	
	if($('#textNameGuard').val().trim().length == 0){
		$('#textNameGuard').focus();
		$('#labelNameGuard').addClass('error');
		$('#alertNameGuard').show();
		result = false;
	}
	
	return result;
	
}

function hideAlertGuard(){
	
	$('#labelNameGuard').removeClass('error');
	$('#labelLastNameGuard').removeClass('error');
	$('#labelPhoneGuard').removeClass('error');
	$('#labelAddressGuard').removeClass('error');
	$('#labelCityGuard').removeClass('error');
	$('#labelStateGuard').removeClass('error');
	$('#labelEmailGuard').removeClass('error');
	$('#labelPassGuard').removeClass('error');
	$('#labelImage').removeClass('error');
	
	$('#alertNameGuard').hide();
	$('#alertLastNameGuard').hide();
	$('#alertPhoneGuard').hide();
	$('#alertAddressGuard').hide();
	$('#alertCityGuard').hide();
	$('#alertStateGuard').hide();
	$('#alertEmailGuard').hide();
	$('#alertPassGuard').hide();
	$('#alertImageGuard').hide();
	
}

//limpia los campos
function cleanFieldGuard(){
	$('#textNameGuard').val("");
	$('#textLastNameGuard').val("");
	$('#textPhoneGuard').val("");
	$('#textAddressGuard').val("");
	$('#textCityGuard').val("");
	$('#textStateGuard').val("");
	$('#textEmailGuard').val("");
	$('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
	document.getElementById('fileImagen').value ='';
	$('#imagenName').val(0);
	
}

////////* visualizacion de la imagen *//////////////

//abre el explorador de archivos cuando le das click a la imagen de cupones
function changeImage(){
	$('#fileImagen').click();
}

//muestra la imagen en la pagina
$(window).load(function(){
	$(function() {
		$('#fileImagen').change(function(e) {
			$('#labelImage').removeClass('error');
			$('#alertImageGuard').hide();
			$('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
			if($('#imagenName').val() != 0){
				$('#imgImagen').attr("src",URL_IMG + "app/deal/" + $('#imagenName').val())
			}
			if(e.target.files[0] != undefined){
				addImage(e); 
				$('#fileImagen').attr('isTrue','1');
			}else{
				$('#fileImagen').attr('isTrue','0');
			}
		});

		function addImage(e){
			var file = e.target.files[0],
			imageType = /image.*/;
    
			if (!file.type.match(imageType)){
				$('#imgImagen').attr("src","http://placehold.it/140x140&text=[140x140]");
				document.getElementById('fileImagen').value ='';
				if($('#imagenName').val() != 0){
					$('#imgImagen').attr("src",URL_IMG + "app/user/" + $('#imagenName').val())
				} else {
				$('#labelImage').addClass('error');
				$('#alertImageGuard').empty();
				$('#alertImageGuard').append("Selecione una imagen");
				$('#alertImageGuard').show();
			}
			return;
		}
  
		var reader = new FileReader();
			reader.onload = fileOnload;
			reader.readAsDataURL(file);
		}
  
		function fileOnload(e) {
			var result=e.target.result;
			$('#imgImagen').attr("src",result);
		}
	});
});

//muestra el formulario para eliminar guardias
function showFormDeleteGuard(selector){
	idGuard = $(selector).attr('value');
	$('#divAlertWarningGuard').hide();
	$('#divAlertWarningGuard').toggle(800);
}

function hideFormDeleteGuard(){
	$('#divAlertWarningGuard').toggle(800);
	idGuard = 0;
}

function deleteGuard(){
	$.ajax({
		type: "POST",
		url: "guard/deleteGuard",
		dataType:'json',
		data: {
			id:idGuard
		},
		success: function(data){
			hideFormDeleteGuard();
			$('#alertGuard').html(data);
			$('#divAlertGuard').show(1000).delay(1500);
			$('#divAlertGuard').hide(1000);
			getGuardSearch();
		},
		error: function(data){
			alert('error. Intentelo mas tarde');
			hideFormDeleteGuard();
		}
	});
}

/////////////////////////////////////////////////////

/*********************************/
/************Paginador************/
/*********************************/

$(document).ready(function() { paginadorActive(); });

function paginadorActive(){    
	$("#demo1").paginate({
		count: totalPaginadorG,
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
			paginadorGuard(page);
		}
	});
	$('.jPag-first').html('Primero');
	$('.jPag-last').html('Ultimo');
}

function paginadorGuard(num){
	
	var cantidad = (num-1) *10;
	
	$.ajax({
		type: "POST",
		url: "guard/getGuardPaginador",
		dataType:'json',
		data: {
			num:cantidad,
			dato:$('#textSeachGuard').val().trim()
		},
		success: function(data){
			$('#tableGuard tbody').empty();
			for(var i = 0;i<data.items.length; i++){
				var item = data.items[i];
				$('#tableGuard tbody').append(
					'<tr>' +
						'<td>' + (i + 1) + '</td>' +
						'<td><a  class="editGuard" value="' + item.id  + '">' + item.nombre + " " + item.apellidos + '</a></td>' +
						'<td><a class="imageDeleteMessage" value="' + item.id + '"><img id="imgDelete" class="imgDeleteItem" src="assets/img/web/delete.png"/></a></td>' +
					'</tr>'
				);
			}
		},
		error: function(data){
			alert('Error, intentelo mas tarde');
		}
	});
	
}
