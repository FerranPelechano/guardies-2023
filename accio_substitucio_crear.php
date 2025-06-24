<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$FSust = $_POST['selectSust'];
$FProfe = $_POST['selectProfe'];
$FDe = $_POST['dataFrom'];
$FA = $_POST['dataTo'];
$Gmode = $_GET['mode'];
$Gid = $_GET['idsubst'];
$Gidprofe = $_GET['idprofe'];
$Gde = $_GET['de'];
$Ga = $_GET['a'];
switch($Gmode){
	case "elimina":
		//MODE ELIMINAR
		if ($Gid != ""){
			$db->delete("Substitucions", array('AND' => ['ID' => $Gid]));	
		}
	break;
	case "elimina_absencies":
		//MODE ELIMINAR ABSENCIES
		$db->delete("Guardia", array('IDPROFESSOR' => $Gidprofe, 'DATA[>=]' => $Gde, 'DATA[<=]' => $Ga ));		
	break;
	default:
		//MODE AFEGIR
		if ($FProfe !="" && $FSust != "" && $FDe != "" && $FA != ""){					
			$db->insert("Substitucions", array('PROFE' => $FProfe, 'SUBSTITUT' => $FSust, 'DE' => $FDe, 'A' => $FA ));	
		}	
	break;	
}
?>
