<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$FidProfe = $_POST['selectProfes'];
?>

<div class="container-fluid">     
	<h4><?=PROFESSOR_TITUL_TAULA;?></h4>
  	<form  id="FormProfe" method="post" action="index.php?accio=professor2">
    	<div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_LABEL_PROFE_VORE;?></label>
      		<select class="form-control" id="selectProfes" name="selectProfes" onchange="propaga(this)">
	    		<option value=""></option>
	    		<?php
	    		$profes = $db->select('Professor', array('ID','NOM'), array('ORDER' => 'NOM'));  
	    		foreach($profes as $profe){      
				  $profe_id = $profe['ID'];	  	  
	    		  $profe_nomprofe = $profe['NOM'];
				  if($FidProfe == $profe_id){
					echo "<option selected value='".$profe_id."'>".$profe_nomprofe."</option>";
				  }else{
					echo "<option value='".$profe_id."'>".$profe_nomprofe."</option>";
				  }

				  
	    		}
	    		?>        
      		</select>
			<script>
				function propaga(sel){
					document.getElementById("inputNouProfe").value = sel.options[sel.selectedIndex].text;
					document.getElementById("idProfe").value = sel.options[sel.selectedIndex].value;
				}						
			</script>	  
	  	</div>
		<div class="form-group">	  
			<br>
			<button type="submit" class="btn btn-primary"><?=PROFESSOR_LABEL_SUBMIT_VORE;?></button>	 
			<input type="hidden" id="idProfe" name="idProfe">
		</div>
  	</form>
</div>
<?php 
if ($FidProfe!=""){
	$profes = $db->select('Professor', array('ID','NOM'), array('AND' => ['ID' => $FidProfe]));  	  
	foreach($profes as $profe){      
		$profe_id = $profe['ID'];	  	  
		$profe_nomprofe = $profe['NOM'];	  	  
	}
}else{
	$profe_id = 0;
	$profe_nomprofe="";
}
?>
<div class="container-fluid">     
	<h4><?=$profe_nomprofe;?></h4> 
	<table class="table table-sm table-bordered table-striped">
		<thead>
			<tr>
			<th class="col-2" scope="col"><?=PROFESSOR_HORA;?></th>
			<th class="col-2" scope="col"><?=DIA_1;?></th>
			<th class="col-2" scope="col"><?=DIA_2;?></th>
			<th class="col-2" scope="col"><?=DIA_3;?></th>
			<th class="col-2" scope="col"><?=DIA_4;?></th>
			<th class="col-2" scope="col"><?=DIA_5;?></th>
			</tr>
		</thead>
		<tbody>	
			<?php
			foreach ($config_intervals as $hora){	
				//GENERAR DIES	
				$valor_dies_setmana=[];			
				foreach ($config_dies_setmana as $dia_setmana){
				

					$Qhorari = $db->select(
						'Horari(H)', ['[>]Professor(P1)' => ['IDPROFESSOR' => 'ID']],
						  array('H.TIPUS','H.MATERIA', 'H.AULA', 'H.GRUP','H.ID','H.IDPROFESSOR','H.DATA','H.HORA','P1.NOM'),
							array('AND' => array('IDPROFESSOR' => $profe_id,'DATA' => $dia_setmana, 'HORA'=> $hora))
					  );
					  $aux="";			  	
					foreach($Qhorari as $temp){
						$temp_id=$temp['ID'];
						$temp_idprofe=$temp['IDPROFESSOR'];
						if ($temp['TIPUS']=='LEC'){
							$aux .= $temp['MATERIA']." ".$temp['GRUP']." (".$temp['AULA'].")";	
						}else{
							$aux .= $temp['TIPUS']."";
						}
						if($Feditar != ""){$aux.=" <a href=\"index.php?pprofe=".$profe_id."&pid=".$temp_id."&pdata=".$dia_setmana."&phora=".$hora."&accio=professor_sessio\" class=\"btn btn-outline-success btn-sm\" role=\"button\" aria-disabled=\"true\">E</a><br> ";}
					}
					if($Feditar != ""){$aux.="<a href=\"index.php?pprofe=".$profe_id."&pdata=".$dia_setmana."&phora=".$hora."&accio=professor_sessio\" class=\"btn btn-outline-success btn-sm\" role=\"button\" aria-disabled=\"true\">+</a> ";}				
					array_push($valor_dies_setmana,$aux);
				}
				//CONSTRUIR LA TAULA
				echo "<tr>";
				echo "<td>".$config_hores[$hora]."</td>";		
				foreach ($valor_dies_setmana as $valor_dia_setmana){					
					if($valor_dia_setmana==""){
						echo "<td></td>";
					}else{
						echo "<td>".$valor_dia_setmana."</td>";
					}
				}
				echo "</tr>";		  
			}	
			?>		
		</tbody>
	</table>
 </div>