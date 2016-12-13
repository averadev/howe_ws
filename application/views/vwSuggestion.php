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
						<a id="btnSuggestionDate" class="button small radius">Buscar</a>
					</div>
				</div>
				
			</div>
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
		</div>
		<div class="row" id="section" style="margin-top:0;" >
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
			<div class="small-12 medium-12 large-5 columns">
			
				<div class="rectRounded rectRoundedLeft">
					<table width="100%" class="tableReport" id="tableSuggestion">
						<thead>
							<tr>
								<th>ÚLTIMOS REPORTES</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($suggestion as $item):
							?>
								<tr>
									<td>
										<div class="bodyMSGRectRounded" value="<?php echo $item->id; ?>" id="suggestion">
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
						
							<div class="small-12 medium-12 large-12 columns" id="dateMessage2"></div>
							
							<div class="small-12 medium-12 large-12 InfoMSGBold" id="guardMessage" ></div>
				
							<div class="small-12 medium-12 large-12 InfoMSG" id="subjectMessage" ></div>
					
							<div class="small-12 medium-12 large-12 InfoMSG" id="infoMessage" ></div>
					
						</div>
						<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
					</div>
					
				</div>
			</div>
			<div class="small-12 medium-12 large-1 columns">&nbsp;</div>
		</div>
		
	</section>

<?php
$this->load->view('vwFooter');
?>



<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>/suggestion.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url().JS; ?>admin/paginadorYBuscador.js"></script>-->