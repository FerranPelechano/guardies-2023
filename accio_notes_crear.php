<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$Fobservacions = $_POST['textObservacions'];
$Fdata = $_POST['Fdata'];
$Fhora = $_POST['Fhora'];
$Fnota_id = $_POST['Fnota_id'];
$contar = $db->count('Notes', array('DATA' => $Fdata,'HORA'=>$Fhora));				
if ($contar==0){					
	$db->insert("Notes", array('NOTES' => $Fobservacions, 'DATA' => $Fdata, 'HORA' => $Fhora));	
}else{
	if ($Fobservacions==""){
		$db->delete("Notes", array('ID'=> $Fnota_id));		
	}else{
		$db->update("Notes", array('NOTES' => $Fobservacions),array('ID'=> $Fnota_id));		
	}	
}
?>
