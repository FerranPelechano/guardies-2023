<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$Fid = $_GET['pid'];
$Fprofe = $_GET['pprofe'];
$Fdata = $_GET['pdata'];
$Fhora = $_GET['phora'];
if ($Fid != ""){
    $temps = $db->select('Horari', array('MATERIA','GRUP','AULA','TIPUS'), array('AND' => array('ID' => ''.$Fid.'')), array('ORDER' => 'DATA'));  
	foreach($temps as $temp){      				  	    
        $Fmateria=$temp['MATERIA'];
        $Fgrup=$temp['GRUP'];
        $Faula=$temp['AULA'];
        $Ftipus=$temp['TIPUS'];
    }
}
?>
<div class="container-fluid">     
	<h4><?=PROFESSOR_SESSIO_TITUL;?></h4>
  	<form  id="FormProfe" method="post" action="index.php?accio=professor_sessio_crear">
    	<div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_SESSIO_LABEL_PROFESSOR;?></label>
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
      		<label for="labelProfes"><?=PROFESSOR_SESSIO_LABEL_DATA;?></label>
      		<select class="form-control" id="selectData" name="selectData">
	    		<option value=""></option>                
	    		<?php				
	    		$temps = $db->select('Horari', array('@DATA'), array('ORDER' => 'DATA'));  
	    		foreach($temps as $temp){      				  
	    		  $temp_element = $temp['DATA'];	  	  
                  if($temp_element == $Fdata){
                    echo "<option value='".$temp_element."' selected>".$temp_element."</option>";
                  }else{
                    echo "<option value='".$temp_element."' >".$temp_element."</option>";
                  }	    		  
	    		}
	    		?>        
      		</select>
	  	</div>
          <div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_SESSIO_LABEL_HORA;?></label>
      		<select class="form-control" id="selectHora" name="selectHora">
	    		<option value=""></option>                
	    		<?php
	    		$temps = $db->select('Horari', array('@HORA'), array('ORDER' => 'HORA'));  
	    		foreach($temps as $temp){      				  
	    		  $temp_element = $temp['HORA'];	  	  
                  if($temp_element == $Fhora){
                    echo "<option value='".$temp_element."' selected>".$config_hores[$temp_element]." (".$temp_element.")"."</option>";
                  }else{
                    echo "<option value='".$temp_element."' >".$config_hores[$temp_element]." (".$temp_element.")"."</option>";
                  }	    		  
	    		}
	    		?>        
      		</select>
	  	</div>      
        <div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_SESSIO_LABEL_MATERIA;?></label>
      		<select class="form-control" id="selectMateria" name="selectMateria">
	    		<option value=""></option>                
	    		<?php
	    		$temps = $db->select('Horari', array('@MATERIA'), array('ORDER' => 'MATERIA'));  
	    		foreach($temps as $temp){      				  
	    		  $temp_element = $temp['MATERIA'];	  	  
                  if($temp_element == $Fmateria){
                    echo "<option value='".$temp_element."' selected>".$temp_element."</option>";
                  }else{
                    echo "<option value='".$temp_element."' >".$temp_element."</option>";
                  }	    		  
	    		}
	    		?>        
      		</select>
	  	</div>        
        <div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_SESSIO_LABEL_GRUP;?></label>
      		<select class="form-control" id="selectGrup" name="selectGrup">
	    		<option value=""></option>                
	    		<?php
	    		$temps = $db->select('Horari', array('@GRUP'), array('ORDER' => 'GRUP'));  
	    		foreach($temps as $temp){      				  
	    		  $temp_element = $temp['GRUP'];	  	  
                  if($temp_element == $Fgrup){
                    echo "<option value='".$temp_element."' selected>".$temp_element."</option>";
                  }else{
                    echo "<option value='".$temp_element."' >".$temp_element."</option>";
                  }	    		  
	    		}
	    		?>        
      		</select>
	  	</div>                
          <div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_SESSIO_LABEL_AULA;?></label>
      		<select class="form-control" id="selectAula" name="selectAula">
	    		<option value=""></option>                
	    		<?php
	    		$temps = $db->select('Horari', array('@AULA'), array('ORDER' => 'AULA'));  
	    		foreach($temps as $temp){      				  
	    		  $temp_element = $temp['AULA'];	  	  
                  if($temp_element == $Faula){
                    echo "<option value='".$temp_element."' selected>".$temp_element."</option>";
                  }else{
                    echo "<option value='".$temp_element."' >".$temp_element."</option>";
                  }	    		  
	    		}
	    		?>        
      		</select>
	  	</div>   
         <div class="form-group">
      		<label for="labelProfes"><?=PROFESSOR_SESSIO_LABEL_TIPUS;?></label>
      		<select class="form-control" id="selectTipus" name="selectTipus">
	    		<option value=""></option>                
	    		<?php
	    		$temps = $db->select('Horari', array('@TIPUS'), array('ORDER' => 'TIPUS'));  
	    		foreach($temps as $temp){      				  
	    		  $temp_element = $temp['TIPUS'];	  	  
                  if($temp_element == $Ftipus){
                    echo "<option value='".$temp_element."' selected>".$temp_element."</option>";
                  }else{
                    echo "<option value='".$temp_element."' >".$temp_element."</option>";
                  }	    		  
	    		}
	    		?>        
      		</select>
	  	</div>           
		<div class="form-group">	  
			<br>
			<button type="submit" class="btn btn-primary"><?=PROFESSOR_SESSIO_LABEL_SUBMIT;?></button>	 
			<button type="button" class="btn btn-danger" onclick="selectDelete.value='on';FormProfe.submit()"><?=PROFESSOR_SESSIO_LABEL_ESBORRAR;?></button>	 
            <input type="hidden" class="form-control" id="selectId" name="selectId" value="<?=$Fid;?>">
			<input type="hidden" class="form-control" id="selectDelete" name="selectDelete" value="">
			<input type="hidden" class="form-control" id="Feditar" name="Feditar" value="on">
		</div>
  	</form>
</div>