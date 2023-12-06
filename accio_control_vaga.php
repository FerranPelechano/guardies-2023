<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<div class="container-fluid">     
	<h4><?=CONTROL_VAGA_TITUL;?> (<?=$data?>)</h4>   
    <div class="row align-items-start">
    	<div class="col">
    		<table class="table table-sm table-bordered table-striped small">
      			<thead>
      				<tr>
                        <?php
                        echo "<th scope=\"col\">#</th>";
                        foreach ($config_intervals as $hora){	
      			    	    echo "<th scope=\"col\">".$config_hores[$hora]."</th>";
                        }
                        ?>
      			  	</tr>                    
      			</thead>
      			<tbody>	
                    <?php
                    //Construir CASE per poder ordenar per HORA
                    $horasql=" CASE ";
                    for ($i=0;$i<count($config_intervals);$i++){
                    	$horasql.=" WHEN HORA='".$config_intervals[$i]."' THEN '".$config_intervals_hores[$i]."'";
                    }
                    $horasql.=" ELSE '' END AS HORAREAL ";
                    //Consulta general d'horari
                    $sessions=$db->query("SELECT H.*,P.*,".$horasql." FROM Horari H LEFT JOIN Professor P ON H.IDPROFESSOR=P.ID WHERE H.DATA='".dia_actual($data)."' AND H.IDPROFESSOR IS NOT NULL ORDER BY P.NOM, HORAREAL")->fetchAll();						
                    //echo $db->last()."<br>";
                    $profe_actual=0;
                    $profenom_actual="";
                    $fila_docent=[];
                    $i=0;
                    foreach ($sessions as $sessio){	
                        $sessio_profe=$sessio['IDPROFESSOR'];
                        $sessio_profenom=$sessio['NOM'];
                        $sessio_hora=$sessio['HORA'];
                        $sessio_horareal=$sessio['HORAREAL'];        
                        $sessio_cadena=$sessio['TIPUS']."<br>".$sessio['MATERIA']."<br>".$sessio['GRUP']."<br>".$sessio['AULA'];
                        

                        //Construir Taula
                        if ($sessio_profe != $profe_actual){
                            
                            //Comprovar si té substitució en vigor
                            $substituts = $db->query("SELECT S.*, P.NOM FROM Substitucions S LEFT JOIN Professor P ON  S.SUBSTITUT=P.ID WHERE S.PROFE=".$sessio_profe. " AND ('" .$data. "' BETWEEN S.DE AND S.A)" )->fetchAll();
                            //echo $db->last()."<br>";
						    $cadena_substitucio = "";
						    foreach ($substituts as $substitut){
						    	$substitucio_profe_id = $substitut['SUBSTITUT'];		
						    	$substitucio_profe_nom = $substitut['NOM'];									
						    	$cadena_substitucio = " <b>[S]</b> ".$substitucio_profe_nom."";
                            }                        
                            $i++;
                            if($i % $config_paginacio_control_diari == 0){
                                //Repetir encapçalat
                                echo "<th scope=\"col\">#</th>";
                                foreach ($config_intervals as $hora){	
                                      echo "<th scope=\"col\">".$config_hores[$hora]."</th>";
                                }
                            }
                            
                            //Dades
                            echo "<tr>";                            
                            echo "<td scope=\"col\">".$profenom_actual."</td>";
                            foreach ($config_intervals as $hora){	
                                if($fila_docent[$hora]!=""){
                                    $destaca="style='background-color: #fcf8e3;'";
                                }else{
                                    $destaca="";
                                }

                                echo "<td scope=\"col\" ".$destaca." >".$fila_docent[$hora]."</td>";
                            }
                            echo "</tr>";
                            $profe_actual=$sessio_profe;
                            $profenom_actual=$sessio_profenom." ".$cadena_substitucio;
                            $fila_docent=[];
                        }
                        //Construir fila de docent                            
                        $fila_docent[$sessio_hora]=$sessio_cadena;
                    }
                    //Escriure l'últim registre
                    echo "<tr>";
                    echo "<td scope=\"col\">".$profenom_actual." ".$cadena_substitucio."</td>";
                    foreach ($config_intervals as $hora){	
                        if($fila_docent[$hora]!=""){
                            $destaca="style='background-color: #fcf8e3;'";
                        }else{
                            $destaca="";
                        }                        
                        echo "<td scope=\"col\" ".$destaca." >".$fila_docent[$hora]."</td>";
                    }
                    echo "</tr>";                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>