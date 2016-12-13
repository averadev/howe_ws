<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plantec Security</title>
    <link rel="stylesheet" href="<?php echo base_url().FOUND; ?>css/foundation.css" />
    <link rel="stylesheet" href="<?php echo base_url().CSS; ?>header.css" />
	<link rel="stylesheet" href="<?php echo base_url().CSS; ?>common.css" />
    <link rel="stylesheet" href="<?php echo base_url().CSS; ?>tooltipster.css" />
    <link rel="stylesheet" href="<?php echo base_url().CSS; ?>themes/tooltipster-shadow.css" />
	<link rel="stylesheet" href="<?php echo base_url().CSS; ?>paginacionj/style.css" />

  </head>
<body>
    <?php
    $pg = isset($page) && $page != '' ?  $page :'dashboard'  ;
	
    ?>
	
	<header id="headerAdmin">
		<nav>
			
			<div id="navLogout2">
				<div id="contNavLogout2">
				<a href="<?php echo base_url(); ?>login/logout" id="LogOut2" >
					<div id="contBtnLogOut2">
						<img id="btnLogOut" src="<?php echo base_url(); ?>assets/img/web/loginGuardias-iconoSalir.png">
						<div id="labelLogOut">Salir</div>
					</div>
				</a>
				</div>
			</div>
			
			<div class="row">
				<div class="small-12 medium-1 large-1 columns">&nbsp;</div>
				<div class="small-12 medium-10 large-10 columns" id="menuHeaderAdmin">
					<img src="<?php echo base_url(); ?>assets/img/web/logoPlantec2.png">
					<p>Administración de clientes</p>
				</div>
				<div class="small-12 medium-1 large-1 columns">&nbsp;</div>
			</div>
		</nav>
	</header>
    

