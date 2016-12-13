<?php
$this->load->view('vwHeader');
?>

	<section>
		<div class="row" ></div>
		<div class="row" id="section" >
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-3 columns">
				<div class="row">
					<div class="large-12 columns">
						<label>Enviado desde el:
							<input type="date" id="iniDateMsg" class="radius" />
						</label>
					</div>
				</div>
			</div>
			<div class="small-12 medium-12 large-3 columns">
				<div class="row">
					<div class="large-12 columns">
						<label>y el:
							<input type="date" id="endDateMsg" class="radius" />
						</label>
					</div>
				</div>
			</div>
			<div class="small-12 medium-12 large-3 columns">
				<div class="row">
					<div class="large-12 columns">
						</br>
						<a id="btnMessageDate" class="button small radius">Buscar</a>
					</div>
				</div>
				
			</div>
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			
		</div>
		<!--<div class="row" >
			<div class="small-12 medium-12 large-2 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-8 columns"  >
				<a id="btmAddMsgAdmin" class="button alert tiny">+&nbsp;&nbsp;&nbsp;&nbsp;Nuevo&nbsp;&nbsp;</a>
			</div>
			<div class="small-12 medium-12 large-2 columns">&nbsp;</div>
		</div>-->
		<div class="row" id="section" style="margin-top:5px;" >
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-5 columns">
				
				<div class="rectRounded rectRoundedLeft">
				
					<table width="100%" class="tableReport" id="tableSend">
						<thead>
							<tr>
								<th>ÚLTIMOS REPORTES
								<a id="btmAddMsgAdmin" class="button alert tiny">&nbsp;&nbsp;&nbsp;&nbsp;Nuevo&nbsp;&nbsp;&nbsp;&nbsp;</a></th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($message as $item):
							?>
								<tr>
									<td>
										<div class="bodyMSGRectRounded" value="<?php echo $item->id; ?>" id="message">
								<div class="labeDateRectRounded"><?php echo $item->dia . ", " . $item->fechaFormat;  ?></div>
								<div class="labeInfoRectRounded"><?php echo $item->asunto; ?></div>
							</div>
									</td>
								</tr>
							<?php endforeach; ?>
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
			<div class="small-12 medium-12 large-5 columns">
				<div class="rectborderless rectRoundedRight">
					<div class="bodyLoanding"></div>
					<div class="row bodyRectborderless" id="bodyRectborderless">
						<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
						<div class="small-12 medium-12 large-10 columns">
						
							<div class="small-12 medium-12 large-12 columns" id="dateMessage2">2015-05-06</div>
							
							<div class="small-12 medium-12 large-12 InfoMSGBold" id="guardMessage" >Enviado por: Juan Gomez C</div>
				
							<div class="small-12 medium-12 large-12 InfoMSG" id="subjectMessage" >Visita de seguridad publica</div>
					
							<div class="small-12 medium-12 large-12 InfoMSG" id="infoMessage" >Llegaron los inspectores de seguridad publica a verificar los señalamientos</div>
					
							
					
						</div>
					
						<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
					</div>
					
				</div>
			</div>
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
		</div>
		
	</section>
	
	<!--------- modal ----------->
	<div id="dialog-MessageAdmin" title="Nuevo mensaje">
		<div class="row" style="margin-top:30px;">
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-10 columns">
			
				<div data-alert id="messageAlertModal" class="alert-box alert radius">
					Campos vacios.
				</div>
				
				<!-- input asunto-->
				<div class="row">
					<div class="large-12 columns">
						<label>
							<input type="text" id="txtSubjectMSGAdmin" placeholder="Asunto" class="radius" />
						</label>
					</div>
				</div>
				
				<!-- input mensaje-->
				<div class="row">
					<div class="large-12 columns">
						<label>
							<textarea id="txtMessageMSGAdmin" placeholder="Mensaje" class="radius" rows="10"></textarea>
						</label>
					</div>
				</div>
				
			</div>
					
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
		</div>
		<div class="bodyLoandingSend"></div>
		
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
<script type="text/javascript" src="<?php echo base_url().JS; ?>/send.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>-->