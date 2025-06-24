<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
//Filtros
$filtro="";
$filtro_text="";
$filtro_profe=$_GET['filtro_profe'];
if($filtro_profe!=""){
	$filtro=" WHERE C.IDPROFESSOR='".$filtro_profe."' ";
	$filtro_text=" (".$filtro_profe.") ";	
	$filtro_text.="<a href=\"index.php?accio=control_llista\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\">X</a> ";
}
$filtro_data=$_GET['filtro_data'];
if($filtro_data!=""){
	$filtro=" WHERE C.IDPROFESSOR='".$filtro_profe."' AND C.DATA='".$filtro_data."'";
	$filtro_text=" (".$filtro_profe." ".$filtro_data.") ";	
	$filtro_text.="<a href=\"index.php?accio=control_llista\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\">X</a> ";
}

?>			
<div class="container-fluid">     
	<h4><?=INDEX_CONTROL_LLISTA;?><?=$filtro_text;?></h4>
	<table class="table table-sm table-bordered table-striped">
		<thead>
			<tr>
			<th class="col-1" scope="col"><?=CONTROL_TH_1;?></th>
			<th class="col-1" scope="col"><?=CONTROL_TH_2;?></th>
			<th class="col-3" scope="col"><?=CONTROL_TH_3;?></th>
			<th class="col-1" scope="col"><?=CONTROL_TH_4;?></th>
            <th class="col-1" scope="col"><?=CONTROL_TH_5;?></th>
			<th class="col-1" scope="col"><?=CONTROL_TH_6;?></th>						
            <th class="col-2" scope="col"><?=CONTROL_TH_7;?></th>						
			<?php 
			if ($username==$usuari_privilegiat){
				?>
            	<th class="col-1" scope="col"><?=CONTROL_TH_8;?></th>
				<?php 
				}
			?>
        </tr>
		</thead>
		<tbody>	
			<?php
			//Consulta			
            $controls=$db->query("SELECT  C.*, P.NOM FROM Control C LEFT JOIN Professor P ON C.IDPROFESSOR=P.ID ".$filtro." ORDER BY  DATA, HORA")->fetchAll();						
			//echo $db->last();
            foreach($controls as $control){      
				$control_id = $control['ID'];
                $control_tipo = $control['TIPO'];
                $control_idprofessor = $control['IDPROFESSOR'];
                $control_professor = $control['NOM'];
                $control_data = $control['DATA'];
                $control_hora = $control['HORA'];
                $control_ubicacio = $control['UBICACIO'];
                $control_lat = $control['LATITUD'];
                $control_lon = $control['LONGITUD'];
                if(($control_lat == "0" && $control_lon=="0") || ($control_lat == "" && $control_lon=="")){
                    $ubicacio="";
                }else{                    
                    $ubicacio="<a href=\"https://www.google.es/maps/place/".$control_lat.",".$control_lon."\" target=\"_blank\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\" title=\"".$control_ubicacio."\">MAP</a> ";
                    
                }
                $control_dh_app = $control['DATAHORA_CODI_APP'];  // Ultim canvi de codi en APP "DATA HORA"
                if($control_dh_app != ""){
                    $dh_app="<a href=\"#\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\" title=\"".$control_dh_app."\">APP</a> ";
                }else{
                    $dh_app="";
                }
                
                $control_dh_qr = $control['DATAHORA_QR_GENERAT'];  // Ultim canvi de QR en APP "DATA HORA"
                if($control_dh_qr != ""){
                    $dh_qr="<a href=\"#\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\" title=\"".$control_dh_app."\">QR</a> ";
                }else{
                    $dh_qr="";
                }
                //Calcular el temps que té en horari eixe dia
                $temps=$db->query("SELECT  DISTINCT H.HORA FROM Horari H  WHERE H.IDPROFESSOR=".$control_idprofessor." AND H.DATA='".dia_actual($control_data)."'")->fetchAll();						
                //echo $db->last()."<br>";
                $temps_horari=0;
                
                foreach($temps as $temp){
                    $temp_valor=$temp['HORA'];
                    $temps_horari=$temps_horari+$config_temps[$temp_valor];
                }
                //Calcular el temps que ha fitxat eixe dia
                $temps=$db->query("SELECT  C.* FROM Control C  WHERE C.IDPROFESSOR=".$control_idprofessor." AND C.DATA='".$control_data."' ORDER BY C.HORA")->fetchAll();						
                //echo $db->last()."<br>";
                $temps_acumulat=0;
                $t_in="";
                $t_out="";
                foreach($temps as $temp){
                    $temp_tipus=$temp['TIPO'];
                    $temp_hora=$temp['HORA'];
                    //echo $temp_tipus." ".$temp_hora."<br>";
                    if ($temp_tipus=="IN"){$t_in = $temp_hora;}
                    if ($temp_tipus=="OUT" && $t_in!=""){$t_out = $temp_hora;}                    
                    if ($t_in != "" && $t_out != ""){
                       //echo "Mostrar ->".$t_out." - ".$t_in." = ".strtotime($t_out)." - ".strtotime($t_in)." = ".(strtotime($t_out)-strtotime($t_in))."<br>";                        
                        $temps_acumulat=number_format($temps_acumulat+((strtotime($t_out)-strtotime($t_in))/60),2);
                        $t_in="";
                        $t_out="";
                    }                    
                }
                $temps_total=number_format($temps_acumulat-$temps_horari,2);
                if($temps_total >= 0){
                    //Control Horari per dalt dels minuts que havies de treballar
                    $temps_estil="text-success";
                }else{
                    //Control Horari per baix dels minuts que havies de treballar
                    $temps_estil="text-danger";
                }
                


                //Mostrar dades de taula
				echo "<tr>";
				echo "<td>".$control_id."</td>";
                echo "<td>".$control_tipo."</td>";
                echo "<td>";
                echo "<a href=\"index.php?accio=control_llista&filtro_profe=".$control_idprofessor."\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\" title=\"".$control_idprofessor."\">F</a> ";
                echo $control_professor."</td>";
                echo "<td>";
                echo "<a href=\"index.php?accio=control_llista&filtro_profe=".$control_idprofessor."&filtro_data=".$control_data."\" class=\"btn btn-outline-dark btn-sm\" role=\"button\" aria-disabled=\"true\" title=\"".$control_idprofessor." ".$control_data."\">F</a> ";
                echo $control_data."</td>";
                echo "<td>".$control_hora."</td>";
                echo "<td>".$ubicacio.$dh_app.$dh_qr."</td>";
                echo "<td><span class=\"".$temps_estil."\">".$temps_total." = ".$temps_acumulat." - ".$temps_horari."</span></td>";
				if ($username==$usuari_privilegiat){
					echo "<td>";
					echo "<a href=\"index.php?accio=control_elimina&id=".$control_id."\" class=\"btn btn-outline-danger btn-sm\" role=\"button\" aria-disabled=\"true\">".CONTROL_LLISTA_ELIMINA."</a>";
					echo "</td>";
				}
                echo "</tr>";
			}
			?>
		</tbody>
	</table>
</div>