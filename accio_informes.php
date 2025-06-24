<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$data=date("Y-m-d");
$setmanaL=dilluns_setmana($data);
$setmanaV=divendres_setmana($data);
?>
<div class="container-fluid">     
	<h4><?=INFORMES_TITUL;?></h4>  
  	<form id="formulari" method="post" action="index.php?accio=informes_crear">
		<div class="row">
			<div class="form-group">
				<button id="inf_base" type="button" class="btn btn-primary btn-sm" onclick="enviar(-1);"><?=INFORMES_GENERAR;?></button>
				<button id="inf_semana" type="button" class="btn btn-outline-primary btn-sm" onclick="enviar(0);"><?=INFORMES_0;?></button>
				<button id="inf_semana" type="button" class="btn btn-outline-primary btn-sm" onclick="enviar(1);"><?=INFORMES_1;?></button>
				<button id="inf_semana" type="button" class="btn btn-outline-primary btn-sm" onclick="enviar(2);"><?=INFORMES_2;?></button>
				<a href="index.php?accio=informe_ranking" class="btn btn-outline-danger btn-sm " role="button" aria-disabled="true"><?=INFORMES_3;?></a>
				<a href="index.php?accio=informe_base&data=<?=$data;?>" class="btn btn-outline-danger btn-sm " role="button" aria-disabled="true"><?=INFORMES_BASE;?></a>
			</div>
		</div>
		<script>
			function enviar(valor){			
				document.getElementById("message").innerHTML="";			
				if (valor==0){
					document.getElementById("selectProfes").value='0';
					document.getElementById("dataFrom").value='<?=$setmanaL;?>';
					document.getElementById("dataTo").value='<?=$setmanaV;?>';
					document.getElementById("iCheck1").value='';
					document.getElementById("iCheck2").value='';
				}
				if (valor==1){
					document.getElementById("selectProfes").value='-1';
					document.getElementById("dataFrom").value='<?=$setmanaL;?>';
					document.getElementById("dataTo").value='<?=$setmanaV;?>';
					document.getElementById("iCheck1").value='iCheck1';
					document.getElementById("iCheck2").value='';
				}			
				if (valor==2){
					document.getElementById("selectProfes").value='0';
					document.getElementById("dataFrom").value='<?=$setmanaL;?>';
					document.getElementById("dataTo").value='<?=$setmanaV;?>';
					document.getElementById("iCheck1").value='';
					document.getElementById("iCheck2").value='iCheck2';
				}								
				var missatge_error="";
				if (dataFrom.value==""){
					missatge_error = missatge_error+"<?=INFORMES_ERROR_INICI;?><br>";
				}
				if (dataTo.value==""){
					missatge_error = missatge_error+"<?=INFORMES_ERROR_FINAL;?><br>";
				}
				if (missatge_error ==""){
					document.getElementById("formulari").submit();					
				}else{
					//alert(missatge_error);
					document.getElementById("message").innerHTML+="<div class=\"alert alert-warning \">"+missatge_error+"</div>";
				}			
			}	
		</script>
		<br>
  		<div class="row">
    		<div class="col">
				<div class="form-group">
					<label for="labelProfes"><?=INFORMES_LABEL_PROFES;?></label>
					<select multiple size="13" class="form-control" id="selectProfes" name="selectProfes[]">
						<?php
						echo "<option value='0' >--- ".INFORMES_SELECT." ---</option>";
						$profes = $db->select('Professor', array('ID','NOM'), array('ORDER' => 'NOM'));  
						foreach($profes as $profe){      
						$profe_id = $profe['ID'];	  	  
						$profe_nomprofe = $profe['NOM'];	  	  
						echo "<option value='".$profe_id."' selected>".$profe_nomprofe."</option>";
						}
						?>        
					</select>
				</div>
			</div>
			<div class="col">
				<div class="form-group">
					<label for="labelFrom"><?=INFORMES_DATA_INICI;?></label>
					<div id="datepickerFrom" data-date=""></div>
					<input type="text" id="dataFrom" name="dataFrom" readonly>
				</div>           
				<script type="text/javascript">
					$('#datepickerFrom').datepicker({
						format: "yyyy-mm-dd",
						weekStart: 1,
						todayBtn: "linked",
						clearBtn: true,
						language: "ca",
						multidate: false
					});
					$('#datepickerFrom').on('changeDate', function() {
						$('#dataFrom').val(
							$('#datepickerFrom').datepicker('getFormattedDate')
						);
					});
				</script>
			</div>
			<div class="col">
				<div class="form-group">
				<label for="labelTo"><?=INFORMES_DATA_FI;?></label>
				<div id="datepickerTo" data-date=""></div>
				<input type="text" id="dataTo" name="dataTo" readonly>
				</div>           
				<script type="text/javascript">
					$('#datepickerTo').datepicker({
						format: "yyyy-mm-dd",
						weekStart: 1,
						todayBtn: "linked",
						clearBtn: true,
						language: "ca",
						multidate: false
					});
					$('#datepickerTo').on('changeDate', function() {
						$('#dataTo').val(
							$('#datepickerTo').datepicker('getFormattedDate')
						);
					});
				</script>
			</div>	
			<div class="col">
				<div class="form-group">
					<div class="form-check form-check">
						<label for="labelChecks"><?=INFORMES_MOSTRAR_CONVIVENCIA;?></label> <input class="form-check-input" type="checkbox" id="iCheck1" name="iCheck1" value="iCheck1" checked>
					</div>
					<div class="form-check form-check">
						<label for="labelChecks"><?=INFORMES_MOSTRAR_ELIMINATS;?></label> <input class="form-check-input" type="checkbox" id="iCheck2" name="iCheck2" value="iCheck2" checked>
					</div>			
				</div>		
			</div>	
  		</div>    
  	</form>
    <br>
	<div id="message"></div>    
</div>