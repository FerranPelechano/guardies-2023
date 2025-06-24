<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$FMode = $_POST['mode'];  //0 es afegir i 1 eliminar
$FProfes = $_POST['selectProfes'];
$FDates = $_POST['dataTo'];
$FActivitat = $_POST['inputActivitat'];
$FObservacions = $_POST['textObservacions'];
$Fchecks="";
foreach ($config_intervals as $interval){	
	$nou = $_POST["inlineCheckbox".$interval];
	$Fchecks=$Fchecks."".$nou.",";
}
$Dies=explode(",",$FDates);
$Hores=explode(",",$Fchecks);
foreach ($FProfes as $Profe){
	foreach ($Dies as $Dia){
		//Mirar el dia del que consultar horari	
		$dia = dia_actual($Dia);
		//Comprovar SUBSTITUCIO-> Canviar idsubst per idprofe
		$es_substitut= $db->count('Substitucions', array('SUBSTITUT' => $Profe,'DE[<=]' => $Dia,'A[>=]'=>$Dia));
		if($es_substitut!=0){
			$aux_subs = $db->select('Substitucions(S)', ['PROFE'], array('SUBSTITUT' => $Profe,'DE[<=]' => $Dia,'A[>=]'=>$Dia));
			foreach($aux_subs as $aux_sub){      
				$nouProfe = $aux_sub['PROFE'];
			}			
			$Profe=$nouProfe;
		}		
		foreach ($Hores as $Hora){	
			//Els usuaris normals sols poden insertar o eliminar en dates actuals o futures!
			$passat=false;
			if ($username=="admin" || strtotime($Dia) >= strtotime($data)){$passat=true;}			
			if($passat){
				if ($FMode == "0"){
					// MODE AFEGIR ABSENCIES
				    if ($Hora==""){
				        //No cal fer res
				        }else{
				    	//Comprobar si tenim ja una Guardia creada al sistema per evitar duplicats
				    	$contar_guardies = $db->count('Guardia', array('IDPROFESSOR' => $Profe,'DATA' => $Dia,'HORA'=>$Hora));				
				    	if ($contar_guardies==0){					
				    		//Comprovar que el docent té sessió d'horari que cobrir
			    			//Registrar sols les LEC i G
							//$contar_sessio = $db->count('Horari', array('IDPROFESSOR' => $Profe,'DATA' => $dia,'HORA'=>$Hora, 'TIPUS' => ['LEC','G']));										
							//Registrar Totes les sessions
							$contar_sessio = $db->count('Horari', array('IDPROFESSOR' => $Profe,'DATA' => $dia,'HORA'=>$Hora));
			    			if ($contar_sessio!=0){								
				    			  $db->insert("Guardia", array('IDPROFESSOR' => $Profe,'DATA' => $Dia,'HORA'=>$Hora, 'ACTIVITAT' => $FActivitat, 'OBSERVACIONS' => $FObservacions));
				    		}			    			
				    	}else{
				    		//No creem el duplicat
				    	}
				    }				
				}else{
					//Vore si existeix registre
					$contar_guardies = $db->count('Guardia', array('IDPROFESSOR' => $Profe,'DATA' => $Dia,'HORA'=>$Hora));				
					if ($contar_guardies==0){
						//No hi ha registre, no cal fer res
					}else{
						//MODE ELIMINAR ABSENCIES
						$db->delete("Guardia", array('AND' => ['IDPROFESSOR' => $Profe,'DATA' => $Dia,'HORA'=>$Hora]));
						//Fer LOG de l'esborrat
						$Ara = date("Y-m-d H:i:s");
						$db->insert("GuardiaLog", array('IDPROFESSOR' => $Profe,'DATA' => $Dia,'HORA'=>$Hora, 'LOGTIME' => $Ara));
					}
				}
			};
		}
	};
};
?>