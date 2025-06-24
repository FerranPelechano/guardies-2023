<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$FGrup = $_POST['selectGrup'];
if ($FGrup==""){$FGrup="¿?";}
?>
<div class="container-fluid">     
	<h4><?=AULES_TITUL;?></h4>
    <p><?=AULES_DESC;?></p>
</div>
<div class="container-fluid">     	
	<table class="table table-sm table-bordered table-striped">
		<thead>
			<tr>
			<th class="col-2" scope="col"><?=EDOCENT_HORA;?></th>
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
                    //$query="SELECT DISTINCT(AULA) FROM Horari AS H WHERE H.DATA = '$dia_setmana' AND H.HORA = '$hora' ORDER BY H.AULA";
                    //$query="SELECT DISTINCT(H.AULA),(SELECT COUNT(R.AULA) FROM Reserves AS R WHERE R.AULA=H.AULA AND R.DATA >= '".date("Y-m-d")."') AS CONTEO_RESERVES FROM Horari AS H WHERE H.AULA IS NOT NULL AND H.AULA<>'' AND H.DATA <> '$dia_setmana' AND H.HORA <> '$hora' ORDER BY H.AULA";
                    $query="SELECT DISTINCT(H.AULA),COUNT(H2.ID) AS CONTEO_OCUPACIO,(SELECT COUNT(R.AULA) FROM Reserves AS R WHERE R.AULA=H.AULA AND R.DATA >= '".date("Y-m-d")."') AS CONTEO_RESERVES FROM Horari AS H LEFT JOIN Horari AS H2 ON H.AULA=H2.AULA AND H2.DATA = '$dia_setmana' AND H2.HORA = '$hora' WHERE H.AULA IS NOT NULL AND H.AULA<>''GROUP BY H.AULA ORDER BY H.AULA";
                    $Qhorari = $db->query($query)->fetchAll();
                    //echo $db->last()."<br>";                    					
                    $aux="";			  	
					foreach($Qhorari as $temp){                                                
                        //$aux.=$temp['AULA']." ".$temp['CONTEO_OCUPACIO']." ".$temp['CONTEO_RESERVES']." -- ";            
                        if($temp['CONTEO_OCUPACIO']==0) {             
                            //$aux.=$temp['AULA'];      
                            if($temp['CONTEO_RESERVES']>0) {   
                                $aux.=" <a href='index.php?&accio=reserves_llista&filtro_aula=".$temp['AULA']."'>";
                                $aux .="<button type=\"button\" class=\"btn btn-outline-danger btn-sm\" title=\"".$temp['CONTEO_RESERVES']."\">".$temp['AULA']." (".AULES_RESERVADA.")</button>";                            
                                $aux.="</a>";
                            }else{
                                $aux.=" <a href='index.php?&accio=reserves&data=".date("Y-m-d")."&selectAula=".$temp['AULA']."'>";
                                $aux .="<button type=\"button\" class=\"btn btn-outline-secondary btn-sm\" title=\"".$temp['AULA']."\">".$temp['AULA']."</button>";                            
                                $aux.="</a>";
                            }
                            $aux.="";
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