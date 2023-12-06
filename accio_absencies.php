<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<div class="container-fluid">     
 	<h4><?=ABSENCIES_TITUL;?></h4>
  	<form id="formulari" method="post" action="index.php?accio=absencies_crear">
   		<div class="form-group">
  	  		<input type="hidden" id="mode" name="mode" value="0">	
  	  		
			<?php
			if ($username!="admin"){
				?>
				<div id="mode_alert" class="alert alert-warning" role="alert"><?=ABSENCIES_LABEL_AVISO?></div>				
				<?php
			}
			?>
			<div id="mode_alert" class="alert alert-primary" role="alert"><?=ABSENCIES_COMMUTA_AFEGIR_TXT?></div>
				<button id="mode_button" type="button" class="btn btn-outline-primary btn-sm" onclick="conmuta()"><?=ABSENCIES_COMMUTA;?></button>
				<script>
					function conmuta(){	
						if (mode.value==1){
							mode.value=0;
							document.getElementById("mode_button").className="btn btn-outline-primary btn-sm";
							document.getElementById("boto_enviar").className="btn btn-primary btn-sm";
							document.getElementById("mode_alert").className="alert alert-primary";
							document.getElementById("mode_alert").innerHTML="<?=ABSENCIES_COMMUTA_AFEGIR_TXT;?>";
							document.getElementById("boto_enviar").innerHTML="<?=ABSENCIES_COMMUTA_AFEGIR;?>";
						}else{
							mode.value=1;		
							document.getElementById("mode_button").className="btn btn-outline-danger btn-sm";
							document.getElementById("boto_enviar").className="btn btn-danger btn-sm";
							document.getElementById("mode_alert").className="alert alert-danger";
							document.getElementById("mode_alert").innerHTML="<?=ABSENCIES_COMMUTA_ELIMINAR_TXT;?>";
							document.getElementById("boto_enviar").innerHTML="<?=ABSENCIES_COMMUTA_ELIMINAR;?>";
						}
					}	
				</script>
  	  		</div>			
	  		<div class="row">
	    		<div class="col">
					<div class="form-group">
						<label for="labelProfes"><?=ABSENCIES_LABEL_PROFES;?></label>
						<select multiple size="12" class="form-control" id="selectProfes" name="selectProfes[]">
							<?php
								$profes = $db->select('Professor', array('ID','NOM'), array('ORDER' => 'NOM'));  
								foreach($profes as $profe){      
									$profe_id = $profe['ID'];	  	  
									$profe_nomprofe = $profe['NOM'];	  	  
									echo "<option value='".$profe_id."'>".$profe_nomprofe."</option>";
								}
							?>        
						</select>
					</div>
				</div>
				<div class="col">
					<div class="form-group">
						<div id="datepickerTo" data-date=""></div>
							<input type="text" id="dataTo" name="dataTo" value="" readonly>
					</div>           
					<script type="text/javascript">
						$('#datepickerTo').datepicker({
							format: "yyyy-mm-dd",
							weekStart: 1,
							todayBtn: "linked",
							clearBtn: true,
							language: "ca",
							multidate: true
						});
						$('#datepickerTo').on('changeDate', function() {
							$('#dataTo').val(
								$('#datepickerTo').datepicker('getFormattedDate')
							);
						});
					</script>
				</div>
  			</div>
  			<br>
  			<div class="row">
				<div class="col">
					<?php
					//Generar Checkbox hores
					foreach ($config_intervals as $interval){
						$pati="";
						if ($interval=="R1"){$pati="Pati";}
						if ($interval=="R2"){$pati="Pati";}
						if ($interval=="R3"){$pati="Pati";}	  
						?>
						<div class="form-check form-check-inline">
					  		<label class="form-check-label" for="inlineCheckbox<?=$interval;?>"><?=$config_hores[$interval]." ".$pati;?></label>
					  		<input class="form-check-input" type="checkbox" id="inlineCheckbox<?=$interval;?>" name="inlineCheckbox<?=$interval;?>" value="<?=$interval;?>">
						</div>
						<?php 
					}
					?>		
					<br>
					<div>
					  <button type="button" class="btn btn-outline-primary btn-sm" onclick="marcar('<?=$config_mati;?>')"><?=ABSENCIES_LABEL_MC;?></button>
					  <button type="button" class="btn btn-outline-primary btn-sm" onclick="marcar('<?=$config_vesprada;?>')"><?=ABSENCIES_LABEL_VC;?></button>
					  <button type="button" class="btn btn-outline-primary btn-sm" onclick="marcar('<?=$config_dia;?>')"><?=ABSENCIES_LABEL_DC;?></button>
					  <button type="button" class="btn btn-outline-primary btn-sm" onclick="desmarcar('<?=$config_dia;?>')"><?=ABSENCIES_LABEL_NETEJAR;?></button>
					</div>
					<script>
						function marcar(llista){
							var a = llista.split(",");
							for (i = 0; i < a.length; i++) {
								document.getElementById("inlineCheckbox" + a[i]).checked = true;
							}												
						}		
						function desmarcar(llista){
							var a = llista.split(",");
							for (i = 0; i < a.length; i++) {
								document.getElementById("inlineCheckbox" + a[i]).checked = false;
							}												
						}			
					</script>
				</div>
			</div>
    		<br>
			<div class="form-group">
          		<label for="labelActivitat"><?=ABSENCIES_LABEL_ACTIVITAT;?></label>
          		<input type="text" class="form-control" id="inputActivitat" name="inputActivitat">
        	</div>
			<br>
			<div>
				<button type="button" class="btn btn-outline-primary btn-sm" onclick="formacio('[PF] ')"><?=ABSENCIES_LABEL_PF;?></button>				
				<button type="button" class="btn btn-outline-primary btn-sm" onclick="formacio('[A5] ')"><?=ABSENCIES_LABEL_A5;?></button>				
			</div>			
			<script>
				function formacio(valor){
					document.getElementById("inputActivitat").value=valor+document.getElementById("inputActivitat").value;
				}
			</script>			
			<br>
      		<div class="form-group">
        		<label for="labelObservacions"><?=ABSENCIES_LABEL_OBSERVACIONS;?></label>
        		<textarea class="form-control" id="textObservacions" name="textObservacions" rows="3"></textarea>
      		</div>
    		<br>
    		<div class="form-group">
				<div id="message"></div>
				<button id="boto_enviar" type="button" class="btn btn-primary btn-sm" onclick="valida('<?=$config_dia;?>');"><?=ABSENCIES_COMMUTA_AFEGIR;?></button>
				<script>
					function valida(llista){			
						document.getElementById("message").innerHTML="";				
						var a = llista.split(",");								
						var contar=0;
						for (i = 0; i < a.length; i++) {
							if (document.getElementById("inlineCheckbox" + a[i]).checked){
								contar++;
							}
						}				
						var missatge_error="";
						if (contar==0){missatge_error = missatge_error+"<?=ABSENCIES_MSG_HORA;?><br>";}				
						if (selectProfes.value==""){missatge_error = missatge_error+"<?=ABSENCIES_MSG_PROFE;?><br>";}
						if (dataTo.value==""){missatge_error = missatge_error+"<?=ABSENCIES_MSG_DATA;?><br>";}
						if (missatge_error ==""){
							document.getElementById("formulari").submit();
						}else{
							document.getElementById("message").innerHTML+="<div class=\"alert alert-warning \">"+missatge_error+"</div>";
						}						
					}
				</script>		
			</div>						
  		</div>
  	</form>
</div>