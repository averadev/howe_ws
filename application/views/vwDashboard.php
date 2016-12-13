<?php
$this->load->view('vwHeader');
?>
	<div id="wrapper">
	<section >
		<div class="row" id="sectionUp"  ></div>
		<div class="row" id="section" >
			<div class="small-12 medium-2 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-8 large-5 columns">
				
				<div class="rectRounded rectRoundedLeft">
					
					<table width="100%" class="tableReport" id="tableMessageDash">
						<thead>
							<tr>
								<th>ÚLTIMOS REPORTES</th>
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
				
					<!--<div class="small-12 medium-12 large-12 columns bodyRectRounded" >
						
							
						
						
					</div>-->
					
					
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
			
			<div class="small-12 medium-8 large-5 columns">
				<div class="rectRounded rectRoundedRight">
				
					<table width="100%" class="tableReport" id="tableVisitDash" >
						<thead>
							<tr>
								<th>ÚLTIMAS VISITAS</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($visit as $item):
							?>
								<tr>
									<td>
										<div class="bodyMSGRectRounded" value="<?php echo $item->id; ?>" id="visit">
<!--											<div class="labeProviderRectRounded"><?php if($item->proveedor == 1){ echo "<img src='assets/img/web/supplier.png'>"; } ?></div>-->
											<div class="labeDateRectRounded"><?php echo $item->dia . ", " . $item->fechaFormat;  ?></div>
											<div class="labeInfoRectRounded">
                                                <div class="labeProviderRectRounded"><?php if($item->proveedor == 1){ echo "<img src='assets/img/web/supplier.png'>"; } ?></div>
                                                <?php echo "CONDO " . $item->nameCondominium . ": " . $item->motivo; ?>
                                            </div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
							<?php 
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
								<div id="demo4">
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
	<div id="dialog-Message" title="Mensaje">
        <!--<div class="bodyLoanding"></div>--->
		<div class="row collapse">
			<div class="small-12 medium-12 large-12 columns" id="dateMessage">
			</div>				
		</div>
		<div id="messageAdmin">
			<div class="row">
				<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
				<div class="small-12 medium-12 large-10 columns">
				
					<div class="small-12 medium-12 large-12 titleInfoMSGDash">Asunto:</div>
					<div class="small-12 medium-12 large-12 InfoMSGDash" id="subjectMessage" ></div>
					
					<div class="small-12 medium-12 large-12 titleInfoMSGDash">Mensaje:</div>
					<div class="small-12 medium-12 large-12 InfoMSGDash" id="infoMessage" ></div>
					
					<div class="small-12 medium-12 large-12 titleInfoMSGDash">Guardia:</div>
					<div class="small-12 medium-12 large-12 InfoMSGDash" id="guardMessage" ></div>
					
				</div>
					
				<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			</div>
		</div>
		<div id="messageVisit">
			<div class="row">
				<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
				<div class="small-12 medium-12 large-10 columns">
				
					<div class="small-12 medium-12 large-12 titleInfoMSGDash">Visitante:</div>
					<div class="small-12 medium-12 large-12 InfoMSGDash" id="nameVisit" >esto es un mensaje de la empresa orvelsof</div>
					
					<div class="small-12 medium-12 large-12 titleInfoMSGDash">Motivo de la visita:</div>
					<div class="small-12 medium-12 large-12 InfoMSGDash" id="reasonVisit" >esto es un mensaje de la empresa orvelsof</div>
					
					<div class="small-12 medium-12 large-12 titleInfoMSGDash">Guardia:</div>
					<div class="small-12 medium-12 large-12 InfoMSGDash" id="guardVisit" >esto es un mensaje de la empresa orvelsof</div>
					
					<div class="small-12 medium-12 large-12 titleInfoMSGDash">Condominio:</div>
					<div class="small-12 medium-12 large-12 InfoMSGDash" id="condominiusVisit" >esto es un mensaje de la empresa orvelsof</div>
					
				</div>
					
				<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			</div>
		</div>
		
	</div>
	<!------ fin modal -------->
	
	</div>


<?php
$this->load->view('vwFooter');
?>



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>/dashboard.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>/paginadorYBuscador.js"></script>