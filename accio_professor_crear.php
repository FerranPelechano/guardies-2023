<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$FNouProfe = $_POST['inputNouProfe'];
$FSelectProfes = $_POST['selectProfes'];
$FidProfe = $_POST['idProfe'];
$Feditar = $_POST['editar'];

if ($FSelectProfes==""){					
	$db->insert("Professor", array('NOM' => $FNouProfe));	
}else{
	$db->update("Professor", array('NOM' => $FNouProfe),array('ID'=> $FSelectProfes));		
}






?>
