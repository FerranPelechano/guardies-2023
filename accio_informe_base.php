<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<div class="col-12">
	<table class="table table-sm table-bordered table-striped">
  		<thead>
    		<tr>
	  			<th class="col-1" scope="col"><?=INFORME_BASE_TH_1;?></th>
	  			<th class="col-1" scope="col"><?=INFORME_BASE_TH_2;?></th>
	  			<th class="col-2" scope="col"><?=INFORME_BASE_TH_3;?></th>
	  			<th class="col-2" scope="col"><?=INFORME_BASE_TH_4;?></th>
	  			<th class="col-2" scope="col"><?=INFORME_BASE_TH_5;?></th>
	  			<th class="col-2" scope="col"><?=INFORME_BASE_TH_6;?></th>
	  			<th class="col-2" scope="col"><?=INFORME_BASE_TH_7;?></th>
		    </tr>
  		</thead>
  		<tbody>	  
			<?php	
			/* ----- INFORME D'ABSENCIES ----- */  
			echo "<h4>".INFORME_BASE_DESDE.": ".data_en_cadena($data)."</h4>";
			$absencies=$db->query("SELECT G.IDPROFESSOR, P1.NOM, G.DATA, G.HORA, G.COBERTAPER, P2. NOM AS NOM_GUARDA, G.ACTIVITAT, G.OBSERVACIONS, '' as LOGTIME  FROM Guardia G LEFT JOIN Professor P1 ON G.IDPROFESSOR=P1.ID LEFT JOIN Professor P2 ON G.COBERTAPER=P2.ID WHERE DATA >= '".$data."' UNION ALL  SELECT GL.IDPROFESSOR, P1.NOM, GL.DATA, GL.HORA, '' AS COBERTPER, '' AS NOM_GUARDA, '' AS ACTIVITAT, '' AS OBSERVACIONS, GL.LOGTIME FROM GuardiaLog GL LEFT JOIN Professor P1 ON GL.IDPROFESSOR=P1.ID WHERE DATA >= '".$data."' ORDER BY DATA,HORA,P1.NOM")->fetchAll();    
			//echo $db->last()."<br>";	
			foreach ($absencies as $absencia){
				$absencia_data= $absencia['DATA'];		
				$absencia_hora= $absencia['HORA'];		
			    $absencia_idprofe = $absencia['IDPROFESSOR'];		
				$absencia_idprofe_nom = $absencia['NOM'];		
				$absencia_observacions = $absencia['OBSERVACIONS'];
				$absencia_activitat = $absencia['ACTIVITAT'];
				$absencia_cobertaper = $absencia['COBERTAPER'];
				$absencia_cobertaper_nom = $absencia['NOM_GUARDA'];
				$absencia_logtime = $absencia['LOGTIME'];
			  	//Si és una fila eliminada destacar-la
				$destaca="";
			  	if ($absencia_logtime!=""){
					$destaca="style='background-color: #fcf8e3;'";
				}else{
				  	$destaca="";
			  	}
				if (is_null($absencia_idprofe)|| empty($absencia_idprofe) || $absencia_idprofe== ""){
					//echo "null";
					$cadena_absent = "";				
				}else{
					$cadena_absent = "";				
					//Substitucions
					$substituts = $db->query("SELECT S.*, P.NOM FROM Substitucions S LEFT JOIN Professor P ON  S.SUBSTITUT=P.ID WHERE S.PROFE=".$absencia_idprofe. " AND ('" .$absencia_data. "' BETWEEN S.DE AND S.A)" )->fetchAll();	
					$cadena_substitucio = "";
					foreach ($substituts as $substitut){			
						$substitucio_profe_nom = $substitut['NOM'];		
						$cadena_substitucio = "".$substitucio_profe_nom."";
					}					
					if ($cadena_substitucio == ""){
						$cadena_absent= $absencia_idprofe_nom."";	
					}else{
						$cadena_absent= $absencia_idprofe_nom." <b>[S]</b> ".$cadena_substitucio;	
					}
				}
				if ($cadena_absent == "" && intval($absencia_activitat)<0){$cadena_absent="Pati";}		
				if ($cadena_absent == ""){$cadena_absent="Convivència";}		
				$cadena_guarda = $absencia_cobertaper_nom."";
				if ($cadena_guarda == ""){$cadena_guarda="";}		
				echo "<tr ".$destaca.">";
				echo "<td>".$absencia_data."</td>";
				echo "<td>".$config_hores[$absencia_hora]."</td>";	    
				echo "<td>".$cadena_absent."</td>";
				echo "<td>".$cadena_guarda."</td>";
				echo "<td>".$absencia_observacions."</td>";
				echo "<td>".$absencia_activitat."</td>";		
				echo "<td>".$absencia_logtime."</td>";				
				echo "</tr>";		
			}	      
  			?>
  		</tbody> 
	</table>  
</div>