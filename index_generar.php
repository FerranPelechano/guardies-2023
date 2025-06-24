<?php if (!defined("VERSION")) {echo "No, no, no...";exit;} ?>
<?php
if ($data = date("Y-m-d")) {
	//generar fitxer
	$fitxer = $config_bd_carpeta_backup."/" . $data ."-".$config_bd_nomfitxer;	
	//Si no existeix el backup diari, fer la còpia
	if (!file_exists($fitxer)) {
		copy($config_bd_ruta, $fitxer);
	}
}
?>    