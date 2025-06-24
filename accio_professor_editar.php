<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
//Recollir valors
$FidProfe = $_POST['selectProfes'];
$Feditar = $_POST['editar'];
//Fer update si estem en algun valor
if ($Feditar!=""){						
    $query = "UPDATE Professor SET NOM='".$_POST['inputNom']."', MAIL='".$_POST['inputMail']."', COCOPE='".$_POST['checkCCP']."', TUTESO='".$_POST['checkTUTESO']."', TUTBAT='".$_POST['checkTUTBAT']."', TUTCF='".$_POST['checkTUTCF']."', TUTSEMI='".$_POST['checkTUTSEMI']."', DEP='".$_POST['selectDep']."', DIR='".$_POST['checkDIR']."' WHERE ID=".$FidProfe;    
    //echo $query;
	$profe_update = $db->query($query)->fetchAll();
    $alerta="<div class='alert alert-success' role='alert'>".PROFESSOR_EDITAR_ALERTA."</div>";
}
//Mostrar valors del registre actual
if ($FidProfe!=""){
    $query = "SELECT * FROM Professor AS PRO WHERE PRO.ID=".$FidProfe;
    $profe_actual = $db->query($query)->fetchAll();
    //print_r($profe_actual[0]);    
}else{
    $profe_actual[0]="";    
}
?>
<div class="container-fluid">     
	<h4><?=PROFESSOR_EDITAR_TITUL;?></h4>
    <?=$alerta;?>
  	<form  id="FormProfe" method="post" action="index.php?accio=professor_editar">
    	<div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_EDITAR_LABEL_PROFE;?></label>
      		<select class="form-control" id="selectProfes" name="selectProfes" onchange="document.getElementById('FormProfe').submit();">
	    		<option value=""></option>
	    		<?php
	    		$profes = $db->select('Professor', array('ID','NOM'), array('ORDER' => 'NOM'));  
	    		foreach($profes as $profe){      
				  $profe_id = $profe['ID'];	  	  
	    		  $profe_nomprofe = $profe['NOM'];				    
				  if($FidProfe == $profe_id){
					echo "<option selected value='".$profe_id."'>".$profe_nomprofe."</option>";
				  }else{
					echo "<option value='".$profe_id."'>".$profe_nomprofe."</option>";
				  }				  
	    		}
	    		?>        
      		</select>
	  	</div>
		<div class="form-group">  
    	    <label for="labelNouProfe"><?=PROFESSOR_LABEL_NOM;?></label>
    	    <input type="text" class="form-control" id="inputNom" name="inputNom" value="<?=$profe_actual[0]['NOM'];?>">
		</div>
		<div class="form-group">  
			<label for="labelNouProfe"><?=PROFESSOR_EDITAR_LABEL_MAIL;?></label>
    	    <input type="text" class="form-control" id="inputMail" name="inputMail" value="<?=$profe_actual[0]['MAIL'];?>">
		</div>
    	<div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_EDITAR_LABEL_DEP;?></label>
      		<select class="form-control" id="selectDep" name="selectDep">
	    		<option value=""></option>
	    		<?php	    		
	    		foreach($config_departaments as $dep){      
				  if($profe_actual[0]['DEP'] == $dep){
					echo "<option selected value='".$dep."'>".$dep."</option>";
				  }else{
					echo "<option value='".$dep."'>".$dep."</option>";
				  }				  
	    		}
	    		?>        
      		</select>
	  	</div>        
		<div class="form-group">  
			<label for="labelNouProfe"><?=PROFESSOR_EDITAR_LABEL_CHECK_CCP;?></label>    	    
			<input class="form-check-input" type="checkbox" id="checkCCP" name="checkCCP" <?php if ($profe_actual[0]['COCOPE']=='on'){ echo " checked ";}?>>
			<label for="labelNouProfe"><?=PROFESSOR_EDITAR_LABEL_CHECK_TESO;?></label>    	    
			<input class="form-check-input" type="checkbox" id="checkTUTESO" name="checkTUTESO" <?php if ($profe_actual[0]['TUTESO']=='on'){ echo " checked ";}?>>
			<label for="labelNouProfe"><?=PROFESSOR_EDITAR_LABEL_CHECK_TBAT;?></label>    	    
			<input class="form-check-input" type="checkbox" id="checkTUTBAT" name="checkTUTBAT" <?php if ($profe_actual[0]['TUTBAT']=='on'){ echo " checked ";}?>>
			<label for="labelNouProfe"><?=PROFESSOR_EDITAR_LABEL_CHECK_TCF;?></label>    	    
			<input class="form-check-input" type="checkbox" id="checkTUTCF" name="checkTUTCF" <?php if ($profe_actual[0]['TUTCF']=='on'){ echo " checked ";}?>>
			<label for="labelNouProfe"><?=PROFESSOR_EDITAR_LABEL_CHECK_TSEMI;?></label>    	    
			<input class="form-check-input" type="checkbox" id="checkTUTSEMI" name="checkTUTSEMI" <?php if ($profe_actual[0]['TUTSEMI']=='on'){ echo " checked ";}?>>
			<label for="labelNouProfe"><?=PROFESSOR_EDITAR_LABEL_CHECK_DIR;?></label>    	    
			<input class="form-check-input" type="checkbox" id="checkDIR" name="checkDIR" <?php if ($profe_actual[0]['DIR']=='on'){ echo " checked ";}?>>		
		</div>			
		<div class="form-group">	  
			<br>
			<button type="button" class="btn btn-primary" onclick="document.getElementById('editar').value='editar';document.getElementById('FormProfe').submit();"><?=PROFESSOR_EDITAR_LABEL_SUBMIT;?></button>	 
            <input type="hidden" class="form-control" id="editar" name="editar" value="">
		</div>
  	</form>
</div>
