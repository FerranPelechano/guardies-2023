<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$FGrup = $_POST['selectGrup'];
?>
<div class="container-fluid">     
	<h4><?=GRUP_TITUL;?></h4>
  	<form  id="FormGrup" method="post" action="index.php?accio=grup">
    	<div class="form-group">
      		<label for="labelProfes"><?=GRUP_LABEL_GRUP;?></label>
      		<select class="form-control" id="selectGrup" name="selectGrup">
	    		<option value=""></option>
	    		<?php
	    		$grups = $db->select('Horari', array('@GRUP'), array('ORDER' => 'GRUP'));  
	    		foreach($grups as $grup){      
	    		  $grup_nom = $grup['GRUP'];
				  if($grup_nom!=""){
                    if($grup_nom==$FGrup){
                        echo "<option value='".$grup_nom."' selected>".$grup_nom."</option>";
                    }else{
                        echo "<option value='".$grup_nom."'>".$grup_nom."</option>";
                    }                    
                  }
	    		}
	    		?>        
      		</select>
	  	</div>
		<div class="form-group">	  
			<br>
			<button type="submit" class="btn btn-primary"><?=GRUP_LABEL_SUBMIT;?></button>	 
		</div>
  	</form>
</div>
<div class="container-fluid">     
	<h4><?=GRUP_HORARI;?>: <?=$FGrup;?></h4> 
	<table class="table table-sm table-bordered table-striped">
		<thead>
			<tr>
			<th class="col-2" scope="col"><?=GRUP_HORA;?></th>
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
							array('AND' => array('GRUP' => $FGrup,'DATA' => $dia_setmana, 'HORA'=> $hora))
					  );
                      //echo $db->last()."<br>";
					  $aux="";			  	
					foreach($Qhorari as $temp){
						$temp_id=$temp['ID'];
						$temp_idprofe=$temp['IDPROFESSOR'];
						if ($temp['TIPUS']=='LEC'){
							$aux .= $temp['MATERIA']." (".$temp['AULA'].")<br> ";
                            $aux .= $temp['NOM']."<br>  ";
						}else{
							$aux .= $temp['TIPUS']." ".$temp['MATERIA']."<br>";
						}		
                        
					}
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