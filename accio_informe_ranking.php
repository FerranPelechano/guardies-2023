<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<div class="col-12 px-4">
	<?php
	/* ----- INFORME RANKING ----- */  
	echo "<h4>".INFORME_RANKING_TOTALS."</h4>";						            
	$rankings=$db->query("select P.ID, P.NOM, G.ID GID,count(G.ID) TOT, count (G.IDPROFESSOR) GUA, (select count(G2.IDPROFESSOR) from Guardia G2  where  G2.DATA < '".$data."' ) ABS FROM Professor P left join Guardia G on G.COBERTAPER=P.ID")->fetchAll();            
	foreach ($rankings as $ranking){
		$ranking_gua = $ranking['GUA'];		
		$ranking_tot = $ranking['TOT'];		                
		$ranking_abs = $ranking['ABS'];
		$ranking_con = $ranking_tot - $ranking_gua;								
		$ranking_percent_gua = round(100 * $ranking_gua / $ranking_tot);
		$ranking_percent_con= round(100 * $ranking_con / $ranking_tot);
		$tamany=0.5;
		$tamany_gua = $tamany * $ranking_gua;
		$tamany_con = $tamany * $ranking_con;
		$tamany_abs = $tamany * $ranking_abs;
		$ranking_gua_text = $ranking_gua;
		$ranking_con_text = $ranking_con;
		$ranking_abs_text = $ranking_abs;
		echo " <svg width='".$tamany_gua."' height='22'><rect width='".$tamany_gua."' height='20' style='fill:blue;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
		echo " <span class='small'> ".$ranking_gua_text." ".INFORME_RANK_TH_3."</span>";
		echo " <br>";
		echo " <svg width='".$tamany_con."' height='22'><rect width='".$tamany_con."' height='20' style='fill:green;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
		echo " <span class='small'> ".$ranking_con_text." ".INFORME_RANK_TH_4."</span>";
		echo " <br>";
		echo " <svg width='".$tamany_abs."' height='22'><rect width='".$tamany_abs."' height='20' style='fill:red;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
		echo " <span class='small'> ".$ranking_abs_text." ".INFORME_RANK_TH_6."</span>";
		echo " <br>";
	}
	?>
	<table class="table table-sm table-bordered table-striped">
  		<thead>
    		<tr>
	  			<th class="col-2" scope="col"><?=INFORME_RANK_TH_1;?></th>
	  			<th class="col-1" scope="col"><?=INFORME_RANK_TH_2;?></th>
	  			<th class="col-1" scope="col"><?=INFORME_RANK_TH_3;?></th>
	  			<th class="col-1" scope="col"><?=INFORME_RANK_TH_4;?></th>
                <th class="col-1" scope="col"><?=INFORME_RANK_TH_6;?></th>
				<th class="col-1" scope="col"><?=INFORME_RANK_TH_7;?></th>
				<th class="col-1" scope="col"><?=INFORME_RANK_TH_8;?></th>
				<th class="col-4" scope="col"><?=INFORME_RANK_TH_5;?></th>
		    </tr>
  		</thead>
  		<tbody>	  
			<?php	
			/* ----- INFORME RANKING ----- */  
			echo "<h4>".INFORME_RANKING."</h4>";						            
			$rankings=$db->query("select P.ID, P.NOM, G.ID GID,count(G.ID) TOT, count (G.IDPROFESSOR) GUA, (select count(G2.IDPROFESSOR) from Guardia G2  where G2.IDPROFESSOR=P.ID AND G2.DATA <= '".$data."' group by G2.IDPROFESSOR) ABS, (select count(DISTINCT G2.DATA) from Guardia G2  where G2.ACTIVITAT LIKE '[PF]%' AND G2.IDPROFESSOR= P.ID GROUP BY G2.IDPROFESSOR) PF, (select count(DISTINCT G2.DATA) from Guardia G2  where G2.ACTIVITAT LIKE '[A5]%' AND G2.IDPROFESSOR= P.ID GROUP BY G2.IDPROFESSOR) AN FROM Professor P left join Guardia G on G.COBERTAPER=P.ID GROUP BY P.ID ORDER BY P.NOM")->fetchAll();            
			//$rankings=$db->query("select P.ID, P.NOM, G.ID GID,count(G.ID) TOT, count (G.IDPROFESSOR) GUA, (select count(G2.IDPROFESSOR) from Guardia G2  where G2.IDPROFESSOR=P.ID AND G2.DATA < '".$data."' group by G2.IDPROFESSOR) ABS, (select count(DISTINCT G2.DATA) from Guardia G2  where G2.ACTIVITAT LIKE '[PF]%' AND G2.IDPROFESSOR= P.ID GROUP BY G2.IDPROFESSOR) PF FROM Professor P left join Guardia G on G.COBERTAPER=P.ID GROUP BY P.ID ORDER BY P.NOM")->fetchAll();            
			//$rankings=$db->query("select P.ID, P.NOM, G.ID GID,count(G.ID) TOT, count (G.IDPROFESSOR) GUA, (select count(G2.IDPROFESSOR) from Guardia G2  where G2.IDPROFESSOR=P.ID AND G2.DATA < '".$data."' group by G2.IDPROFESSOR) ABS, (select count(DISTINCT G2.DATA) from Guardia G2  where G2.ACTIVITAT LIKE '[PF]%' AND G2.IDPROFESSOR= P.ID AND G2.DATA < '".$data."' GROUP BY G2.IDPROFESSOR) PF FROM Professor P left join Guardia G on G.COBERTAPER=P.ID GROUP BY P.ID ORDER BY P.NOM")->fetchAll();            
			//echo $db->last()."<br>";				
			foreach ($rankings as $ranking){
				$ranking_id= $ranking['ID'];
				$pfdies=$db->query("select DISTINCT G.DATA, G.ACTIVITAT from Guardia G  where G.ACTIVITAT LIKE '[PF]%' AND G.IDPROFESSOR= '".$ranking_id."' ORDER BY G.DATA")->fetchAll();            				
				//echo $db->last()."<br>";
				//print_r($pfdies)."<br>";
				$cadena_pfdies="";				
				$cadena_pfdies_alt="";
				foreach ($pfdies as $pfdia){					
					$cad_data=$pfdia['DATA'];
					$cad_act=$pfdia['ACTIVITAT'];
					$cadena_pfdies.=$cad_data." ".$cad_act."<br>";
					$cadena_pfdies_alt.=$cad_data." ".$cad_act."\n";
				}
				$a5dies=$db->query("select DISTINCT G.DATA, G.ACTIVITAT from Guardia G  where G.ACTIVITAT LIKE '[A5]%' AND G.IDPROFESSOR= '".$ranking_id."' ORDER BY G.DATA")->fetchAll();            
				//echo $db->last()."<br>";
				//print_r($a5dies)."<br>";
				$cadena_a5dies="";
				$cadena_a5dies_alt="";
				foreach ($a5dies as $a5dia){					
					$cad_data_a5=$a5dia['DATA'];
					$cad_act_a5=$a5dia['ACTIVITAT'];
					$cadena_a5dies.=$cad_data_a5." ".$cad_act_a5."<br>";
					$cadena_a5dies_alt.=$cad_data_a5." ".$cad_act_a5."\n";
				}
				$ranking_nom= $ranking['NOM'];		
			    $ranking_gua = $ranking['GUA'];		
				$ranking_tot = $ranking['TOT'];		                
                $ranking_abs = $ranking['ABS'];
				$ranking_pf = $ranking['PF'];
				$ranking_a5 = $ranking['AN'];
				$ranking_con = $ranking_tot - $ranking_gua;								
                if($ranking_tot==0){
					$ranking_percent_gua =0;
					$ranking_percent_con =0;
					}else{
					$ranking_percent_gua = round(100 * $ranking_gua / $ranking_tot);
					$ranking_percent_con= round(100 * $ranking_con / $ranking_tot);
				}				
				echo "<tr>";
				echo "<td>".$ranking_nom."</td>";	    
				echo "<td>".$ranking_tot."</td>";                
				echo "<td>".$ranking_gua." (".$ranking_percent_gua."%)</td>";
				echo "<td>".$ranking_con." (".$ranking_percent_con."%)</td>";
                echo "<td>".$ranking_abs."</td>";                
				echo "<td>".$ranking_pf;                
				if ($cadena_pfdies!=""){
					?>
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#Modal<?=$ranking_id;?>" title="<?=$cadena_pfdies_alt;?>">+</button>		
					<!-- Modal -->
					<div class="modal fade" id="Modal<?=$ranking_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel"><?=RANKING_MODAL_TITUL;?></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<b><?=$ranking_nom;?></b><br>
									<?=$cadena_pfdies;?>				
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal"><?=RANKING_MODAL_TANCAR;?></button>
								</div>
							</div>
						</div>
					</div>		
				<?php		
				  }

  			    echo "</td>";
				
				echo "<td>".$ranking_a5;                
				if ($cadena_a5dies!=""){
				 ?>
				 <!-- Button trigger modal -->
				 <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#Modal-<?=$ranking_id;?>" title="<?=$cadena_a5dies_alt;?>">+</button>		
				 <!-- Modal -->
				 <div class="modal fade" id="Modal-<?=$ranking_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					  <div class="modal-content">
						  <div class="modal-header">
							  <h5 class="modal-title" id="exampleModalLabel"><?=RANKING_MODAL2_TITUL;?></h5>
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
							  </button>
						  </div>
						  <div class="modal-body">
							  <b><?=$ranking_nom;?></b><br>
							  <?=$cadena_a5dies;?>				
						  </div>
						  <div class="modal-footer">
							  <button type="button" class="btn btn-secondary" data-dismiss="modal"><?=RANKING_MODAL_TANCAR;?></button>
						  </div>
					  </div>
				  </div>
				 </div>		
				<?php	
				}					
  				echo "</td>";				
				$tamany=5;
                $tamany_gua = $tamany * $ranking_gua;
                $tamany_con = $tamany * $ranking_con;
                $tamany_abs = $tamany * $ranking_abs;				
                $ranking_gua_text = $ranking_gua;
                $ranking_con_text = $ranking_con;
                $ranking_abs_text = $ranking_abs;
                echo "<td>";
				//echo "<br>".$tamany_gua." ".$tamany_con." ".$tamany_abs."<br>";
                echo "<svg width='".$tamany_gua."' height='22'><rect width='".$tamany_gua."' height='20' style='fill:blue;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
                echo "<span class='small'> ".$ranking_gua_text."</span>";
                echo "<br>";
                echo "<svg width='".$tamany_con."' height='22'><rect width='".$tamany_con."' height='20' style='fill:green;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
                echo "<span class='small'> ".$ranking_con_text."</span>";
                echo "<br>";
                echo "<svg width='".$tamany_abs."' height='22'><rect width='".$tamany_abs."' height='20' style='fill:red;stroke-width:1;stroke:rgb(0,0,0)' /></svg>";
                echo "<span class='small'> ".$ranking_abs_text."</span>";
                echo "</td>";
				echo "</tr>";		
			}	      
  			?>
  		</tbody> 
	</table>  
</div>