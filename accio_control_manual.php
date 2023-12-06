<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<div class="container-fluid"> 
    <h4><?=INDEX_CONTROL_MANUAL_TITUL;?></h4>
    
    <?php
    if (count($_POST)==0){
      // Mostrar Formulari
      ?>
      <form  id="FormControlManual" method="post" action="index.php?accio=control_manual">
      	<div class="form-group">
        		<label for="labelProfes"><?=INDEX_CONTROL_MANUAL_PROFE;?></label>
        		<select class="form-control" id="selectProfes" name="selectProfes">
	      		<option value=""></option>
	      		<?php
	      		$profes = $db->select('Professor', array('ID','NOM'), array('ORDER' => 'NOM'));  
	      		foreach($profes as $profe){      
		  		  $profe_id = $profe['ID'];	  	  
	      		  $profe_nomprofe = $profe['NOM'];				    
		  			echo "<option value='".$profe_id."'>".$profe_nomprofe."</option>";				  
	      		}
	      		?>        
        		</select><br>
            <label for="labelProfes"><?=INDEX_CONTROL_MANUAL_VALIDADOR;?></label> <br>
            <input type="text" id="validador" name="validador" value=""> <br><br>
            <input type="hidden" id="inout" name="inout" value="" readonly>

            <button id="boto_in" type="button" class="btn btn-success btn-sm" onclick="enviar('IN');"><?=INDEX_CONTROL_MANUAL_IN;?></button>
            <button id="boto_out" type="button" class="btn btn-danger btn-sm" onclick="enviar('OUT');"><?=INDEX_CONTROL_MANUAL_OUT;?></button>
        </div>
      </form>
      <script>
          function enviar(valor){
            document.getElementById("inout").value=valor;
            document.getElementById("FormControlManual").submit();               
          }
      </script>
    <?php
    }else{
      //Rebre dades del Form                  
      $Fprofe = $_POST["selectProfes"];
      $Fvalidador = $_POST["validador"];
      $Finout = $_POST["inout"];
      //Calcular validador
      $codi_validacio=codi_validacio_control($Fprofe);      
      if ($codi_validacio == $Fvalidador){
        //Processar entrada
        $missatge="";
        if ($Fprofe!=""){					
          $data=date("Y-m-d");
          $hora=date("H:i:s");
          $db->insert("Control", array('IDPROFESSOR' => $Fprofe, 'TIPO' => $Finout,  'DATA' => $data,  'HORA' => $hora,  'UBICACIO' => '',  'LATITUD' => '',  'LONGITUD' => '',  'DATAHORA_CODI_APP' => '', 'DATAHORA_QR_GENERAT'=> ''));	
          //Contestar
          if($Finout == "IN"){
            $missatge = "<b>".INDEX_CONTROL_ENTRADA."</b><br>";
            $missatge_alert="alert-success";
          }
          if($Finout == "OUT"){
            $missatge = "<b>".INDEX_CONTROL_EIXIDA."</b><br>";
            $missatge_alert="alert-info";
          }        
          
          //Mostrar dades del Guardat        
          $profes = $db->select('Professor', array('ID','NOM'), array('AND' => ['ID' => $Fprofe]));  	  
          foreach ($profes as $profe){
            $profe_id = $profe['ID'];		
            $profe_nom = $profe['NOM'];		
            $missatge.= " <b>[".$profe_id."]</b> ".$profe_nom."<br>";
          }		        
          $missatge.=$data." ".$hora."<br>";        
          echo "<div class=\"alert ".$missatge_alert."\" role=\"alert\">".$missatge."</div>";
        }
      }else{
        //Validació incorrecta
        $missatge=INDEX_CONTROL_MANUAL_VALIDACIO_MAL;
        $missatge_alert="alert-danger";
        echo "<div class=\"alert ".$missatge_alert."\" role=\"alert\">".$missatge."</div>";
      }      
    }
    ?>   
</div>