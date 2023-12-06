<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
//Filtros
$filtro="";
$filtro_text="";
$filtro_aula = $_GET['filtro_aula'];
if($filtro_aula!=""){
	$filtro=" WHERE R.AULA='".$filtro_aula."' ";
	$filtro_text=" (".$filtro_aula.") ";
	$filtro_text.="<a href=\"index.php?accio=reserves_llista_completa\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\">X</a> ";
}
$filtro_profe=$_GET['filtro_profe'];
if($filtro_profe!=""){
	$filtro=" WHERE P.NOM='".$filtro_profe."' ";
	$filtro_text=" (".$filtro_profe.") ";	
	$filtro_text.="<a href=\"index.php?accio=reserves_llista_completa\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\">X</a> ";
}
?>			
<div class="container-fluid">     
	<h4><?=RESERVES_LLISTA_TITUL;?><?=$filtro_text;?></h4>
	<table class="table table-sm table-bordered table-striped">
		<thead>
			<tr>
			<th class="col-1" scope="col"><?=RESERVES_TH_1;?></th>
			<th class="col-2" scope="col"><?=RESERVES_TH_2;?></th>
			<th class="col-1" scope="col"><?=RESERVES_TH_3;?></th>
			<th class="col-1" scope="col"><?=RESERVES_TH_4;?></th>
			<th class="col-2" scope="col"><?=RESERVES_TH_6;?></th>
            <th class="col-3" scope="col"><?=RESERVES_TH_7;?></th>			
			<?php 
			if ($username==$usuari_privilegiat){
				?>
            	<th class="col-1" scope="col"><?=RESERVES_TH_8;?></th>
				<?php 
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
			//Consulta
			$reserves=$db->query("
			SELECT  R.ID, R.IDPROFESSOR, R.DATA,R.HORA,R.AULA, R.OBSERVACIONS,P.NOM,".$horasql." FROM Reserves R LEFT JOIN Professor P ON R.IDPROFESSOR=P.ID ".$filtro." ORDER BY  DATA, HORAREAL, AULA")->fetchAll();									
			foreach($reserves as $reserva){      
				$reserva_id = $reserva['ID'];
				$reserva_idprofe = $reserva['IDPROFESSOR'];
				$reserva_profe = $reserva['NOM'];	  	  				
				$reserva_data = $reserva['DATA'];	  	  
				$reserva_hora = $reserva['HORA'];	  	  
                $reserva_aula = $reserva['AULA'];	  	  
                $reserva_observacions = $reserva['OBSERVACIONS'];
				echo "<tr>";
				echo "<td>".$reserva_id."</td>";
				echo "<td>";
				echo "<a href=\"index.php?accio=reserves_llista_completa&filtro_aula=".$reserva_aula."\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\">F</a> ";
				echo $reserva_aula;
				echo"</td>";
				echo "<td>".$reserva_data."</td>";
				echo "<td>".$config_hores[$reserva_hora]."</td>";                
                echo "<td>";				
				echo "<a href=\"index.php?accio=reserves_llista_completa&filtro_profe=".$reserva_profe."\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\">F</a> ";
				echo $reserva_profe;
				echo "</td>";				
                echo "<td>".$reserva_observacions."</td>";
				if ($username==$usuari_privilegiat){
					echo "<td>";
					echo "<a href=\"index.php?accio=reserves_elimina&id=".$reserva_id."\" class=\"btn btn-outline-danger btn-sm\" role=\"button\" aria-disabled=\"true\">".RESERVES_ELIMINA."</a>";
					echo "</td>";
				}
				echo "</tr>";
			}
			?>
		</tbody>
	</table>
</div>