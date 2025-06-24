<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$data = $_GET['data'];
$Faula = $_POST['inputAula'];
$Fprofe = $_POST['selectProfes'];
$Fdata = $_POST['inputData'];
$Fhora = $_POST['inputHora'];
$Fobservacions= $_POST['inputObservacions'];
//Evitar comilles dobles
$Fobservacions=str_replace("\"","&quot;",$Fobservacions);
$db->insert("Reserves", array('IDPROFESSOR' => $Fprofe, 'DATA' => $Fdata, 'HORA' => $Fhora, 'AULA' => $Faula, 'OBSERVACIONS' => $Fobservacions));
?>


