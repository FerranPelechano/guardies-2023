<?php
error_reporting(1);
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
	<meta name="author" content="<?= VERSION; ?>">
	<title><?= INDEX_TITUL ?></title>
	<link rel="icon" href="images/logo.png" sizes="32x32" />
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="js/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker.min.css" rel="stylesheet" />
	<link href="js/bootstrap-datepicker-1.9.0-dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/bootstrap.bundle.min.js"></script>
	<script src="js/bootstrap-datepicker-1.9.0-dist/js/bootstrap-datepicker.min.js"></script>
	<script src="js/bootstrap-datepicker-1.9.0-dist/locales/bootstrap-datepicker.ca.min.js" charset="UTF-8"></script>	
</head>

<body>
	<?php
	//Recollir dades de la validació htaccess
	$username = $_SERVER['PHP_AUTH_USER'];
	$password = $_SERVER['PHP_AUTH_PW'];
	//Recollir variables del GET
	$accio = $_GET['accio'];
	$data = $_GET['data'];
	if ($data == "") {$data = date("Y-m-d");}
	//Calcular dates per navegació
	$data_mes = date('Y-m-d', strtotime("$data + 1 day"));
	$data_mes7 = date('Y-m-d', strtotime("$data + 7 days"));
	$data_menys = date('Y-m-d', strtotime("$data - 1 day"));
	$data_menys7 = date('Y-m-d', strtotime("$data - 7 days"));
	$alerta = "";
	$refresca_script = true;
	$lock_passat=false;
	if ($data > date("Y-m-d")) {
		$refresca_script = false;
		$alerta = "<a class=\"btn btn-warning btn-sm\" role=\"button\" aria-disabled=\"true\">" . INDEX_FUTUR . "</a>";
	}
	if ($data < date("Y-m-d")) {
		$refresca_script = false;
		$alerta = "<a class=\"btn btn-warning btn-sm\" role=\"button\" aria-disabled=\"true\">" . INDEX_PASSAT . "</a>";
		$lock_passat=true;
	}
	//Obtenir data en format legible
	$data_mostrar = data_en_cadena($data);
	?>
	<div class="container-fluid">
		<nav class="navbar navbar-expand-lg navbar-light bg-light">
			<form class="form-inline my-2 my-lg-0">
				<a href="index.php"><img src="images/logo.png" class="img-fluid" alt="IES SVF"></a>
				<a href="index.php?data=&accio=mostrar" class="btn btn-outline-primary btn-sm " role="button" aria-disabled="true"><?= INDEX_AVUI; ?></a>
				<a href="index.php?data=<?= $data_menys7; ?>&accio=mostrar" class="btn btn-outline-primary btn-sm " role="button" aria-disabled="true"> << </a>
				<a href="index.php?data=<?= $data_menys; ?>&accio=mostrar" class="btn btn-outline-primary btn-sm " role="button" aria-disabled="true"> < </a>
				<a href="index.php?data=<?= $data_mes; ?>&accio=mostrar" class="btn btn-outline-primary btn-sm " role="button" aria-disabled="true">></a>
				<a href="index.php?data=<?= $data_mes7; ?>&accio=mostrar" class="btn btn-outline-primary btn-sm " role="button" aria-disabled="true">>></a>
				<a href="index.php?data=<?= $data; ?>&accio=mostrar" class="btn btn-outline-primary btn-sm " role="button" aria-disabled="true"><?= $data_mostrar; ?></a>
				<a href="index.php?accio=absencies" class="btn btn-outline-primary btn-sm " role="button" aria-disabled="true"><?= INDEX_ABSENCIA; ?></a>				
				<a href="index.php?accio=llistes_correu" class="btn btn-outline-primary btn-sm " role="button"><?= INDEX_LLISTES_CORREU; ?></a>
				<div class="btn-group">
					<button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?= INDEX_MENU_RESERVES; ?></button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="index.php?data=<?= $data; ?>&accio=reserves"><?= INDEX_RESERVES; ?></a></li>
						<li><a class="dropdown-item" href="index.php?accio=reserves_llista"><?= INDEX_RESERVES_LLISTA; ?></a></
					</ul>
				</div>
				<div class="btn-group">
					<button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?= INDEX_MENU_USER; ?></button>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="index.php?accio=edocent"><?= INDEX_EDOCENT; ?></a></li>
						<li><a class="dropdown-item" href="index.php?accio=grup"><?= INDEX_GRUP; ?></a></li>
						<li><a class="dropdown-item" href="index.php?accio=professor-vore"><?= INDEX_PROFESSOR; ?></a></li>						
						<li><a class="dropdown-item" href="index.php?accio=aules"><?= INDEX_AULES; ?></a></li>						
					</ul>
				</div>							
				<?php
				//echo $username;
				if ($username == $usuari_privilegiat) {
				?>
					<div class="btn-group">
						<button class="btn btn-outline-danger btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"><?= INDEX_MENU_ADMIN; ?></button>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="index.php?accio=informes"><?= INDEX_INFORMES; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=control_vaga&data=<?= $data; ?>"><?= INDEX_CONTROL_VAGA; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=control_actes"><?= INDEX_CONTROL_ACTES; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=llistes_correu"><?= INDEX_LLISTES_CORREU; ?></a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="index.php?accio=grup"><?= INDEX_GRUP; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=professor"><?= INDEX_PROFESSOR; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=professor2"><?= INDEX_PROFESSOR2; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=edocent"><?= INDEX_EDOCENT; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=edirectiu"><?= INDEX_EDIRECTIU; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=substitucio"><?= INDEX_SUBSTITUCIO; ?></a></li>							
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="index.php?accio=reserves_llista_completa"><?= INDEX_RESERVES_LLISTA; ?></a></li>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="index.php?accio=gestio"><?= INDEX_GESTIO; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=professor_editar"><?= INDEX_PROFESSOR_EDITAR; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=importar"><?= INDEX_IMPORTACIO; ?></a>
							<li><hr class="dropdown-divider"></li>
							<li><a class="dropdown-item" href="index.php?accio=control_manual";"><?= INDEX_CONTROL_MANUAL; ?></a></li>
							<li><a class="dropdown-item" href="index.php?accio=control_llista";"><?= INDEX_CONTROL_LLISTA; ?></a></li>
							
						</ul>
					</div>
				<?php
				}
				?>
				<?= $alerta; ?>
			</form>	
		</nav>
	</div>
	<?php
	//Gestionar acció elegida
	switch ($accio) {
		//Accions d'Usuari
		case "mostrar":
			require_once "accio_mostrar.php";
			require_once "index_generar.php";
			break;
		case "absencies":
			require_once "accio_absencies.php";
			break;
		case "absencies_crear":
			require_once "accio_absencies_crear.php";
			require_once "accio_mostrar.php";
			break;
		case "notes":
			require_once "accio_notes.php";
			break;
		case "notes_crear":
			require_once "accio_notes_crear.php";
			require_once "accio_mostrar.php";
			break;
		case "assigna":
			require_once "accio_assigna.php";
			break;
		case "assigna_crear":
			require_once "accio_assigna_crear.php";
			require_once "accio_mostrar.php";
			break;
		case "reserves":
			require_once "accio_reserves.php";
			break;
		case "reserves_crear":
			require_once "accio_reserves_crear.php";
			require_once "accio_reserves.php";
			break;
		case "reserves_llista":
			require_once "accio_reserves_llista.php";
			break;
		case "professor-vore":			
			require_once "accio_professor_vore.php";
			break;			
		case "aules":			
			require_once "accio_aules.php";
			break;	
		//Accions d'usuari privilegiat
		case "control_manual":
			require_once "index_sense-permisos.php";
			require_once "accio_control_manual.php";
			break;
		case "control_llista":
			require_once "index_sense-permisos.php";
			require_once "accio_control_llista.php";
			break;
		case "control_elimina":
			require_once "index_sense-permisos.php";
			require_once "accio_control_elimina.php";
			require_once "accio_control_llista.php";
			break;	
		case "control_actes":
			require_once "index_sense-permisos.php";
			require_once "accio_control_actes.php";
			break;	
		case "control_vaga":
			require_once "index_sense-permisos.php";
			require_once "accio_control_vaga.php";
			break;		
		case "llistes_correu":
			//require_once "index_sense-permisos.php";
			require_once "accio_llistes_correu.php";
			break;	
		case "informe_ranking":
			require_once "index_sense-permisos.php";
			require_once "accio_informes.php";
			require_once "accio_informe_ranking.php";
			break;
		case "informe_base":
			require_once "index_sense-permisos.php";
			require_once "accio_informes.php";
			require_once "accio_informe_base.php";
			break;
		case "informes":
			require_once "index_sense-permisos.php";
			require_once "accio_informes.php";
			break;
		case "informes_crear":
			require_once "index_sense-permisos.php";
			require_once "accio_informes.php";
			require_once "accio_informes_crear.php";
			break;
		case "gestio":
			require_once "index_sense-permisos.php";
			require_once "accio_gestio.php";
			break;
		case "importar":
			require_once "index_sense-permisos.php";
			require_once "accio_importar_pregunta.php";
			break;
		case "importar_definitiu66":
			require_once "index_sense-permisos.php";
			require_once "accio_importar.php";
			break;
		case "grup":
			require_once "accio_grup.php";
			break;
		case "edocent":
			require_once "accio_edocent.php";
			break;
		case "edirectiu":
			require_once "index_sense-permisos.php";
			require_once "accio_edirectiu.php";
			break;
		case "professor":
			require_once "accio_professor.php";
			break;
		case "professor2":
				require_once "index_sense-permisos.php";
				require_once "accio_professor2.php";
			break;
		case "professor_editar":
			require_once "index_sense-permisos.php";
			require_once "accio_professor_editar.php";
			break;
		case "professor_crear":
			require_once "index_sense-permisos.php";
			require_once "accio_professor_crear.php";
			require_once "accio_professor.php";
			break;
		case "professor_sessio":
			require_once "index_sense-permisos.php";
			require_once "accio_professor_sessio.php";
			break;
		case "professor_sessio_crear":
			require_once "index_sense-permisos.php";
			require_once "accio_professor_sessio_crear.php";
			require_once "accio_professor.php";
			break;
		case "substitucio":
			require_once "index_sense-permisos.php";
			require_once "accio_substitucio.php";
			break;
		case "substitucio_crear":
			require_once "index_sense-permisos.php";
			require_once "accio_substitucio_crear.php";
			require_once "accio_substitucio.php";
			break;
		case "reserves_llista_completa":
			require_once "index_sense-permisos.php";
			require_once "accio_reserves_llista_completa.php";
			break;
		case "reserves_elimina":
			require_once "index_sense-permisos.php";
			require_once "accio_reserves_elimina.php";
			require_once "accio_reserves_llista.php";
			break;			
		//Acció per defecte
		default:
			require_once "accio_mostrar.php";
			break;
	}
	?>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>	

</body>

</html>