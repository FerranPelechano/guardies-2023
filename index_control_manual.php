<?php
error_reporting(0);
define("VERSION","Guardies 2025-06-19 Ferran Pelechano. Llicència Creative Commons BY-NC-SA. f.pelechanogarcia@edu.gva.es");
$idioma="ca"; 
?>
<?php require_once "index_idioma_" . $idioma . ".php"; ?>
<?php require_once "index_config.php"; ?>
<?php require_once "index_funcions.php"; ?>
<!doctype html>
<html lang="<?= $idioma; ?>">
  <head>
    <meta charset="utf-8">    
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="author" content="<?=VERSION;?>">
    <title><?=INDEX_TITUL?></title>	
	  <link rel="icon" href="images/logo.png" sizes="32x32" />
	  <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php require_once "accio_control_manual.php";?>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
