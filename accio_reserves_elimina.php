<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$Fid = $_GET['id'];
$db->delete("Reserves", array('ID'=> $Fid));		  
?>


