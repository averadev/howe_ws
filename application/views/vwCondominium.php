<?php
$this->load->view('vwHeader');
?>

	<section>
		<div class="row" ></div>
		<div class="row" id="section" >
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-8 columns">
				
				<div class="row collapse" style="margin: 16px 0 0 0;">
					<div class="small-9 columns">
						<input type="text" placeholder="Nombre" id="textSeachCondo" style="width: 94%;margin-top: 4px;">
					</div>
					<div class="small-3 columns">
						<a class="button small radius" id="btnSeachCondo">Buscar</a>
					</div>
				</div>
				
			</div>
			
			<div class="small-12 medium-12 large-2 columns">&nbsp;</div>
			
		</div>
		<div class="row" id="section" style="margin-top:0;" >
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-10 columns">
				
				<div class="small-12 large-12 alerWarning" id="divAlertWarningCondominium" style="display:none" >
					<div data-alert class="alert-box warning" id="alertMessagewarning">
						<div id="textDeleteCondominium">¿Desea eliminar el condominio?</div>
						<button class ="btnWarning" id="btnCancelDeleteCondominium">cancelar</button>
						<button class="btnWarning" id="btnAcceptDeleteCondominium">aceptar</button>
			
					</div>
				</div>
				
				<div class="small-12 large-12 alerWarning" id="divAlertCondominium" style="display:none" >
					<div data-alert class="alert-box success radius"id="alertCondominium" >
					</div>
				</div>
				
				<div class="rectRounded2 rectRoundedLeft">
					
					<table id="tableCondominium" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="6" class="titleTabla">
                                	CONDOMINIOS REGISTRADOS
									<a id="btnAddCondo" class="button alert tiny btnAddItem">&nbsp;&nbsp;&nbsp;&nbsp;Nuevo&nbsp;&nbsp;</a>
                                </td>
                           	</tr>
    						<tr>
                            	<th width="15%">#</th>
								<th width="15%" >Nombre</th>
								<th width="50%" >Residentes</th>
								<th width="10%" >Añadir Residentes</th>
								<th width="10%">Eliminar</th>
    						</tr>
  						</thead>
						<tbody>
							<?php 
                            $con = 0;
                            foreach ($condominium as $item):
								$con++;
								?>
									<tr>
										<td ><?php echo $con;?></td>
										<td >
											<a  class="editCondominium" value="<?php echo $item->id;?>"><?php echo $item->nombre;?></a>
										</td>
										<td><?php echo $item->residente;?></td>
										<td ><a class="btnAddUserCondo" value="<?php echo $item->id;?>"><img id="imgAddUser" class="imgAddUser" src="assets/img/web/user-add.png"/></a></td>
										<td ><a class="btnDeleteCondo" value="<?php echo $item->id;?>"><img id="imgDelete" class="imgDeleteItem" src="assets/img/web/delete.png"/></a></td>
									</tr>

							<?php endforeach;?>
							<?php 
								if($totalM == 0){ $totalM = 1;}
								$totalPaginadorM = intval($totalM/10);
								if($totalM%10 == 0){
									$totalPaginadorM = $totalPaginadorM - 1;		
								}
								$totalPaginadorM = $totalPaginadorM + 1
								
							?>
							<script>
								var totalPaginadorM = "<?php echo $totalPaginadorM; ?>" ;
							</script>
						</tbody>
					</table>
				</div>
				
				<div class="small-12 medium-12 large-12 columns" >
					<form id="form1" runat="server">
						<div class="content">
							<div id="paginationdemo" class="demo">
								<div id="demo1">
								</div>
							</div>
						</div>
					</form>
				</div>
				
			</div>
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
		</div>
		
	</section>
	
	<!--------- modal ----------->
	<div id="dialog-formCondominium" title="Condominio">
		<div class="row" style="margin-top:30px;">
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-10 columns">
			
				<div data-alert id="messageAlertModal" class="alert-box alert radius">
					Campo vacio. Por favor escriba un condominio
				</div>
				
				<!-- input asunto-->
				<div class="row">
					<div class="large-12 columns">
						<label>
							<input type="text" id="txtNameCondominio" placeholder="Nombre" class="radius" />
						</label>
					</div>
				</div>
				
			</div>
					
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
		</div>
		<div class="bodyLoandingSend"></div>
		
		<input type="hidden" value="0" id="idCondominiumTemp" />
		
	</div>
	<!------ fin modal -------->
	
	<!--------- modal ----------->
	<div id="dialog-formResidentes" title="Residentes">
		<div class="row" style="margin-top:30px;">
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-10 columns" id="divTable" style="display:none">
			
				<div class="small-12 large-12 alerWarning" id="divAlertWarningResident" style="display:none" >
					<div data-alert class="alert-box warning" id="alertMessagewarning">
						¿Desea eliminar al residente?
						<button class ="btnWarning" id="btnCancelDeleteResident">cancelar</button>
						<button class="btnWarning" id="btnAcceptDeleteResident">aceptar</button>
			
					</div>
				</div>
				
				<div class="small-12 large-12 alerWarning" id="divAlertResident" style="display:none" >
					<div data-alert class="alert-box success radius"id="alertResident" >
					</div>
				</div>
			
				<table id="tableResident" width="100%">
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
			
			<div class="small-12 medium-12 large-10 columns" id="divFormResident" style="display:none">
				
				<!--primera columna-->
				<div class="small-12 medium-12 large-6 columns" >
					
					<div class="row">
						<div class="large-12 columns">
							<label id="labelNameResident">Nombre
								<input type="text" class="error" id="textNameResident"  />
							</label>
							<small id="alertNameResident" class="error" style="display:none;">Campo vacio. Por favor ingrese el nombre del residente</small>
						</div>
					</div>
					</br>
					<div class="row">
						<div class="large-12 columns">
							<label id="labelLastNameResident">Apellidos
								<input type="text" class="error" id="textLastNameResident" />
							</label>
							<small id="alertLastNameResident" class="error" style="display:none;">Campo vacio. Por favor ingrese los apellidos del residente</small>
						</div>
					</div>
					</br>
					<div class="row">
						<div class="large-12 columns">
							<label id="labelPhoneResident">Telefono
								<input type="text" class="error" id="textPhoneResident"  />
							</label>
							<small id="alertPhoneResident" class="error" style="display:none;">Campo vacio. Por favor ingrese el telefono del residente</small>
						</div>
					</div>
					
				</div>
				<!--fin primera columna-->
				
				<!--segunda columna-->
				<div class="small-12 medium-12 large-6 columns" >
										
					<div class="row">
						<div class="large-12 columns">
							<label id="labelEmailResident">Correo
								<input type="text" class="error" id="textEmailResident" />
							</label>
							<small id="alertEmailResident" class="error" style="display:none;">Campo vacio. Por favor ingrese el correo del residente</small>
						</div>
					</div>
					
					</br>
					<div class="row">
						<div class="large-12 columns">
							<label id="labelPassResident">Contraseña
								<input type="text" class="error" id="textPassResident" />
							</label>
							<small id="alertPassResident" class="error" style="display:none;">Campo vacio. Por favor ingrese la contraseña del residente</small>
						</div>
					</div>
					
				</div>
				<!--fin segunda columna-->
				
			</div>
			
			<div class="small-12 medium-12 large-10 columns" id="divAssign" style="display:none">	
			
				<table id="tableAssignResident" width="100%">
					<thead>
						<tr>
							<td colspan="6" class="titleTabla">
								Residentes
							</td>
						</tr>
						<tr>
							<th width="15%">#</th>
							<th width="30%">Nombre</th>
							<th width="45%">Email</th>
							<th width="10%">Asignar</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				
				<table id="tableAssignResidentId" style="display:none">
					<thead>
						<tr>
							<th width="15%">id</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
				
			</div>
					
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
		</div>
		<div class="bodyLoandingSend"></div>
		
		<input type="hidden" value="0" id="idCondominiumTemp" />
		
	</div>
	<!------ fin modal -------->

<?php
$this->load->view('vwFooter');
?>

<style>
	
	.ui-dialog-titlebar-close {
		visibility: hidden;
	}
	
</style>



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>/condominium.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>-->