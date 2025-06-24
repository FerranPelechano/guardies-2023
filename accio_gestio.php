<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$FinputMateria = $_POST['inputMateria'];
$FinputGrup = $_POST['inputGrup'];
$FinputAula = $_POST['inputAula'];
$FinputTipus = $_POST['inputTipus'];
//Crear noves entrades si no existien prèviament
if($FinputMateria!=""){
    //Comprovar si existeix
    $temp = $db->count('Horari', array('@MATERIA'), array('MATERIA' => $FinputMateria));  
    if($temp=="0"){
        $db->insert("Horari", array('MATERIA' => $FinputMateria));		  	  
        echo "<div class=\"alert alert-warning \">".GESTIO_ALERT_MATERIA.$FinputMateria." </div>";
        //$db->insert("Horari", array('MATERIA' => $FinputMateria, 'GRUP' => $FinputGrup, 'AULA' => $FaFinputAula));		  	  
    }        
}
if($FinputGrup!=""){
    //Comprovar si existeix
    $temp = $db->count('Horari', array('@GRUP'), array('GRUP' => $FinputGrup));  
    if($temp=="0"){
        $db->insert("Horari", array('GRUP' => $FinputGrup));		  	  
        echo "<div class=\"alert alert-warning \">".GESTIO_ALERT_GRUP.$FinputGrup." </div>";
    }        
}
if($FinputAula!=""){
    //Comprovar si existeix
    $temp = $db->count('Horari', array('@AULA'), array('AULA' => $FinputAula));  
    if($temp=="0"){
        $db->insert("Horari", array('AULA' => $FinputAula));		  	  
        echo "<div class=\"alert alert-warning \">".GESTIO_ALERT_AULA.$FinputAula." </div>";
    }        
}
if($FinputTipus!=""){
  //Comprovar si existeix
  $temp = $db->count('Horari', array('@TIPUS'), array('TIPUS' => $FinputTipus));  
  if($temp=="0"){
      $db->insert("Horari", array('TIPUS' => $FinputTipus));		  	  
      echo "<div class=\"alert alert-warning \">".GESTIO_ALERT_TIPUS.$FinputTipus." </div>";
  }        
}

?>
<div class="container-fluid">     
	<h4><?=GESTIO_TITUL;?></h4>
  	<form  id="FormProfe" method="post" action="index.php?accio=gestio">
        <div class="form-group">
      		<label for="labelProfes"><?=GESTIO_LABEL_MATERIA;?></label>
            <input class="form-control" id="inputMateria" name="inputMateria">
      		<select class="form-control" id="selectMateria" name="selectMateria" readonly>
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
      		<label for="labelProfes"><?=GESTIO_LABEL_GRUP;?></label>
            <input class="form-control" id="inputGrup" name="inputGrup">
      		<select class="form-control" id="selectGrup" name="selectGrup" readonly>
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
      		<label for="labelProfes"><?=GESTIO_LABEL_AULA;?></label>
      		<input class="form-control" id="inputAula" name="inputAula">
            <select class="form-control" id="selectAula" name="selectAula" readonly>
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
      		<label for="labelProfes"><?=GESTIO_LABEL_TIPUS;?></label>
      		<input class="form-control" id="inputTipus" name="inputTipus">
            <select class="form-control" id="selectTipus" name="selectTipus" readonly>
	    		<option value=""></option>                
	    		<?php
	    		$temps = $db->select('Horari', array('@TIPUS'), array('ORDER' => 'TIPUS'));  
	    		foreach($temps as $temp){      				  
	    		  $temp_element = $temp['TIPUS'];	  	  
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
			<br>
			<button type="submit" class="btn btn-primary"><?=GESTIO_LABEL_SUBMIT;?></button>	 
		</div>
  	</form>
</div>