<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php    		
	//Si no existeix la BD agafar el default i fer la còpia
	if (!file_exists($config_bd_ruta)){
		copy($config_bd_ruta_default, $config_bd_ruta);
	}		

	//----- DROP i CREATE DE LES TAULES DEL SISTEMA -----
	echo "<div class=\"alert alert-info\" role=\"alert\">".IMPORTAR_BD."</div>";
	$db->drop("Guardia");
	$db->query("CREATE TABLE Guardia (ID INTEGER PRIMARY KEY AUTOINCREMENT, IDPROFESSOR INTEGER, DATA INTEGER, HORA INTEGER, COBERTAPER INTEGER, ACTIVITAT TEXT, OBSERVACIONS TEXT);");
	if ($db->error) {echo "<span class=\"alert alert-danger\" role=\"alert\">".IMPORTAR_ERROR_GUARDIA."</span>";}
	$db->drop("Professor");
	$db->query("CREATE TABLE Professor (ID	INTEGER PRIMARY KEY AUTOINCREMENT,NOM TEXT,MAIL TEXT,TUTESO TEXT,TUTBAT TEXT,TUTCF TEXT,TUTSEMI TEXT,COCOPE TEXT, DEP TEXT, DIR TEXT);");
	if ($db->error) {echo "<span class=\"alert alert-danger\" role=\"alert\">".IMPORTAR_ERROR_PROFESSOR."</span>";}
	$db->drop("Horari");
	$db->query("CREATE TABLE Horari (ID INTEGER PRIMARY KEY AUTOINCREMENT, IDPROFESSOR INTEGER, DATA INTEGER, HORA INTEGER, MATERIA TEXT, GRUP TEXT, AULA TEXT, TIPUS TEXT);");
	if ($db->error) {echo "<span class=\"alert alert-danger\" role=\"alert\">".IMPORTAR_ERROR_HORARI."</span>";}
	$db->drop("Notes");
	$db->query("CREATE TABLE Notes (ID INTEGER PRIMARY KEY AUTOINCREMENT, NOTES TEXT, DATA TEXT, HORA INTEGER);");
	if ($db->error) {echo "<span class=\"alert alert-danger\" role=\"alert\">".IMPORTAR_ERROR_NOTES."</span>";}
	$db->drop("Substitucions");
	$db->query("CREATE TABLE Substitucions (ID INTEGER PRIMARY KEY AUTOINCREMENT, PROFE INTEGER, SUBSTITUT INTEGER, DE TEXT, A TEXT);");
	if ($db->error) {echo "<span class=\"alert alert-danger\" role=\"alert\">".IMPORTAR_ERROR_SUBSTITUCIONS."</span>";}
	$db->drop("GuardiaLog");
	$db->query("CREATE TABLE GuardiaLog (ID INTEGER PRIMARY KEY AUTOINCREMENT, IDPROFESSOR INTEGER, DATA INTEGER, HORA INTEGER, LOGTIME TEXT);");
	if ($db->error) {echo "<span class=\"alert alert-danger\" role=\"alert\">".IMPORTAR_ERROR_GUARDIALOG."</span>";}
	$db->drop("Reserves");
	$db->query("CREATE TABLE Reserves (ID INTEGER PRIMARY KEY AUTOINCREMENT, IDPROFESSOR INTEGER, DATA INTEGER, HORA INTEGER, AULA TEXT, OBSERVACIONS TEXT);");
	if ($db->error) {echo "<span class=\"alert alert-danger\" role=\"alert\">".IMPORTAR_ERROR_RESERVES."</span>";}
	$db->drop("Control");
	$db->query("CREATE TABLE Control (ID INTEGER PRIMARY KEY AUTOINCREMENT, TIPO TEXT, IDPROFESSOR INTEGER, DATA INTEGER, HORA INTEGER, UBICACIO TEXT, LATITUD TEXT, LONGITUD TEXT, DATAHORA_CODI_APP TEXT, DATAHORA_QR_GENERAT TEXT);");
	if ($db->error) {echo "<span class=\"alert alert-danger\" role=\"alert\">".IMPORTAR_ERROR_CONTROL."</span>";}

	//----- IMPORTAR DADES DEL CSV -----	
	//Si no existeix, agafar el default i fer la còpia
	if (!file_exists($config_csv_ruta)){
		copy($config_csv_rutadefault, $config_csv_ruta);
	}		
	echo "<div class=\"alert alert-info\" role=\"alert\">".IMPORTAR_CSV." </div>";
	$rows = array_map(function($row) { return str_getcsv($row, ';'); }, file(''.$config_csv_carpeta.'/import.csv'));
	//----- CREATE PROFESSORS ----- Eliminar duplicats i ordenar
    echo "<div class=\"alert alert-info\" role=\"alert\">".IMPORTAR_PROFES."</div>";
	$professors=[];	
	foreach($rows as $row) {
		array_push($professors, $row[0]);
    }    
	$professors_unics=array_unique($professors);		
	sort($professors_unics);	
	$i=1;
	foreach ($professors_unics as $row) {				
		if (count($professors_unics) == $i){
			//Apareix un valor duplicat sempre al final i cal llevar-lo. NO SE PQ APAREIX???
		}else{
			$db->insert("Professor", array('ID' => $i, 'NOM' => $row));															;
			//echo $i." ".$row."<br>";
		}
		$i++;
	}
	//----- CREATE HORARI ----- Substituir NOM per ID en taula Horari
	echo "<div class=\"alert alert-info\" role=\"alert\">".IMPORTAR_HORARI."</div>";
	$horari=$rows;
	$i=1;
	foreach ($horari as $row) {		
		$id=array_search($row[0],$professors_unics)+1;
		$values="".$i.", ";
		$values=$values."'".$id."', ";
		$values=$values."'".$row[1]."', ";
		$values=$values."'".$row[2]."', ";		
		$values=$values."'".$row[3]."', ";
		$values=$values."'".$row[4]."', ";
		$values=$values."'".$row[5]."', ";				
		if ($row[6]==""){$values=$values."'G' ";}else{$values=$values."'".$row[6]."' ";}	//R1 i R2 s'importen sense TIPUS, cal afegir-lo ací	
		
		$db->query("INSERT INTO Horari (ID, IDPROFESSOR, DATA, HORA, MATERIA, GRUP, AULA, TIPUS) VALUES (".$values.");");
		//echo $i." ---> ".$values."<br>";
		$i++;
	}		
	echo "<div class=\"alert alert-success\" role=\"alert\">".IMPORTAR_COMPLETAT."</div>";	
?>