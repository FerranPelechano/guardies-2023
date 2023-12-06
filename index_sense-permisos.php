<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php 
if ($username!=$usuari_privilegiat){
	echo "<div class=\"alert alert-danger\" role=\"alert\"><b>".SENSEPERMISOS_1."</b>".SENSEPERMISOS_2."</div>";
	exit; 
}
	
?>
