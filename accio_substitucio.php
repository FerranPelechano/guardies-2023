<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<div class="container-fluid">     
	<h4><?=SUBSTITUCIO_TITUL;?></h4>
  	<form  id="formulari" method="post" action="index.php?accio=substitucio_crear">	
		<div class="row">
			<div class="form-group">
				<button type="button" class="btn btn-primary btn-sm" onclick="enviar(-1);"><?=SUBSTITUCIO_AFEGIR;?></button>	
			</div>
		</div>	
		<script>
			function enviar(valor){			
				document.getElementById("message").innerHTML="";
				var missatge_error="";	
				if (selectSust.value==""){
					missatge_error = missatge_error+"<?=SUBSTITUCIO_ERROR_SUBSTITUT;?><br>";
				}
				if (selectProfe.value==""){
					missatge_error = missatge_error+"<?=SUBSTITUCIO_ERROR_PROFESSOR;?><br>";
				}
				if (dataFrom.value==""){
					missatge_error = missatge_error+"<?=SUBSTITUCIO_ERROR_INICI;?><br>";
				}
				if (dataTo.value==""){
					missatge_error = missatge_error+"<?=SUBSTITUCIO_ERROR_FI;?><br>";
				}			
				if (missatge_error ==""){
					document.getElementById("formulari").submit();					
				}else{
					document.getElementById("message").innerHTML+="<div class=\"alert alert-warning \">"+missatge_error+"</div>";
				}			
			}	
		</script>	
		<div class="row">
	    	<div class="col">
	    		<div class="form-group">
	      			<label for="labelProfes"><?=SUBSTITUCIO_LABEL_SUBSTITUT;?></label>
	      			<select class="form-control" id="selectSust" name="selectSust">
		    			<option value=""></option>
		    			<?php
		    			$profes = $db->select('Professor', array('ID','NOM'), array('ORDER' => 'NOM'));  
		    			foreach($profes as $profe){      
							$profe_id = $profe['ID'];	  	  
		    			  	$profe_nomprofe = $profe['NOM'];	  	  
		    			  	echo "<option value='".$profe_id."'>".$profe_nomprofe."</option>";
		    			}
		    			?>        
	      			</select>
	      			<label for="labelProfes"><?=SUBSTITUCIO_LABEL_SUBSTITUIT;?></label>
	      			<select class="form-control" id="selectProfe" name="selectProfe">
		    			<option value=""></option>
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
	      			<label for="labelFrom"><?=SUBSTITUCIO_LABEL_DESDE;?></label>
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
			  		<label for="labelTo"><?=SUBSTITUCIO_LABEL_FINS;?></label>
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
		</div>
		<br>
	</form>
</div>
<br>
<div id="message"></div>  
<?php /* ----- LLISTA DE SUBSTITUCIONS -----*/  ?>
<div class="container-fluid">     
	<h4><?=SUBSTITUCIO_LLISTA_TITUL;?></h4>
	<table class="table table-sm table-bordered table-striped">
		<thead>
			<tr>
			<th class="col-1" scope="col"><?=SUBSTITUCIO_TH_1;?></th>
			<th class="col-3" scope="col"><?=SUBSTITUCIO_TH_2;?></th>
			<th class="col-3" scope="col"><?=SUBSTITUCIO_TH_3;?></th>
			<th class="col-1" scope="col"><?=SUBSTITUCIO_TH_4;?></th>
			<th class="col-1" scope="col"><?=SUBSTITUCIO_TH_5;?></th>
			<th class="col-2" scope="col"><?=SUBSTITUCIO_TH_6;?></th>
			</tr>
		</thead>
		<tbody>	
			<?php
			//Professorat Substitut
			$substitucions = $db->select(
				'Substitucions(S)', ['[>]Professor(P1)' => ['PROFE' => 'ID'],'[>]Professor(P2)' => ['SUBSTITUT' => 'ID']],
				array('S.ID', 'S.PROFE', 'S.DE','S.A','P1.NOM','P2.NOM(NOMSUS)'),
				array('ORDER' => ['S.ID' => 'DESC'])
			);			
			foreach($substitucions as $substitucio){      
				$substitucio_id = $substitucio['ID'];
				$substitucio_idprofe = $substitucio['PROFE'];
				$substitucio_profe = $substitucio['NOM'];	  	  
				$substitucio_sust = $substitucio['NOMSUS'];	  	  
				$substitucio_de = $substitucio['DE'];	  	  
				$substitucio_a = $substitucio['A'];	  	  
				//Contar les absències
				$contar_absencies=0;
				$contar_absencies = $db->count('Guardia', array('IDPROFESSOR' => $substitucio_idprofe,'DATA[>=]' => $substitucio_de,'DATA[<=]'=>$substitucio_a));
				echo "<tr>";
				echo "<td>".$substitucio_id."</td>";
				echo "<td>".$substitucio_profe."</td>";
				echo "<td>".$substitucio_sust."</td>";
				echo "<td>".$substitucio_de."</td>";
				echo "<td>".$substitucio_a."</td>";
				echo "<td>";
				echo "<a href=\"index.php?accio=substitucio_crear&mode=elimina&idsubst=".$substitucio_id."\" class=\"btn btn-outline-danger btn-sm\" role=\"button\" aria-disabled=\"true\">Elimina</a>";
				if ($contar_absencies!=0){
					echo " ";
					echo "<a href=\"index.php?accio=substitucio_crear&mode=elimina_absencies&idprofe=".$substitucio_idprofe."&de=".$substitucio_de."&a=".$substitucio_a."\" class=\"btn btn-danger btn-sm\" role=\"button\" aria-disabled=\"true\">Elimina Absències <span class=\"badge badge-info\">".$contar_absencies."</span></a>";
				}
				echo "</td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>
</div>