<?php
$this->load->view('vwHeader');
?>

	<section>
		<div class="row" ></div>
		<div class="row" id="section" >
			<div class="small-12 medium-12 large-3 columns">
				<div class="row">
					<div class="large-12 columns">
						<label>Visitantes desde el:
							<input type="date" id="iniDateVisit" class="radius" />
						</label>
					</div>
				</div>
			</div>
			<div class="small-12 medium-12 large-3 columns">
				<div class="row">
					<div class="large-12 columns">
						<label>a el:
							<input type="date" id="endDateVisit" class="radius" />
						</label>
					</div>
				</div>
			</div>
			<div class="small-12 medium-12 large-2 columns">
				<div class="row">
					<div class="large-12 columns">
						</br>
						<a id="btnVisitDate" class="button small radius">Buscar</a>
					</div>
				</div>
			</div>
			<div class="small-12 medium-12 large-4 columns">
				<div class="divFilter">
					<div class="small-12 medium-6 large-4 columns" style="margin-top:10px;">
						
						<input id="checkboxFilter" type="checkbox">Filtrar<label for="checkboxFilter"></label>
					</div>
					<div class="small-12 medium-6 large-8 columns" style=" display:none;margin-top: 6px;" id="FilterCodominium">
						
						<select id="selectCondominium">
							<?php
							foreach ($condominium as $item): ?>
								<option value="<?php echo $item->id; ?>"><?php echo $item->nombre; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			</div>
				
		</div>
		<div class="row" id="section" style="margin-top:0;" >
			<div class="small-12 medium-12 large-12 columns">
				
				<div class="small-12 large-12 alerWarning" id="divAlertWarningCondominium" style="display:none" >
					<div data-alert class="alert-box warning" id="alertMessagewarning">
						<div id="textDeleteCondominium">¿Desea eliminar el mensaje?</div>
						<button class ="btnWarning" id="btnCancelDeleteCondominium">cancelar</button>
						<button class="btnWarning" id="btnAcceptDeleteCondominium">aceptar</button>
			
					</div>
				</div>
				
				<div class="small-12 large-12 alerWarning" id="divAlertCondominium" style="display:none" >
					<div data-alert class="alert-box success radius"id="alertCondominium" >
					</div>
				</div>
				
				<div class="rectRounded2 rectRoundedLeft">
					
					<table id="tableVisit" width="100%">
                    	<thead>
                        	<tr>
                            	<td colspan="8" class="titleTabla">
                                	VISITANTES REGISTRADOS
                                </td>
                           	</tr>
    						<tr>
                            	<th width="5%">#</th>
								<th width="5%" >Condominio</th>
								<th width="20%" >Fecha</th>
								<th width="30%" >Asunto</th>
								<th width="30%">Visitante</th>
								<th width="5%">Proveedor</th>
								<th width="5%">Ver&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
    						</tr>
  						</thead>
						<tbody>
							<?php 
                            $con = 0;
                            foreach ($visit as $item):
								$con++;
								?>
									<tr>
										<td ><?php echo $con;?></td>
										<!--<td >
											<a  class="editCondominium" value="<?php echo $item->id;?>"><?php echo $item->nombre;?></a>
										</td>-->
										<td><?php echo $item->nombreCondominio;?></td>
										<td><?php echo $item->fechaHora;?></td>
										<td><?php echo $item->motivo;?></td>
										<td><?php echo $item->nombreVisitante;?></td>
										<td ><?php if($item->proveedor == 1){?><img class="imgAddUser" src="assets/img/web/tick.png"/><?php } ?></td>
										<td ><a class="btnSeeMore" value="<?php echo $item->id;?>"><img class="imgDeleteItem" src="assets/img/web/eye.png"/></a></td>
									</tr>

							<?php endforeach;
							if($totalV == 0){ $totalV = 1;}
							$totalPaginadorV = intval($totalV/10);
							if($totalV%10 == 0){
								$totalPaginadorV = $totalPaginadorV - 1;		
							}
							$totalPaginadorV = $totalPaginadorV + 1
                            ?>
							<script>
								var totalPaginadorV = "<?php echo $totalPaginadorV; ?>" ;
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
		</div>
		
	</section>
	
	<!--------- modal ----------->
	<div id="dialog-formVisit" title="Residentes">
		<div class="row" style="margin-top:30px;">
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			
			
			<div class="small-12 medium-12 large-10 columns" id="divFormResident">
				
				<div class="small-12 medium-12 large-12 columns" >
					<div class="row">
						<div id="dateVisit"></div>
					</div>
					<div class="row">
						<div id="providerVisit"></div>
					</div>
				</div>
				
				<!--primera columna-->
				<div class="small-12 medium-12 large-6 columns" >
					
					<div class="row">
						<div class="large-12 columns">
							<label id="labelGuardVisit">Guardia
								<input type="text" class="error" id="textGuardVisit" disabled />
							</label>
							<small id="alertGuardVisit" class="error" style="display:none;">Campo vacio. Por favor ingrese el nombre del residente</small>
						</div>
					</div>
					</br>
					<div class="row">
						<div class="large-12 columns">
							<label id="labelLastNameVisit">Visitante
								<input type="text" class="error" id="textNameVisit" disabled />
							</label>
							<small id="alertNameVisit" class="error" style="display:none;">Campo vacio. Por favor ingrese los apellidos del residente</small>
						</div>
					</div>
					</br>
					<div class="row">
						<div class="large-12 columns">
							<label id="labelReasonVisit">Motivos
								<textarea placeholder="small-12.columns" id="textReasonVisit" disabled></textarea>
							</label>
							<small id="alertReasonVisit" class="error" style="display:none;">Campo vacio. Por favor ingrese el telefono del residente</small>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<label id="labelCondominiumVisit">Condominio
								<input type="text" class="error" id="textCondominiumVisit" disabled />
							</label>
							<small id="alertCondominiumVisit" class="error" style="display:none;">Campo vacio. Por favor ingrese el telefono del residente</small>
						</div>
					</div>
					
				</div>
				<!--fin primera columna-->
				
				<!--segunda columna-->
				<div class="small-12 medium-12 large-6 columns" >
					
					<div class="row" style="margin-top:10px;">
						<div class="small-12 medium-12 large-12 columns" id="imagen">
							<label id="labelImage"><strong>Imagen frente</strong> </label>
							<img id="imgFrenteVisit" src="http://placehold.it/300x150&text=[100x100]" class="imgPicture" />
							<small id="alertPhoneResident" class="error" style="display:none;"></small>
						</div>
					</div>
					
					<div class="row" style="margin-top:10px;">
						<div class="small-12 medium-12 large-12 columns" id="imagen">
							<label id="labelImage"><strong>Imagen atras</strong> </label>
							<img id="imgAtrasVisit" src="http://placehold.it/300x150&text=[100x100]" class="imgPicture" />
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
<script type="text/javascript" src="<?php echo base_url().JS; ?>/visit.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>-->