<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php

if ($Faula==""){
    $Faula = $_POST['selectAula'];	
	if ($Faula==""){
		 $Faula = $_GET['selectAula'];
		}
}
?>
<div class="container-fluid">     
	<h4><?=RESERVES_TITUL;?> (<?=$data;?>) [<?=$Faula;?>]</h4>
  	<form  id="FormReserves" method="post" action="index.php?data=<?=$data;?>&accio=reserves">            
          <div class="form-group">
      		<label for="labelProfes"><?=RESERVES_LABEL_AULA;?></label>
      		<select class="form-control" id="selectAula" name="selectAula" onchange="document.getElementById('FormReserves').submit()">
	    		<option value=""></option>                
	    		<?php
	    		$temps = $db->select('Horari', array('@AULA'), array('ORDER' => 'AULA'));  
	    		foreach($temps as $temp){      			
				  $temp_element = $temp['AULA'];	  	  
				  //Afegir info del config al desplegable 
				  $cadena_info="";
				  if ($config_info_aules[$temp_element]!=""){$cadena_info=" [".$config_info_aules[$temp_element]."]";}	    		  
                  if($temp_element == $Faula){
                    echo "<option value='".$temp_element."' selected>".$temp_element.$cadena_info."</option>";
                  }else{
                    echo "<option value='".$temp_element."' >".$temp_element.$cadena_info."</option>";
                  }	    		  
	    		}
	    		?>        
      		</select>
			
		</div>   
		<?php
		if ($config_info_aules[$Faula]!=""){
			echo "<div class=\"alert alert-success\" role=\"alert\">".$config_info_aules[$Faula]."</div>";
		}
		?>
  	</form>
    <?php
    //Mostrar Disponibilitat d'Aulari Escollit
    ?>
    <?php if ($Faula==""){

    }else{

    $columna1=array($data,dia_actual($data));
    $columna2=array(date('Y-m-d', strtotime( "$data + 1 day" )),dia_actual(date('Y-m-d', strtotime( "$data + 1 day" ))));
    $columna3=array(date('Y-m-d', strtotime( "$data + 2 day" )),dia_actual(date('Y-m-d', strtotime( "$data + 2 day" ))));
    $columna4=array(date('Y-m-d', strtotime( "$data + 3 day" )),dia_actual(date('Y-m-d', strtotime( "$data + 3 day" ))));
    $columna5=array(date('Y-m-d', strtotime( "$data + 4 day" )),dia_actual(date('Y-m-d', strtotime( "$data + 4 day" ))));
	$columna=array($columna1,$columna2,$columna3,$columna4,$columna5);
    ?>


<form  id="FormReservesCrear" method="post" action="index.php?data=<?=$data;?>&accio=reserves_crear">            
    	<div class="form-group">
        <label for="labelProfes"><?=RESERVES_LABEL_PROFESSOR;?></label>
        <select class="form-control" id="selectProfes" name="selectProfes">
          <option value=""></option>                
          <?php
          $profes = $db->select('Professor', array('ID','NOM'), array('ORDER' => 'NOM'));  
          foreach($profes as $profe){      
            $profe_id = $profe['ID'];	  	  
            $profe_nomprofe = $profe['NOM'];	  	  
            if($profe_id == $Fprofe){
              echo "<option value='".$profe_id."' selected>".$profe_nomprofe."</option>";
            }else{
              echo "<option value='".$profe_id."'>".$profe_nomprofe."</option>";
            }	    		  
          }
          ?>        
        </select>
    </div>
    <div class="form-group">	  
        <?=RESERVES_LABEL_OBSERVACIONS;?>
        <input type="text" class="form-control" id="inputObservacions" name="inputObservacions" value="<?=$Fobservacions;?>">    
        <input type="hidden" class="form-control" id="inputAula" name="inputAula" readonly value="<?=$Faula;?>">
        <input type="hidden" class="form-control" id="inputData" name="inputData" readonly value="<?=$data;?>">
        <input type="hidden" class="form-control" id="inputHora" name="inputHora" readonly value="">        
    </div>

        </form>


    <div class="row align-items-start">
	    <div class="col">
		<table class="table table-sm table-bordered table-striped">
  			<thead>
  				<tr>
  			    	<th class="col-1" scope="col"><?=$Faula;?></th>                      
                    <th class="col-2" scope="col"><?=$columna1[0];echo " (".$columna1[1].")";?></th>                    
                    <th class="col-2" scope="col"><?=$columna2[0];echo " (".$columna2[1].")";?></th>
                    <th class="col-2" scope="col"><?=$columna3[0];echo " (".$columna3[1].")";?></th>
                    <th class="col-2" scope="col"><?=$columna4[0];echo " (".$columna4[1].")";?></th>
                    <th class="col-2" scope="col"><?=$columna5[0];echo " (".$columna5[1].")";?></th>				  	
  			  	</tr>
  			</thead>
  			<tbody>	
            <?php              
            //Construir Taula
            foreach ($config_intervals as $hora){		
	  			/* ----- COLUMNA1 HORES ----- */
      			$pati="";
	  			if ($hora=="R1"){$pati="Pati";}
	  			if ($hora=="R2"){$pati="Pati";}
	  			if ($hora=="R3"){$pati="Pati";}	  				
				echo "<tr><th ".$destaca." scope=\"row\">".$config_hores[$hora]." ".$pati."</th>";
                /* ----- COLUMNA2 HORARI I RESERVES ----- */
				foreach ($columna as $element){


					$dia = dia_actual($element[0]);
	                $horaris = $db->select(
	    			    'Horari', 
	    			    array('Horari.ID','Horari.AULA','Horari.GRUP','Horari.MATERIA'),
	    				array('AND' => array('DATA' => ''.$dia.'', 'HORA'=>''.$hora.'','AULA' =>''.$Faula.''), 'ORDER' => 'AULA')
	    			);
	    			echo "<td><div>";
					$horari_grup = "";
	                foreach($horaris as $horari){      
					    $horari_materia = $horari['MATERIA'];
						$horari_grup = $horari['GRUP'];	  	  				    
						echo "<div style=\"padding:1px;\">";
						echo "<a class=\"btn btn-outline-primary btn-sm\" role=\"button\" aria-disabled=\"true\">".$horari_grup." ".$horari_materia."</a> ";		
						echo "</div>";
					}
					//Reserves anteriors
	                $horaris = $db->select(    			    
	                    'Reserves', ['[>]Professor(P1)' => ['IDPROFESSOR' => 'ID']],
	    			    array('Reserves.ID','Reserves.AULA','Reserves.OBSERVACIONS','Reserves.IDPROFESSOR','Reserves.DATA','Reserves.HORA', 'P1.NOM'),
	    				array('AND' => array('DATA' => ''.$element[0].'', 'HORA'=>''.$hora.'','AULA' =>''.$Faula.''), 'ORDER' => 'AULA')
	    			);
	    			echo "<div>";
					$horari_professor = "";
	                foreach($horaris as $horari){      
					    $horari_professor = $horari['NOM'];
						$horari_observacions = $horari['OBSERVACIONS'];	  	  				    
						echo "<div style=\"padding:1px;\">";
						echo "<a class=\"btn btn-outline-danger btn-sm\" role=\"button\" aria-disabled=\"true\">".$horari_professor."<br>".$horari_observacions."</a> ";		
						echo "</div>";
					}
    	            //Botó per reservar
					$tiempo=strtotime($element[0])-strtotime(date("Y-m-d"));
					if ($tiempo>=0){$tiempo_futuro=true;}else{$tiempo_futuro=false;}					
    	            if ($horari_grup=="" && $horari_professor=="" && $tiempo_futuro){
    	                echo "<div style=\"padding:1px;\">";
    	                echo "<a class=\"btn btn-success btn-sm\" role=\"button\" aria-disabled=\"true\" onclick=\"envia_form('".$hora."','".$element[0]."');\">".RESERVES_LABEL_RESERVAR."</a> ";		
    	                echo "</div>";                        
    	            }                
    	            echo "</td>";
				}

            }

            ?>
            </tbody>	
        </table>

    <script>
        function envia_form(hora,dia){    
            document.getElementById('inputHora').value=hora;
			document.getElementById('inputData').value=dia;
            if (document.getElementById('selectProfes').value!=''){
                document.getElementById('FormReservesCrear').submit();
            }else{
                alert("Falta elegir el professor!");
            }
        }


		document.getElementById('selectAula').focus();

    </script>
<?php
}
?>
</div>