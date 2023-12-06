<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$Fdata = $_GET['data'];
$Fhora = $_GET['hora'];
$Fidabsencia = $_GET['idabsencia'];
$Fnotes = $db->select('Notes(N)',array('N.ID','N.NOTES'),array('AND' => array('DATA' => ''.$Fdata.'', 'HORA'=>''.$Fhora.'')));	  
$cadena_notes="";
$Fnota_id=0;
foreach ($Fnotes as $nota){
	$Fnota_id = $nota['ID'];
	$nota_notes = $nota['NOTES'];
	$cadena_notes=$cadena_notes.$nota_notes;
}
//Mirar el dia del que consultar horari	
$dia = dia_actual($Fdata);	
?>
<div class="container-fluid">     
	<h4><?=ASSIGNA_TITUL;?> (<?=data_en_cadena($Fdata)." ".ASSIGNA_A_LES." ".$config_hores[$Fhora];?>)</h4>
  	<form  method="post" action="index.php?accio=assigna_crear&data=<?=$Fdata;?>">
    	<div class="form-group">
      		<label for="labelProfes">Professor</label>
      		<select class="form-control" id="FselectProfe" name="FselectProfe">
				<option value="">-- <?=ASSIGNA_SELECT_ELIMINA;?> --</option>	    
				<option value="">-- <?=ASSIGNA_SELECT_GUARDIA;?> --</option>		
				<?php		
 	    		//Professorat de Guardia
        		$horaris = $db->select(
        		    'Horari', ['[>]Professor(P1)' => ['IDPROFESSOR' => 'ID']],
        		    array('Horari.ID','Horari.IDPROFESSOR','Horari.DATA','Horari.HORA','P1.NOM'),
        			  array('AND' => array('DATA' => ''.$dia.'', 'HORA'=>''.$Fhora.'','TIPUS' => 'G'), 'ORDER' => 'IDPROFESSOR')
        		);					
				foreach($horaris as $profe){      
					$profe_id = $profe['IDPROFESSOR'];	  	  
	    		  	$profe_nomprofe = $profe['NOM'];	  	  
	    		  	echo "<option value='".$profe_id."'>".$profe_nomprofe."</option>";
	    		}		
				?>		
				<option value="">-- <?=ASSIGNA_SELECT_LLISTA;?> --</option>
				<?php	
				//Llista completa
	    		$profes = $db->select('Professor', array('ID','NOM'), array('ORDER' => 'NOM'));  
	    		foreach($profes as $profe){      
				  $profe_id = $profe['ID'];	  	  
	    		  $profe_nomprofe = $profe['NOM'];	  	  
	    		  echo "<option value='".$profe_id."'>".$profe_nomprofe."</option>";
	    		}
	    		?>        
      		</select>
    	</div>
		<br>
    	<div class="form-group">
    	    <input type="hidden"  name="Fdata" id="data" value="<?=$Fdata;?>">
    	    <input type="hidden"  name="Fhora" id="hora" value="<?=$Fhora;?>">
			<input type="hidden"  name="Fidabsencia" id="idabsencia" value="<?=$Fidabsencia;?>">
			<button type="submit" class="btn btn-primary"><?=ASSIGNA_DESAR;?></button>	
		</div>
  	</form>
</div>