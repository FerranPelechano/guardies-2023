<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
//Mirar el dia del que consultar horari
$dia = dia_actual($data);
//Mirar hora per destacar seccio
$horaactual = date("H:i");
//Si hora passa de 14:00 posicionar en vesprada al refrescar
if (strtotime($horaactual)>strtotime("14:00")){
	$refresca_vesprada="#vesprada";
}else{
	$refresca_vesprada="";
}

?>
<div class="row align-items-start">
	<div class="col">
		<table class="table table-sm table-bordered table-striped">
  			<thead>
  				<tr>
  			    	<th class="col-1" scope="col"><?=MOSTRAR_TH_1;?></th>
  			    	<th class="col-3" scope="col"><?=MOSTRAR_TH_2;?></th>
  			    	<th class="col-4" scope="col"><?=MOSTRAR_TH_3;?></th>
  			    	<th class="col-4" scope="col"><?=MOSTRAR_TH_4;?></th>
				  	<th class="col-1" scope="col"><?=MOSTRAR_TH_5;?></th>
  			  	</tr>
  			</thead>
  			<tbody>	
				<?php
				//Qui està de Guardia a cada hora
    			foreach ($config_intervals as $hora){		
					//Inicialitza cadenes (si no hi ha sessions deuen estar buides)
					$cadena_link="";
					$cadena_link_convi="";				
					$destaca="";				
					$contar_absencies=0;	
					$contar_guardies=0;
				  	if (strtotime($data)==strtotime(date("Y-m-d")) && strtotime($horaactual)>strtotime($config_hores[$hora])){
						  $destaca="style='background-color: #fcf8e3;'";
					}else{
						  $destaca="";						  
					 }				  	  				
					 /* -------------------------- */
					 /* ----- COLUMNA1 HORES ----- */					
					 /* -------------------------- */
      				//Canviar nomenclatura Rx per Pati
					$pati="";	  				
					if ($hora=="R1" || $hora=="R2" || $hora=="R3"){$pati="Pati";}
					//Afegir anchor a les 14:30 per fer refresc més senzill
					if ($hora=="7"){$anchor="id=\"vesprada\"";}else{$anchor="";}
					//Mostrar Columna1
					echo "<tr ".$anchor."><th ".$destaca." scope=\"row\">".$config_hores[$hora]." ".$pati."</th>";					
					/* -------------------------- */
					/* ----- COLUMNA2 PROFES DE GUARDIA I RESERVA ----- */
					/* -------------------------- */
					//Professorat de Guardia
					$horaris = $db->query("
					SELECT H.ID, H.IDPROFESSOR,H.DATA,H.HORA,P1.NOM
					,(SELECT COUNT(G2.COBERTAPER) FROM Guardia AS G2 WHERE G2.COBERTAPER=H.IDPROFESSOR AND G2.HORA='".$hora."' AND 
					case cast (strftime('%w',G2.DATA) as integer) when 0 then 'D' when 1 then  'L' when 2 then  'M' when 3 then  'X' when 4 then  'J' when 5 then  'V' when 6 then  'S' else '' end ='".$dia."' AND G2.IDPROFESSOR IS NOT NULL) AS GUA					
					,(SELECT COUNT(G2.COBERTAPER) FROM Guardia AS G2 WHERE G2.COBERTAPER=H.IDPROFESSOR AND G2.HORA='".$hora."' AND 
					case cast (strftime('%w',G2.DATA) as integer) when 0 then 'D' when 1 then  'L' when 2 then  'M' when 3 then  'X' when 4 then  'J' when 5 then  'V' when 6 then  'S' else '' end ='".$dia."' AND G2.IDPROFESSOR IS NULL) AS CONV					
					FROM Horari H 					
					LEFT JOIN Professor AS P1 ON H.IDPROFESSOR = P1.ID 
					WHERE (H.DATA = '".$dia."' AND H.HORA = '".$hora."' AND H.TIPUS = 'G') ORDER BY H.IDPROFESSOR
					")->fetchAll();
					echo "<td><div>";
					$missatgesG="";
					$missatgesG2="";
					foreach($horaris as $horari){    
						$contar_guardies=$contar_guardies+1;  
					    $horari_hora = $horari['HORA'];
						$horari_idprofe = $horari['IDPROFESSOR'];	  	  
					    $horari_nomprofe = $horari['NOM'];	  	  
						//Substitucions
						$substituts = $db->query("SELECT S.*, P.NOM FROM Substitucions S LEFT JOIN Professor P ON  S.SUBSTITUT=P.ID WHERE S.PROFE=".$horari_idprofe. " AND ('" .$data. "' BETWEEN S.DE AND S.A)" )->fetchAll();
						$cadena_substitucio = "";
						$cadena_substitucio2 = "";
						foreach ($substituts as $substitut){
							$substitucio_profe_id = $substitut['SUBSTITUT'];		
							$substitucio_profe_nom = $substitut['NOM'];		
							$cadena_substitucio = " <b>[S]</b>".$substitucio_profe_nom."";
							$cadena_substitucio2 = " [S] ".$substitucio_profe_nom."";
							//----- Contar extra per substitut -----							
							$acumula = $db->query("
							SELECT COUNT(G2.COBERTAPER) AS GUA FROM Guardia AS G2 WHERE G2.COBERTAPER='".$substitucio_profe_id."' AND G2.HORA='".$hora."' AND 
							case cast (strftime('%w',G2.DATA) as integer) when 0 then 'D' when 1 then  'L' when 2 then  'M' when 3 then  'X' when 4 then  'J' when 5 then  'V' when 6 then  'S' else '' end ='".$dia."' AND G2.IDPROFESSOR IS NOT NULL
							")->fetchAll();
							foreach($acumula as $acumula_temp){
								$acumula_gua=$acumula_temp['GUA'];
							}
							$acumula2 = $db->query("
							SELECT COUNT(G2.COBERTAPER) AS CONV FROM Guardia AS G2 WHERE G2.COBERTAPER='".$substitucio_profe_id."' AND G2.HORA='".$hora."' AND 
							case cast (strftime('%w',G2.DATA) as integer) when 0 then 'D' when 1 then  'L' when 2 then  'M' when 3 then  'X' when 4 then  'J' when 5 then  'V' when 6 then  'S' else '' end ='".$dia."' AND G2.IDPROFESSOR IS NULL
							")->fetchAll();
							foreach($acumula2 as $acumula2_temp){
								$acumula2_conv=$acumula2_temp['CONV'];
							}
							//-----
						}		
						$horari_gua=$horari['GUA']+$acumula_gua;
						$horari_conv=$horari['CONV']+$acumula2_conv;
						$horari_tot=$horari_gua + $horari_conv;						
						//-----
						$missatgesG.="<b>".$horari_nomprofe." ".$cadena_substitucio."</b>";						
						$missatgesG.="<br>";
						$missatgesG2.="".$horari_nomprofe." ".$cadena_substitucio2;						
						$missatgesG2.=" (".$horari_tot." ".MOSTRAR_CONTROL_TOTAL." ";
						$missatgesG2.="".$horari_gua." ".MOSTRAR_CONTROL_GUARDIES." ";
						$missatgesG2.="".$horari_conv." ".MOSTRAR_CONTROL_CONVIVENCIA.")";
						$missatgesG2.="\n";
						$tamany=5;
						$horari_tot2=$horari_tot * $tamany;
						$horari_gua2=$horari_gua * $tamany;
						$horari_conv2=$horari_conv * $tamany;
						$missatgesG.= "<svg width='".$horari_tot2."' height='22'><rect width='".$horari_tot2."' height='20' style='fill:red;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
						$missatgesG.= "<span class='small'> ".$horari_tot." ".MOSTRAR_CONTROL_TOTAL."</span>";
						$missatgesG.= "<br>";
						$missatgesG.= "<svg width='".$horari_gua2."' height='22'><rect width='".$horari_gua2."' height='20' style='fill:blue;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
						$missatgesG.= "<span class='small'> ".$horari_gua." ".MOSTRAR_CONTROL_GUARDIES."</span>";
						$missatgesG.= "<br>";
						$missatgesG.= "<svg width='".$horari_conv2."' height='22'><rect width='".$horari_conv2."' height='20' style='fill:green;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
						$missatgesG.= "<span class='small'> ".$horari_conv." ".MOSTRAR_CONTROL_CONVIVENCIA."</span>";
						$missatgesG.= "<br>";						
						//-----
						echo "<div style=\"padding:1px;\">";
						echo "<a class=\"btn btn-outline-primary btn-sm\" role=\"button\" aria-disabled=\"true\">".$horari_nomprofe." ".$cadena_substitucio."</a> ";		
						echo "</div>";
					 }
					 //Finestra modal que mostra el control de Guardies fetes (C)
					 if ($missatgesG!=""){
						?>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalG<?=$hora;?>" title="<?=$missatgesG2;?>">C</button>		
						<!-- Modal -->
						<div class="modal fade" id="ModalG<?=$hora;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel"><?=MOSTRAR_CONTROL_TITUL;?></h5>
										<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<?=$missatgesG;?>													
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=MOSTRAR_PROTOCOL_TANCAR;?></button>
									</div>
								</div>
							</div>
						</div>		
					<?php		
	  				}
					//Professorat Reserva
	  				$reserves = $db->select(
      				    'Horari', ['[>]Professor(P1)' => ['IDPROFESSOR' => 'ID']],
      				    array('Horari.ID','Horari.IDPROFESSOR','Horari.DATA','Horari.HORA','Horari.TIPUS','P1.NOM'),
      					array('AND' => array('DATA' => ''.$dia.'', 'HORA'=>''.$hora.'','TIPUS[!]' => ['LEC','G','RDP','ATENCIÓ ALUMNAT','GDIR','FD']), 'ORDER' => array('TIPUS' , 'NOMPROFE'))
      				);
	  				$missatges="";
	  				$missatges2="";
	  				foreach($reserves as $reserva){      
	  				  	$reserva_hora = $reserva['HORA'];
	  				  	$reserva_idprofe = $reserva['IDPROFESSOR'];	  	  
						$reserva_nomprofe = $reserva['NOM'];
						$reserva_tipus = $reserva['TIPUS'];		
	  				  	$missatge="[".$reserva_tipus."] ".$reserva_nomprofe;
						$missatges=$missatges."".$missatge."<br>";
						$missatges2=$missatges2."".$missatge."\n";
	  				}	  	  	  
					//Finestra modal que mostra el protocol de Guardies i reserves (+)
	  				if ($missatges!=""){
						?>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#Modal<?=$hora;?>" title="<?=$missatges2;?>">+</button>		
						<!-- Modal -->
						<div class="modal fade" id="Modal<?=$hora;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel"><?=MOSTRAR_PROTOCOL_TITUL;?></h5>
										<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<?=$missatges;?>
										<?=MOSTRAR_PROTOCOL_TEXT;?>				
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=MOSTRAR_PROTOCOL_TANCAR;?></button>
									</div>
								</div>
							</div>
						</div>		
					<?php		
	  				}

					//--- RESERVES DE AULARI
					$cadena_reserves="";
					$cadena_reserves2="";
					if ($config_mostrar_reserves){
						$reserves=$db->query("SELECT  R.ID, R.IDPROFESSOR, R.DATA,R.HORA,R.AULA, R.OBSERVACIONS,P.NOM FROM Reserves R LEFT JOIN Professor P ON R.IDPROFESSOR=P.ID WHERE DATA='".$data."' AND HORA='".$hora."' ORDER BY  HORA, AULA")->fetchAll();						
						//echo $db->last();
						foreach($reserves as $reserva){      
							$reserva_id = $reserva['ID'];
							$reserva_idprofe = $reserva['IDPROFESSOR'];
							$reserva_profe = $reserva['NOM'];	  	  				
							$reserva_data = $reserva['DATA'];	  	  
							$reserva_hora = $reserva['HORA'];	  	  
							$reserva_aula = $reserva['AULA'];	  	  
							$reserva_observacions = $reserva['OBSERVACIONS'];
							$cadena_reserves.=$reserva_aula." (".$reserva_profe.") ".$reserva_observacions."<br>";							
							$cadena_reserves2.=$reserva_aula." (".$reserva_profe.") ".$reserva_observacions."\n";							
						}						
						if($cadena_reserves!=""){
						?>
						<!-- Button trigger modal -->
						<button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalR<?=$hora;?>" title="<?=$cadena_reserves2;?>">R</button>		
						<!-- Modal -->
						<div class="modal fade" id="ModalR<?=$hora;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel"><?=MOSTRAR_RESERVES_TITUL;?></h5>
										<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<?=$cadena_reserves;?>										
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?=MOSTRAR_RESERVES_TANCAR;?></button>
									</div>
								</div>
							</div>
						</div>														
						<?php
						}
					}

					//--- FI RESERVES

	  				echo "</div>";
	  				echo "</td>";
	  				/* -------------------------- */
					/* ----- COLUMNA3 absencies I CONVIVENCIA ----- */
					/* -------------------------- */
	  				echo "<td>";	  
	  				$absencies = $db->select(
      				    'Guardia',['[>]Professor(P1)' => ['COBERTAPER' => 'ID'],'[>]Professor(P2)' => ['IDPROFESSOR' => 'ID']],
      				    array('Guardia.ID','Guardia.IDPROFESSOR','Guardia.DATA','Guardia.HORA','Guardia.OBSERVACIONS','Guardia.COBERTAPER','Guardia.ACTIVITAT','P1.NOM','P2.NOM(NOM1)'),
      					  array('AND' => array('IDPROFESSOR[!]'=> null, 'DATA' => ''.$data.'', 'HORA'=>''.$hora.''))
      				);	  					  
					foreach($absencies as $absencia){      	    
						$absencia_id = $absencia['ID'];		
					    $absencia_idprofe = $absencia['IDPROFESSOR'];		
						$absencia_idprofe_nom = $absencia['NOM1'];		
						$absencia_observacions = $absencia['OBSERVACIONS'];
						$absencia_activitat = $absencia['ACTIVITAT'];
						$absencia_cobertaper = $absencia['COBERTAPER'];
						$absencia_cobertaper_nom = $absencia['NOM'];			
						//Substitucions
						$substituts = $db->query("SELECT S.*, P.NOM FROM Substitucions S LEFT JOIN Professor P ON  S.SUBSTITUT=P.ID WHERE S.PROFE=".$absencia_idprofe. " AND ('" .$data. "' BETWEEN S.DE AND S.A)" )->fetchAll();
						$cadena_substitucio = "";
						foreach ($substituts as $substitut){
							$substitucio_profe_nom = $substitut['NOM'];		
							$cadena_substitucio = "".$substitucio_profe_nom."";
						}								
						$detalls = $db->select(
    				      	'Horari',
    				      	array('MATERIA','GRUP','AULA','TIPUS'),
    				  	  	array('AND' => array('IDPROFESSOR'=>''.$absencia_idprofe.'','DATA' => ''.$dia.'', 'HORA'=>''.$hora.''))
    				    );
						$cadena_detall="";
						foreach ($detalls as $detall){
						  	$detall_grup = $detall['GRUP'];
						  	$detall_aula = $detall['AULA'];
						  	$detall_materia = $detall['MATERIA'];
						  	$detall_tipus = $detall['TIPUS'];
    				      	if ($detall_tipus=="LEC")	{
								//Afegir les cadenes si té varios grups
								$cadena_detall .= $detall_grup." (".$detall_aula.") [".$detall_materia."]<br>";  
						  	}else{
								$cadena_detall = $detall_tipus."<br>";    
						  	}		  		  
						}
						//Contemplar si té Codocència per indicar-ho -----
						$detalls = $db->select(
				          	'Horari(H)',['[>]Professor(P2)' => ['IDPROFESSOR' => 'ID']],
				          	array('H.IDPROFESSOR','H.MATERIA','H.GRUP','H.AULA','H.TIPUS','P2.NOM'),
				      	  	array('AND' => array('IDPROFESSOR[!]'=>''.$absencia_idprofe.'','DATA' => ''.$dia.'', 'HORA'=>''.$hora.'', 'AULA' => ''.$detall_aula.'','TIPUS'=> 'LEC'))
				        );
						$cadena_codocent="";
						foreach ($detalls as $detall){
							$detall_idprofessor_codocent = $detall['IDPROFESSOR'];
							//Afegir Aula per saber on està el codocent
							$detall_professor_codocent = $detall['NOM']." (".$detall["AULA"].")";
							$cadena_codocent.=$detall_professor_codocent." / ";
						}
						if  ($cadena_substitucio!=""){ 
							$missatge=$absencia_idprofe_nom." <b>[S]</b> ".$cadena_substitucio."<br>";
						}else{
							$missatge=$absencia_idprofe_nom."<br> ";	
						}		
						$missatge=$missatge.$cadena_detall;		
						if  ($cadena_codocent!=""){ $missatge=$missatge." <b>[C]</b> ".$cadena_codocent."";}
						if  ($absencia_activitat!=""){ $missatge=$missatge." <b>[A]</b> ".$absencia_activitat."";}
						if  ($absencia_observacions!=""){ $missatge=$missatge." <b>[N]</b> ".$absencia_observacions."";}		
						//Mirar si té una reserva la persona absent per indicar-ho						
						$reserves = $db->select(
							'Reserves',
							array('IDPROFESSOR','AULA','OBSERVACIONS', 'DATA', 'HORA'),
							array('AND' => array('IDPROFESSOR'=>''.$absencia_idprofe.'','DATA' => ''.$data.'', 'HORA'=>''.$hora.''))
					  	);
						$reserva_observacions="";
					  	foreach ($reserves as $reserva){
						  	$reserva_observacions.=$reserva['AULA']."-".$reserva['OBSERVACIONS'];;
					  	}						
						if  ($reserva_observacions!=""){ $missatge=$missatge." <b>[R]</b> ".$reserva_observacions."";}		
						echo "<div style=\"padding:1px;\">";		
						
						//En roig G LEC, la resta en altre color perquè no cal cobrir i Contar absències
						if($detall_tipus=="LEC"){
							$cadena_tipus_color="danger";
							$contar_absencies=$contar_absencies+1;
						}else{
							$cadena_tipus_color="secondary";
						}												
						
						//Generar Link per associar COBERTAPER però impedir en el PASSAT llevat que sigues ADMIN!
						if ($data >= date("Y-m-d") || $username == $usuari_privilegiat){
							//PRESENT O FUTUR O PRIVILEGIAT
							$cadena_link="href=\"index.php?accio=assigna&data=".$data."&hora=".$hora."&idabsencia=".$absencia_id."\"";
						}else{
							//PASSAT I NO PRIVILEGIAT
							$cadena_link="href=\"#\"";
						}
						echo "<a ".$cadena_link." class=\"btn btn-outline-".$cadena_tipus_color." btn-sm\" role=\"button\" aria-disabled=\"true\">".$missatge."</a> ";		
						if ($absencia_cobertaper!=""){
						  echo " <a  class=\"btn btn-outline-success btn-sm\" role=\"button\" aria-disabled=\"true\">".$absencia_cobertaper_nom."</a>";			
						}
						echo "</div>";				
					}	
	  				//------------- BOTO DE CONVIVENCIA
					$cadena_link_convi="href=index.php?accio=assigna&data=".$data."&hora=".$hora."&idabsencia=0";
	  				echo "<div style=\"padding:1px;\">";
      				if ($hora=="10" || $hora=="R1" || $hora=="R3" || ($hora=="R2" && $dia=="M") || ($hora=="R2" && $dia=="X") || ($hora=="R2" && $dia=="V") ){
						//Els patis no tenen convivència pero L i J sí, perquè tenim alumnes castigats
						//En hora 10 tenim Consergeria en compte de Convivència
						
					}else{
						echo "<a ".$cadena_link_convi." class=\"btn btn-secondary btn-sm\" role=\"button\" aria-disabled=\"true\">".MOSTRAR_CONVIVENCIA."</a>";			  	  
						$convis = $db->select(
							'Guardia',['[>]Professor(P1)' => ['COBERTAPER' => 'ID'],'[>]Professor(P2)' => ['IDPROFESSOR' => 'ID']],
							array('Guardia.ID','Guardia.IDPROFESSOR','Guardia.DATA','Guardia.HORA','Guardia.OBSERVACIONS','Guardia.COBERTAPER','Guardia.ACTIVITAT','P1.NOM','P2.NOM(NOM1)'),
						  array('AND' => array('IDPROFESSOR'=> null, 'DATA' => ''.$data.'', 'HORA'=>''.$hora.''))
						);	  						
					  foreach ($convis as $convi){
						  $convi_cobertaper = $convi['COBERTAPER'];
						  $convi_cobertaper_nom = $convi['NOM'];
						  if ($convi_cobertaper!=""){
							echo " <a class=\"btn btn-outline-success btn-sm\" role=\"button\" aria-disabled=\"true\">".$convi_cobertaper_nom."</a>";			
						  }	 
					  }		
					}
	  				//------------- BOTONS DE PATIS							
      				if ($hora=="R1"){
						for ($u=-1;$u>=-6;$u--){							
							echo "<div style=\"padding:1px;\">";
							$cadena_link_pati="href=index.php?accio=assigna&data=".$data."&hora=".$hora."&idabsencia=".$u;							
							switch ($u){
								case "-1":$u_extra=MOSTRAR_PATI_1;break;
								case "-2":$u_extra=MOSTRAR_PATI_2;break;
								case "-3":$u_extra=MOSTRAR_PATI_3;break;
								case "-4":$u_extra=MOSTRAR_PATI_4;break;
								case "-5":$u_extra=MOSTRAR_PATI_5;break;
								case "-6":$u_extra=MOSTRAR_PATI_6;break;
							}
							$textpati="".$u_extra;

							echo "<a ".$cadena_link_pati." class=\"btn btn-secondary btn-sm\" role=\"button\" aria-disabled=\"true\">".$textpati."</a>";
							$patis = $db->select(
								'Guardia',['[>]Professor(P1)' => ['COBERTAPER' => 'ID'],'[>]Professor(P2)' => ['IDPROFESSOR' => 'ID']],
								array('Guardia.ID','Guardia.IDPROFESSOR','Guardia.DATA','Guardia.HORA','Guardia.OBSERVACIONS','Guardia.COBERTAPER','Guardia.ACTIVITAT','P1.NOM','P2.NOM(NOM1)'),
							  array('AND' => array('ACTIVITAT'=>''.$u.'', 'DATA' => ''.$data.'', 'HORA'=>''.$hora.''))
							);	  							
						  foreach ($patis as $patis_element){
							$patis_cobertaper = $patis_element['COBERTAPER'];
							$patis_cobertaper_nom = $patis_element['NOM'];
							if ($patis_cobertaper!=""){
							  echo " <a class=\"btn btn-outline-success btn-sm\" role=\"button\" aria-disabled=\"true\">".$patis_cobertaper_nom."</a>";			
							}	 
						  }								
							echo "</div>";
						}						
					  }		
	  				//--------------
					//------------- BOTO DE CONSERGERIA							
      				if ($hora=="10"){
						for ($u=-7;$u>=-7;$u--){							
							echo "<div style=\"padding:1px;\">";
							$cadena_link_pati="href=index.php?accio=assigna&data=".$data."&hora=".$hora."&idabsencia=".$u;							
							switch ($u){
								case "-7":$u_extra=MOSTRAR_PATI_7;break;
							}
							$textpati="".$u_extra;

							echo "<a ".$cadena_link_pati." class=\"btn btn-secondary btn-sm\" role=\"button\" aria-disabled=\"true\">".$textpati."</a>";
							$consergeria = $db->select(
								'Guardia',['[>]Professor(P1)' => ['COBERTAPER' => 'ID'],'[>]Professor(P2)' => ['IDPROFESSOR' => 'ID']],
								array('Guardia.ID','Guardia.IDPROFESSOR','Guardia.DATA','Guardia.HORA','Guardia.OBSERVACIONS','Guardia.COBERTAPER','Guardia.ACTIVITAT','P1.NOM','P2.NOM(NOM1)'),
							  array('AND' => array('ACTIVITAT'=>''.$u.'', 'DATA' => ''.$data.'', 'HORA'=>''.$hora.''))
							);	  							
						  foreach ($consergeria as $patis_element){
							$patis_cobertaper = $patis_element['COBERTAPER'];
							$patis_cobertaper_nom = $patis_element['NOM'];
							if ($patis_cobertaper!=""){
							  echo " <a class=\"btn btn-outline-success btn-sm\" role=\"button\" aria-disabled=\"true\">".$patis_cobertaper_nom."</a>";			
							}	 
						  }								
							echo "</div>";
						}						
					  }		
	  				//--------------					
					
					echo "</div></td>";
	   				/* -------------------------- */
					/* ----- COLUMNA4 NOTES ----- */
					/* -------------------------- */
	  				echo "<td>";
					echo "<div>";
					$notes = $db->select('Notes(N)',array('N.ID','N.NOTES'),array('AND' => array('DATA' => ''.$data.'', 'HORA'=>''.$hora.'')));	  
					$cadena_notes="";
					foreach ($notes as $nota){
						$nota_id = $nota['ID'];
						$nota_notes = $nota['NOTES'];
						$cadena_notes=$cadena_notes.$nota_notes;
					}	
					if ($cadena_notes==""){
						echo "<a href=\"index.php?data=".$data."&hora=".$hora."&accio=notes\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\">+</a>";				
					}else{
	   					$cadena_notes= nl2br($cadena_notes);
						echo "<a href=\"index.php?data=".$data."&hora=".$hora."&accio=notes\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\">".$cadena_notes."</a>";				
					}
	  				echo "</div></td>";
	 				/* -------------------------- */
					/* ----- COLUMNA5 COLORS ----- */
					/* -------------------------- */
	 				$resultat=$contar_guardies-$contar_absencies;	
					$color="#00C851";
					if ($resultat < 0 && $contar_absencies>0){$color="#ff4444";}	// No podem cobrir absències
					if ($resultat == 0 && $contar_absencies>0){$color="#ffbb33";}	// Podem cobrir absències 
					if ($resultat > 0 && $contar_absencies>0){$color="#33b5e5";}	// Podem cobrir absències i sobra professorat de G
					if ($resultat > 0 && $contar_absencies==0){$color="#00C851";} 	// No tenim absències										
					if ($config_semafor==true){
						echo "<td><svg height='20' width='20'><circle cx='10' cy='10' r='8' stroke='black' stroke-width='1' fill='".$color."'></svg><div></div></td>"; 
					}else{
						echo "<td style='background-color: ".$color."'><div></div></td>";
					}					
					/* -------------------------- */
					/*----- CONFIGURAR EN 2 COLUMNES -----*/
					/* -------------------------- */
					if ($hora == "7" && $config_columnes == true){
						?>
									</tbody>
								</table>
							</div>
						    <div class="col">
						    	<table class="table table-sm table-bordered table-striped">
						      		<thead>
						        		<tr>
											<th class="col-1" scope="col"><?=MOSTRAR_TH_1;?></th>
  			    							<th class="col-3" scope="col"><?=MOSTRAR_TH_2;?></th>
  			    							<th class="col-4" scope="col"><?=MOSTRAR_TH_3;?></th>
  			    							<th class="col-4" scope="col"><?=MOSTRAR_TH_4;?></th>
				  							<th class="col-1" scope="col"><?=MOSTRAR_TH_5;?></th>											
								        </tr>
								    </thead>
								<tbody>	
						<?php
					}
				}
				?>  
  			</tbody>
		</table>
	</div>
</div>	

<?php
//Si estem en la fulla d'avui, fem refresc cada cert temps. La variable es gestiona en index.php
if ($refresca_script){ 
	?>
	<script>
		function timedRefresh(timeoutPeriod) {setTimeout("window.location.assign('index.php?data=&accio=mostrar<?=$refresca_vesprada;?>');",timeoutPeriod);}
		window.onload = timedRefresh(60000);
	</script>
	<?php
}
?>