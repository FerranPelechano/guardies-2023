<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<div class="container-fluid">     
	<h4><?=CONTROL_ACTES_TITUL;?> (<?=$data?>)</h4>   
    <div class="row align-items-start">
    	<div class="col">
    		<table class="table table-sm table-bordered table-striped small">
      			<tbody>	
                    <?php
                    //Consulta general d'horari
                    $grups=$db->query("SELECT DISTINCT H.IDPROFESSOR, H.MATERIA, H.GRUP,P.NOM FROM Horari H LEFT JOIN Professor P ON H.IDPROFESSOR=P.ID WHERE NOT (H.GRUP IS  NULL OR H.GRUP='') ORDER BY H.GRUP, P.NOM, H.MATERIA")->fetchAll();						
                    //echo $db->last()."<br>";                                        
                    $grup_actiu="";
                    $profe_actiu="";
                    foreach ($grups as $grup){	
                        $grup_profe=$grup['NOM'];
                        $grup_materia=$grup['MATERIA'];
                        $grup_grup=$grup['GRUP'];                              
                        if($grup_grup<>$grup_actiu){
                            echo "<tr>";
                            echo "<td><b>".$grup_grup."</b></td>";
                            echo "<td><b>".$grup_grup."</b></td>";
                            echo "<td><b>".$grup_grup."</b></td>";
                            echo "<td><b>".$grup_grup."</b></td>";
                            echo "<td><b>".$grup_grup."</b></td>";
                            echo "</tr>";
                            $grup_actiu = $grup_grup;
                        }
                        $hores="";
                        $query_hores="SELECT COUNT(H.IDPROFESSOR) AS HTOTAL FROM Horari H LEFT JOIN Professor P ON H.IDPROFESSOR=P.ID WHERE (H.IDPROFESSOR='".$grup['IDPROFESSOR']."' AND  H.GRUP='".$grup['GRUP']."' AND H.MATERIA='".$grup['MATERIA']."') ";
                        $hores_totals=$db->query($query_hores)->fetchAll();
                        //echo $db->last()."<br>";
                        foreach ($hores_totals as $hores_tot){	              
                            $hores=$hores_tot['HTOTAL'];                        
                        }
                        //echo ">".$hores."<<br>";
                        
                        echo "<tr>";                        
                        echo "<td class=\"col-1\" scope=\"col\">".$grup_grup."</td>";                        
                        if($grup_profe<>$profe_actiu){
                            echo "<td class=\"col-1\" scope=\"col\">".$grup_profe."</td>";
                            $profe_actiu = $grup_profe;
                        }else{
                            echo "<td class=\"col-1\" scope=\"col\">+ ".$grup_profe."</td>";
                        }                        
                        echo "<td class=\"col-1\" scope=\"col\">".$grup_materia."</td>";                        
                        echo "<td class=\"col-1\" scope=\"col\">".$hores."</td>";                        
                        echo "<td class=\"col-1\" scope=\"col\">&#x2610;</td>"; 
                        echo "</tr>";                                                
                    }

                    ?>
                </tbody>
            </table>



        </div>
    </div>
</div>