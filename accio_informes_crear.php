<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php 
$FProfes = $_POST['selectProfes'];
$FDataFrom = $_POST['dataFrom'];
$FDataTo = $_POST['dataTo'];
$FConvi = $_POST['iCheck1'];
$FEliminats = $_POST['iCheck2'];
$cad = "";
if($FConvi!=""){$cad.=" [C] ";};
if($FEliminats!=""){$cad.=" [E] ";};
//Construir cadena IDPROFESSOR i afegir si cal null per CONVI
if($FProfes!=""){
  $FProfes = implode(", ", $FProfes);
}
?>
<br>
<div class="col-12">
	<table class="table table-sm table-bordered table-striped">
  		<thead>
    		<tr>
			  <th class="col-1" scope="col"><?=INFORMES_CREAR_TH_1;?></th>
			  <th class="col-1" scope="col"><?=INFORMES_CREAR_TH_2;?></th>
			  <th class="col-2" scope="col"><?=INFORMES_CREAR_TH_3;?></th>
			  <th class="col-2" scope="col"><?=INFORMES_CREAR_TH_4;?></th>
			  <th class="col-2" scope="col"><?=INFORMES_CREAR_TH_5;?></th>
			  <th class="col-2" scope="col"><?=INFORMES_CREAR_TH_6;?></th>
			  <?php 
			  if ($FEliminats!=""){?>
				  <th class="col-2" scope="col"><?=INFORMES_CREAR_TH_7;?></th>
			  <?php }?>
    		</tr>
  		</thead>
  		<tbody>	
  			<?php
			/* ----- INFORME D'ABSENCIES ----- */  
			echo "<h4>".INFORMES_CREAR_INFORME.": ".data_en_cadena($FDataFrom)." ".INFORMES_CREAR_A." ".data_en_cadena($FDataTo)." ".$cad."</h4>";
			$query="";
			$query.="SELECT G.IDPROFESSOR, P1.NOM, G.DATA, G.HORA, G.COBERTAPER, P2. NOM AS NOM_GUARDA, G.ACTIVITAT, G.OBSERVACIONS, '' as LOGTIME  FROM Guardia G LEFT JOIN Professor P1 ON G.IDPROFESSOR=P1.ID LEFT JOIN Professor P2 ON G.COBERTAPER=P2.ID";
			$query.=" WHERE DATA >= '".$FDataFrom."' AND DATA <= '".$FDataTo."' ";
			if($FProfes!="0" && $FConvi!=""){$query.=" AND ( IDPROFESSOR IN (".$FProfes.") OR IDPROFESSOR IS NULL )";}
			if($FProfes!="0" && $FConvi==""){$query.=" AND IDPROFESSOR IN (".$FProfes.") ";}
			if($FProfes=="0" && $FConvi!=""){$query.=" ";}
			if($FProfes=="0" && $FConvi==""){$query.=" AND IDPROFESSOR IS NOT NULL ";}	
			if($FEliminats!=""){
				$query.=" UNION ALL  SELECT GL.IDPROFESSOR, P1.NOM, GL.DATA, GL.HORA, '' AS COBERTPER, '' AS NOM_GUARDA, '' AS ACTIVITAT, '' AS OBSERVACIONS, GL.LOGTIME FROM GuardiaLog GL LEFT JOIN Professor P1 ON GL.IDPROFESSOR=P1.ID ";	
				$query.=" WHERE DATA >= '".$FDataFrom."' AND DATA <= '".$FDataTo."' ";
				if($FProfes!="0" && $FConvi!=""){$query.=" AND ( IDPROFESSOR IN (".$FProfes.") OR IDPROFESSOR IS NULL )";}
				if($FProfes!="0" && $FConvi==""){$query.=" AND IDPROFESSOR IN (".$FProfes.") ";}
				if($FProfes=="0" && $FConvi!=""){$query.=" ";}
				if($FProfes=="0" && $FConvi==""){$query.=" AND IDPROFESSOR IS NOT NULL ";}
			}			
			$query.=" ORDER BY P1.NOM,DATA,HORA"; 
			$absencies=$db->query($query)->fetchAll();	
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
				if ($FEliminats!=""){
					$destaca="";		
					if ($absencia_logtime!=""){
						$destaca="style='background-color: #fcf8e3;'";
					}else{
						$destaca="";
					}
    		  	}else{
				  	$destaca="";
			  	}		
				if (is_null($absencia_idprofe)|| empty($absencia_idprofe) || $absencia_idprofe== ""){
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
				if ($cadena_absent == ""){$cadena_absent="Convivència";}	
				$cadena_guarda = $absencia_cobertaper_nom."";
				if ($cadena_guarda == ""){$cadena_guarda="";}	
				echo "<tr ".$destaca. ">";
				echo "<td>".$absencia_data."</td>";
				echo "<td>".$config_hores[$absencia_hora]."</td>";	    
				echo "<td>".$cadena_absent."</td>";
				echo "<td>".$cadena_guarda."</td>";
				echo "<td>".$absencia_observacions."</td>";
				echo "<td>".$absencia_activitat."</td>";		
				if ($FEliminats!=""){
					echo "<td>".$absencia_logtime."</td>";		
				}
				echo "</tr>";		
			}	  
			?>
  		</tbody> 
	</table>  
</div>

