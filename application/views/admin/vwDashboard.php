<?php
$this->load->view('admin/vwHeader');
?>
	<div id="wrapper">
		<section >
			<div class="row" id="sectionUp"  ></div>
			<div class="row" id="section" >
				<div class="small-12 medium-2 large-1 columns">&nbsp;</div>
				
				<div class="small-12 medium-8 large-10 columns">
				
					<div class="small-12 large-12 alerWarning" id="divAlertWarningResidential" style="display:none" >
						<div data-alert class="alert-box warning" id="alertMessagewarning">
							<div id="textDeleteCondominium">¿Desea eliminar el residencial?</div>
							<button class ="btnWarning" id="btnCancelDeleteResidential">Cancelar</button>
							<button class="btnWarning" id="btnAcceptDeleteResidential">Aceptar</button>
						</div>
					</div>
				
					<div class="small-12 large-12 alerWarning" id="divAlertResidential" style="display:none" >
						<div data-alert class="alert-box success radius"id="alertResidential" >
						</div>
					</div>
				
					<div class="rectRounded rectRoundedLeft">
					
						<table width="100%" class="tableReport" id="tableResidencial">
							<thead>
								<tr>
									<td colspan="6" class="titleTabla">
										Clientes registrados
										<a id="btnAddResidencial" class="button alert tiny btnAddItem">&nbsp;&nbsp;&nbsp;&nbsp;Nuevo&nbsp;&nbsp;</a>
									</td>
								</tr>
								<tr>
									<th width="10%" >#</th>
									<th width="25%" >Nombre</th>
									<th width="25%" >Contacto</th>
									<th width="10%" >#Usuarios</th>
									<th width="15%" >#Añadir usuarios</th>
									<th width="15%" >Eliminar</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$con = 0;
								foreach ($residencial as $item):
									$con++;
									?>
									<tr>
										<td><?php echo $con;?></td>
										<td>
											<a  class="editResidencial" value="<?php echo $item->id;?>"><?php echo $item->nombre ;?></a>
										</td>
										<td><?php echo $item->nombreContacto;?></td>
										<td><?php echo $item->totalUsuarios;?></td>
										<td ><a class="btnAddUserResidencial" value="<?php echo $item->id;?>"><img id="imgAddUser" class="imgAddUser" src="<?php echo base_url(); ?>assets/img/web/user-add.png"/></a></td>
										<td ><a class="btnDeleteResidencial" value="<?php echo $item->id;?>"><img id="imgDelete" class="imgDeleteItem" src="<?php echo base_url(); ?>assets/img/web/delete.png"/></a></td>
									</tr>

								<?php endforeach;
							if($totalR == 0){ $totalR = 1;}
							$totalPaginadorR = intval($totalR/10);
							if($totalR%10 == 0){
								$totalPaginadorR = $totalPaginadorR - 1;		
							}
							$totalPaginadorR = $totalPaginadorR + 1
                            ?>
							<script>
								var totalPaginadorR = "<?php echo $totalPaginadorR; ?>" ;
							</script>
							</tbody>
						</table>
					
					</div>
				
				
					<div class="small-12 medium-12 large-12 columns" >
				
						<form id="form1" runat="server">
							<div class="content">
								<div id="paginationdemo" class="demo">
									<div id="demo5">
									</div>
								</div>
							</div>
						</form>
				
					</div>
				 
				
				</div>
			
				<div class="small-12 medium-2 large-1 columns">&nbsp;</div>
			</div>
		
		</section>
	
		<!--------- modal ----------->
		<div id="dialog-Residencial" title="Residencial">
			<div class="row" style="margin-top:30px;">
				<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
				
				<div class="small-12 medium-12 large-10 columns" >
				
					<div class="small-12 medium-12 large-12 columns" style="margin-bottom:15px;">
						<input id="checkbox1" type="checkbox"><label for="checkbox1">Requiere Foto</label>
					</div>
				
					<!--primera columna-->
					<div class="small-12 medium-12 large-6 columns" >
					
						<div class="row">
							<div class="large-12 columns">
								<label id="labelNameResidential">Nombre
									<input type="text" class="error" id="textNameResidential"  />
								</label>
								<small id="alertNameResidential" class="error" style="display:none;">Campo vacio. Por favor ingrese el nombre de la residencia</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelTelAdminResident">Telefono Administracion
									<input type="text" class="error" id="textTelAdminResident" />
								</label>
								<small id="alertTelAdminResident" class="error" style="display:none;">Campo vacio. Por favor ingrese el telefono de la administracion</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelTelCaseta">Telefono Caseta
									<input type="text" class="error" id="textTelCaseta"  />
								</label>
								<small id="alertTelCaseta" class="error" style="display:none;">Campo vacio. Por favor ingrese el telefono de la caseta</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelTelLobby">Telefono Lobby
									<input type="text" class="error" id="textTelLobby"  />
								</label>
								<small id="alertTelLobby" class="error" style="display:none;">Campo vacio. Por favor ingrese el telefono del lobby</small>
							</div>
						</div>
						
					</div>
					<!--fin primera columna-->
				
					<!--segunda columna-->
					<div class="small-12 medium-12 large-6 columns" >
				
						<div class="row">
							<div class="large-12 columns">
								<label id="labelCityResidential">Ciudad
									<input type="text" class="error" id="textCityResidential" list="cityList" autocomplete="on" />
									<datalist id="cityList"></datalist>
								</label>
								<small id="alertCityResidential" class="error" style="display:none;">Campo vacio. Por favor ingrese una ciudad valida</small>
							</div>
						</div>
						</br>
				
						<div class="row">
							<div class="large-12 columns">
								<label id="labelNameContactResidential">Nombre del contacto
									<input type="text" class="error" id="textlNameContactResidential" />
								</label>
								<small id="alertlNameContactResidential" class="error" style="display:none;">Campo vacio. Por favor ingrese el nombre del contacto</small>
							</div>
						</div>
						</br>					
						<div class="row">
							<div class="large-12 columns">
								<label id="labelEmailContactResidential">Correo del contacto
									<input type="text" class="error" id="textEmailContactResidential" />
								</label>
								<small id="alertEmailContactResidential" class="error" style="display:none;">Campo vacio. Por favor ingrese el correo del contacto</small>
							</div>
						</div>
					
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelTelContactResidential">Telefono del contacto
									<input type="text" class="error" id="textTelContactResidential" />
								</label>
								<small id="alertTelContactResidential" class="error" style="display:none;">Campo vacio. Por favor ingrese el telefono del contacto</small>
							</div>
						</div>
					
					</div>
					<!--fin segunda columna-->
				
				</div>
					
				<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			</div>
			<div class="small-12 medium-12 large-12 columns" style="margin-top:10px;">
				<div class="bodyLoandingSend" style="margin-top:10px;"></div>
			</div>
		</div>
		<!------ fin modal -------->
		
		<!--------- modal ----------->
		<div id="dialog-formUser" title="Usuarios">
			<div class="row" style="margin-top:30px;">
				<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
				<div class="small-12 medium-12 large-10 columns" id="divTableUser" style="display:none">
			
					<div class="small-12 large-12 alerWarning" id="divAlertWarningUser" style="display:none" >
						<div data-alert class="alert-box warning" id="alertMessagewarning">
							¿Desea eliminar el administrador?
							<button class ="btnWarning" id="btnCancelDeleteUser">cancelar</button>
							<button class="btnWarning" id="btnAcceptDeleteUser">aceptar</button>
				
						</div>
					</div>
					
					<div class="small-12 large-12 alerWarning" id="divAlertUser" style="display:none" >
						<div data-alert class="alert-box success radius"id="alertUser" >
						</div>
					</div>
			
					<table id="tableUser" width="100%">
						<thead>
							<tr>
								<td colspan="6" class="titleTabla">
									Residentes
								</td>
							</tr>
							<tr>
								<th width="15%">#</th>
								<th width="35%">Nombre</th>
								<th width="40%">Email</th>
								<th width="10%">Eliminar</th>
							</tr>
						</thead>
						<tbody>
						
						</tbody>
					</table>
				
				</div>
			
				<div class="small-12 medium-12 large-10 columns" id="divFormUser" style="display:none">
				
					<!--primera columna-->
					<div class="small-12 medium-12 large-6 columns" >
						
						<div class="row">
							<div class="large-12 columns">
								<label id="labelNameUser">Nombre
									<input type="text" class="error" id="textNameUser"  />
								</label>
								<small id="alertNameUser" class="error" style="display:none;">Campo vacio. Por favor ingrese el nombre del usuario</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelLastNameUser">Apellidos
									<input type="text" class="error" id="textLastNameUser" />
								</label>
								<small id="alertLastNameUser" class="error" style="display:none;">Campo vacio. Por favor ingrese los apellidos del usuario</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelPhoneUser">Telefono
									<input type="text" class="error" id="textPhoneUser"  />
								</label>
								<small id="alertPhoneUser" class="error" style="display:none;">Campo vacio. Por favor ingrese el telefono del usuario</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelAddressUser">Direccion
									<input type="text" class="error" id="textAddressUser"  />
								</label>
								<small id="alertAddressUser" class="error" style="display:none;">Campo vacio. Por favor ingrese la direccion del usuario</small>
							</div>
						</div>
					
					</div>
					<!--fin primera columna-->
				
					<!--segunda columna-->
					<div class="small-12 medium-12 large-6 columns" >
					
						<div class="row">
							<div class="large-12 columns">
								<label id="labelStateUser">Estado
									<input type="text" class="error" id="textStateUser" />
								</label>
								<small id="alertStateUser" class="error" style="display:none;">Campo vacio. Por favor ingrese el estado del usuario</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelCityUser">Ciudad
									<input type="text" class="error" id="textCityUser" />
								</label>
								<small id="alertCityUser" class="error" style="display:none;">Campo vacio. Por favor ingrese la ciudad del usuario</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelEmailUser">Correo
									<input type="email" class="error" id="textEmailUser" />
								</label>
								<small id="alertEmailUser" class="error" style="display:none;">Campo vacio. Por favor ingrese el correo del usuario</small>
							</div>
						</div>
						</br>
						<div class="row">
							<div class="large-12 columns">
								<label id="labelPassUser">Contraseña
									<input type="password" class="error" id="textPassUser" />
								</label>
								<small id="alertPassUser" class="error" style="display:none;">Campo vacio. Por favor ingrese la contraseña del usuario</small>
							</div>
						</div>
					
					</div>
					<!--fin segunda columna-->
				
				</div>
					
				<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			</div>
			<div class="bodyLoandingSend"></div>
		
			<input type="hidden" value="0" id="idCondominiumTemp" />
		
		</div>
		<!------ fin modal -------->
	
	</div>
	
	


<?php
$this->load->view('vwFooter');
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>/admin/dashboard.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>/paginadorYBuscador.js"></script>