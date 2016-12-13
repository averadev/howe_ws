<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
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
	
	
	
	<header>
		<nav>
			<div id="navLogout">
				<div id="contNavLogout">
				<a href="<?php echo base_url(); ?>login/logout" >
					<div id="contBtnLogOut">
						<img id="btnLogOut" src="assets/img/web/loginGuardias-iconoSalir.png">
						<div id="labelLogOut">Salir</div>
					</div>
				</a>
				</div>
			</div>
			<div id="navMenu">
				<div id="labelMenuMovil" >Menu</div>
				<img id="imgMenuMovil" src="assets/img/web/optionCondo.png">
				<ul>
					<a href="<?php echo base_url(); ?>dashboard"><li id="imgLogo">
						<div class="imgIconHeader">
							<img src="assets/img/web/logo.png">
						</div>
					</li></a>
					<a href="<?php echo base_url(); ?>dashboard"><li <?php echo  $pg =='dashboard' ? 'class="active"' : '' ?>>
						<div class="imgIconHeader" id="iconHome">
							<img src="assets/img/web/iconHome.png" >
						</div>
						<p>Inicio</p>
					</li></a>
					<a href="<?php echo base_url(); ?>message"><li <?php echo  $pg =='message' ? 'class="active"' : '' ?>>
						<div class="imgIconHeader" id="iconMessageHeader">
							<img src="assets/img/web/iconMessage.png">
						</div>
						<p>Mensajes</p>
					</li></a>
					<a href="<?php echo base_url(); ?>send"><li <?php echo  $pg =='send' ? 'class="active"' : '' ?>>
						<div class="imgIconHeader" id="iconSendHeader">
							<img src="assets/img/web/iconSend.png">
						</div>
						<p>Avisos</p>
					</li></a>
					<a href="<?php echo base_url(); ?>condominium" ><li <?php echo  $pg =='condominium' ? 'class="active"' : '' ?>>
						<div  class="imgIconHeader" id="iconCondoHeader">
							<img src="assets/img/web/iconCondo.png">
						</div>
						<p>Condos</p>
					</li></a>
					<a href="<?php echo base_url(); ?>guard" ><li id="lastLiMenu" <?php echo  $pg =='guard' ? 'class="active"' : '' ?>>
						<div class="imgIconHeader" id="iconGuardHeader">
							<img src="assets/img/web/iconGuard.png">
						</div>
						<p>Guardias</p>
					</li></a>
				</ul>
				
			</div>
		</nav>
	</header>
    

