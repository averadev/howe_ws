<?php
$this->load->view('vwHeader');
?>

	<section>
		<div class="row" ></div>
		<div class="row" id="section" >
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-10 columns">
				
				<div class="row collapse">
					<div class="small-8 medium-10 large-10 columns">
						<input type="text" placeholder="Nombre y/o apellidos" id="textSeachGuard">
					</div>
					<div class="small-4 medium-2 large-2 columns">
						<a class="button postfix" id="btnSeachGuard">Buscar</a>
					</div>
				</div>
				
			</div>
			
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			
		</div>
		<div class="row" id="section" style="margin-top:0; padding-top:0;" >
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			
			<div class="small-12 medium-12 large-10 columns">
			
				<div class="small-12 large-12 alerWarning" id="divAlertWarningGuard" style="display:none" >
					<div data-alert class="alert-box warning" id="alertMessagewarning">
						¿Desea eliminar al guardia?
						<button class ="btnWarning" id="btnCancelDeleteGuard">cancelar</button>
						<button class="btnWarning" id="btnAcceptDeleteGuard">aceptar</button>
					</div>
				</div>
				
				<div class="small-12 large-12 alerWarning" id="divAlertGuard" style="display:none" >
					<div data-alert class="alert-box success radius"id="alertGuard" >
					</div>
				</div>
				
				<div class="rectRounded2 rectRoundedLeft">
					
					<table id="tableGuard" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="6" class="titleTabla">
                                	lista de guardias
									<a id="btnAddGuard" class="button alert tiny btnAddItem">&nbsp;&nbsp;&nbsp;&nbsp;Nuevo&nbsp;&nbsp;</a>
                                </td>
                           	</tr>
    						<tr>
                            	<th width="20%" >#</th>
								<th width="60%" >Nombre</th>
								<th width="20%" >Eliminar</th>
    						</tr>
  						</thead>
						<tbody>
							<?php 
                            $con = 0;
                            foreach ($guard as $item):
								$con++;
								?>
									<tr>
										<td><?php echo $con;?></td>
										<td>
											<a  class="editGuard" value="<?php echo $item->id;?>"><?php echo $item->nombre . " " . $item->apellidos ;?></a>
										</td>
										<td><a class="imageDeleteMessage" value="<?php echo $item->id;?>"><img id="imgDelete" class="imgDeleteItem" src="assets/img/web/delete.png"/></a></td>
									</tr>

							<?php endforeach;
							if($totalG == 0){ $totalG = 1;}
							$totalPaginadorG = intval($totalG/10);
							if($totalG%10 == 0){
								$totalPaginadorG = $totalPaginadorG - 1;		
							}
							$totalPaginadorG = $totalPaginadorG + 1
                            ?>
							<script>
								var totalPaginadorG = "<?php echo $totalPaginadorG; ?>" ;
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
	<div id="dialog-formGuard" title="Condominio">
		<div class="row" style="margin-top:30px;">
			<!------primera columna------->
			<div class="small-12 medium-12 large-6 columns">
			
				<div class="row">
					<div class="large-6 columns">
						<label id="labelNameGuard">Nombre
							<input type="text" class="error" id="textNameGuard"  />
						</label>
						<small id="alertNameGuard" class="error" style="display:none;">Campo vacio. Por favor ingrese el nombre del guardia</small>
					</div>
					<div class="large-6 columns">
						<label id="labelLastNameGuard">Apellidos
							<input type="text" class="error" id="textLastNameGuard" />
						</label>
						<small id="alertLastNameGuard" class="error" style="display:none;">Campo vacio. Por favor ingrese los apellidos del guardia</small>
					</div>
				</div>
				</br>
				<div class="row">
					<div class="large-6 columns">
						<label id="labelPhoneGuard">Telefono
							<input type="text" class="error" id="textPhoneGuard" />
						</label>
						<small id="alertPhoneGuard" class="error" style="display:none;">Campo vacio. Por favor ingrese el Telefono del guardia</small>
					</div>
					<div class="large-6 columns">
						<label id="labelAddressGuard">Direccion
							<input type="text" class="error" id="textAddressGuard" />
						</label>
						<small id="alertAddressGuard" class="error" style="display:none;">Campo vacio. Por favor ingrese la direccion del guardia</small>
					</div>
				</div>
				</br>
				<div class="row">
					<div class="large-6 columns">
						<label id="labelCityGuard">Ciudad
							<input type="text" class="error" id="textCityGuard" />
						</label>
						<small id="alertCityGuard" class="error" style="display:none;">Campo vacio. Por favor ingrese la ciudad del guardia</small>
					</div>
					<div class="large-6 columns">
						<label id="labelStateGuard">Estado
							<input type="text" class="error" id="textStateGuard" />
						</label>
						<small id="alertStateGuard" class="error" style="display:none;">Campo vacio. Por favor ingrese el estado del guardia</small>
					</div>
				</div>
				</br>
				
			</div>
			<!------fin primera columna------->
			
			<!------segunda columna------->
			<div class="small-12 medium-12 large-6 columns">
			
				<div class="row">
					<div class="small-12 medium-8 large-8 columns" id="imagen">
						<label id="labelImage"><strong>*Imagen</strong> </label>
						<img style="height:128px;width:128px;" id="imgImagen" class="newImageAdd" 
								src="http://placehold.it/140x140&text=[140x140]"/>
						<input type="hidden" id="imagenName" value="0" />
						<input style="display:none" type="file" id="fileImagen" isTrue="0" />
						<small id="alertImageGuard" class="error" style="display:none"></small>
					</div>
				</div>
                            
				<br/><br/>
			
				<div class="row">
					<div class="large-6 columns">
						<label id="labelEmailGuard" >Correo
							<input type="text" class="error" id="textEmailGuard" />
						</label>
						<small id="alertEmailGuard" class="error" style="display:none;">Campo vacio. Por favor ingrese el correo del guardia</small>
					</div>
					<div class="large-6 columns">
						<label id="labelPassGuard" >Contraseña
							<input type="text" class="error" id="textPassGuard" />
						</label>
						<small id="alertPassGuard" class="error" style="display:none;">Campo vacio. Por favor ingrese la contraseña del guardia</small>
					</div>
				</div>
			
			</div>
			<!------fin segunda columna------->
					
			<div class="small-12 medium-12 large-6 columns">&nbsp;</div>
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
<script type="text/javascript" src="<?php echo base_url().JS; ?>/guard.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>-->