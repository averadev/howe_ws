

$('#imgMenuMovil').click(function(e){
	alert(screen.width)
	if(screen.width <= 640){
		$('#nemuOptions').toggle();
	//contMenuDespegable = 1;
		e.stopPropagation();
	}
});

$('html').click(function() {
    /* Aqui se esconden los menus que esten visibles*/
	if(screen.width <= 640){
		$('#nemuOptions').hide();
	}
	//if(window.width)
	//
});