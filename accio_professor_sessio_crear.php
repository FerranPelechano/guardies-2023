<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$Fid = $_POST['selectId'];
$FidProfe = $_POST['selectProfes'];
$Fdata = $_POST['selectData'];
$Fhora = $_POST['selectHora'];
$Fmateria = $_POST['selectMateria'];
$Fgrup = $_POST['selectGrup'];
$Faula = $_POST['selectAula'];
$Ftipus = $_POST['selectTipus'];
$Fdelete = $_POST['selectDelete'];
$Feditar = $_POST['Feditar'];

if($Fdelete == "on"){
  //MODE ESBORRAR
  $db->delete("Horari", array('ID'=> $Fid));		  
}else{
    //MODE EDITAR/INSERTAR
    if ($Fid!=""){
        //Si existeix fem UPDATE
        $db->update("Horari", array('IDPROFESSOR' => $FidProfe, 'DATA' => $Fdata, 'HORA' => $Fhora, 'MATERIA' => $Fmateria, 'GRUP' => $Fgrup, 'AULA' => $Faula, 'TIPUS' => $Ftipus),array('ID'=> $Fid));		  
    }else{
        //Si és nou fem INSERT    
        $db->insert("Horari", array('IDPROFESSOR' => $FidProfe, 'DATA' => $Fdata, 'HORA' => $Fhora, 'MATERIA' => $Fmateria, 'GRUP' => $Fgrup, 'AULA' => $Faula, 'TIPUS' => $Ftipus));		  	  
    } 
}
?>