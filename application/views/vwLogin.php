<!doctype html>
<html class="no-js" lang="en">
    <head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
        
        <title>Booking</title>
        <link href='http://fonts.googleapis.com/css?family=Chivo' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url().FOUND; ?>css/foundation.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login.css" />
		
    </head>
    <body>      
        
        <div class="row login-content">
  			<div id="login-left" class="small-4 medium-6 large-8 columns">
                <img src="../../assets/img/web/bg-chavo.png" style="padding-left: 170px;">
            </div>
  			<div class="small-8 medium-6 large-4 columns" id="bgFormLogin" >
            	<div id="headerFormLogin" class="small-12 medium-12 large-12 columns">
					<div id="imgLogoLogin">
						<img src="assets/img/web/logoPlantec2.png">
					</div>
				</div>
                    
                    <div class="row" id="bodyFormLogin">
                    	<div class="small-12 medium-12 large-12 columns">
						
							<div class="row">
                        		<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                        			<div class="small-10 medium-10 large-10 columns">
                            			<small id="alertLogin" class="alert-box alert">
                                        
                                		</small>
                           			</div>
                            	<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                       		</div>
							
                            <div class="row espacio">&nbsp;</div>
                            <div class="row separador">&nbsp;</div>
                            
							<div class="row collapse" id="row-textfield-login">
								<div class="small-2 large-2 columns">
									<span class="prefix" class="bodyIconFormLogin"><img src="assets/img/web/icono-user.png" class="iconFormLogin"></span>
								</div>
								<div class="small-10 large-10 columns">
									<input type="text"  id="txtEmail" placeholder="Correo del administrador">
								</div>
							</div>
                            <div class="row">&nbsp;</div>
							<div class="row collapse" id="row-textfield-login">
								<div class="small-2 large-2 columns">
									<span class="prefix" class="bodyIconFormLogin"><img src="assets/img/web/icono-password.png" class="iconFormLogin"></span>
								</div>
								<div class="small-10 large-10 columns">
									<input type="password"  id="txtPassword" placeholder="Contraseña del administrador">
								</div>
							</div>
							
                            <div class="row espacio">&nbsp;</div>
                            <div class="row separador">&nbsp;</div>
                            
							<div class="row">
                        			<div class="small-12 medium-12 large-12 columns" style="text-align:center;">
                            			<a id="btnlogin" class="button">INGRESAR</a>
                           			</div>
                       		</div>
                        
                        </div>
                    </div>
					<!--<div id="footerFormLogin" class="small-12 medium-12 large-12 row"></div>-->

                
            </div>
		</div>
		<div class="row login-bottom">
            <div class="small-2 medium-2 large-2 columns">&nbsp;</div>
            <div class="small-8 medium-8 large-8 columns body-bottom">
                &iquest;TE INTERESA ESTE SERVICIO&#63; &iexcl;COMUNICATE CON NOSOTROS&#33;
            </div>
            <div class="small-2 medium-2 large-2 columns">&nbsp;</div>
        </div>
	</body>
		
	<script>
		var URL_BASE = '<?php echo base_url(); ?>';
	</script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url().FOUND; ?>js/foundation.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/login.js"></script>
</html>