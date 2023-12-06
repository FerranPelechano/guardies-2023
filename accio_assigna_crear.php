<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$Fdata = $_POST['Fdata'];
$Fhora = $_POST['Fhora'];
$Fidabsencia = $_POST['Fidabsencia'];
$FselectProfe=$_POST['FselectProfe'];

if ($Fidabsencia<0){
  //Gestionem PATIS
    $temp_Fidabsencia=$Fidabsencia;    
    //Si té assignació anterior feta cal actualitzar
      $contar = $db->count('Guardia', array('ACTIVITAT'=>$temp_Fidabsencia,'DATA' => $Fdata,'HORA'=>$Fhora));				
      if ($contar==0){
        //Si és Pati cal fer INSERT en IDPROFESSOR amb increment
        $db->insert("Guardia", array('COBERTAPER' => $FselectProfe, 'DATA' => $Fdata, 'HORA' => $Fhora, 'ACTIVITAT'=>$temp_Fidabsencia));		
      }else{
        //Com ja existeix sols cal fer UPDATE
      $db->update("Guardia", array('COBERTAPER' => $FselectProfe),array('ACTIVITAT'=>$temp_Fidabsencia,'DATA' => $Fdata,'HORA'=>$Fhora));		  
      } 
  }
if ($Fidabsencia==0){
    //Gestionem CONVIVENCIA 
    //Si té assignació anterior feta cal actualitzar
    $contar = $db->count('Guardia', array('IDPROFESSOR'=>null,'DATA' => $Fdata,'HORA'=>$Fhora));				
    if ($contar==0){
      //Si és Convivència cal fer INSERT sense IDPROFESSOR
      $db->insert("Guardia", array('COBERTAPER' => $FselectProfe, 'DATA' => $Fdata, 'HORA' => $Fhora));		
    }else{
	  	//Com ja existeix sols cal fer UPDATE
	  $db->update("Guardia", array('COBERTAPER' => $FselectProfe),array('IDPROFESSOR'=>null,'DATA' => $Fdata,'HORA'=>$Fhora));		  
    } 
  }
if ($Fidabsencia>0){  
  //GESTIONEM ABSENCIA
  	//Si és una absència sols cal fer UPDATE de COBERTAPER
  	$contar = $db->count('Guardia', array('DATA' => $Fdata,'HORA'=>$Fhora));				
  	if ($contar!=0){					
  		$db->update("Guardia", array('COBERTAPER' => $FselectProfe),array('ID'=> $Fidabsencia));		
  	}	
}
?>
