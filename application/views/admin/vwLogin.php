
<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <title>Booking</title>
        <link href='http://fonts.googleapis.com/css?family=Chivo' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="<?php echo base_url().FOUND; ?>css/foundation.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/login-admin.css" />
		
    </head>
    <body id="bodyAdmin">      
        
        <div class="row">
  			<div class="small-1 medium-3 large-3 columns">&nbsp;</div>
            <!--<div class="small-10 medium-6 large-6 columns">
            	<img src="assets/img/web/logo.png" />
            </div>-->
  			<div class="small-10 medium-6 large-6 columns" id="bgFormLogin2" >
            	<div id="headerFormLogin" class="small-12 medium-12 large-12 columns">
					<div id="imgLogoLogin">
						<img src="<?php echo base_url(); ?>assets/img/web/logoPlantec2.png">
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
							
							<div class="row collapse">
								<div class="small-1 medium-1 large-2 columns">&nbsp;</div>
								<div class="small-2 large-1 columns">
									<span class="prefix" class="bodyIconFormLogin"><img src="<?php echo base_url(); ?>assets/img/web/icono-user.png" class="iconFormLogin"></span>
								</div>
								<div class="small-8 large-7 columns">
									<input type="text" id="txtEmail" placeholder="Correo del administrador">
								</div>
								<div class="small-1 medium-1 large-2 columns">&nbsp;</div>
							</div>
							
							<div class="row collapse">
								<div class="small-1 medium-1 large-2 columns">&nbsp;</div>
								<div class="small-2 large-1 columns">
									<span class="prefix" class="bodyIconFormLogin"><img src="<?php echo base_url(); ?>assets/img/web/icono-password.png" class="iconFormLogin"></span>
								</div>
								<div class="small-8 large-7 columns">
									<input type="password" id="txtPassword" placeholder="Contraseña del administrador">
								</div>
								<div class="small-1 medium-1 large-2 columns">&nbsp;</div>
							</div>
							
							<div class="row">
                        		<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                        			<div class="small-10 medium-10 large-10 columns" style="text-align:center;">
                            			<a id="btnlogin" class="button">Ingresar</a>
                           			</div>
                            	<div class="small-1 medium-1 large-1 columns">&nbsp;</div>
                       		</div>
                        
                        </div>
                    </div>
					<!--<div id="footerFormLogin" class="small-12 medium-12 large-12 columns"></div>-->

                
            </div>
  			<div class="small-1 medium-3 large-3 columns">&nbsp;</div>
		</div>
		
	</body>
		
	<script>
		var URL_BASE = '<?php echo base_url(); ?>';
	</script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url().FOUND; ?>js/foundation.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/admin/login.js"></script>
</html>