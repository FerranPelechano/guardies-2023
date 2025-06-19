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
    <div class="container-fluid"> 
      <h4><?=INDEX_CONTROL_TITUL;?></h4>
      <?php
      //Obtenir valors del QR enviat
      $Fcadena = $_GET['cadena'];
      $cadena = explode ("|",$Fcadena);
      // ----------------------------------------
      // 0 IN/OUT
      // 1 idprofessor
      // 2 data
      // 3 hora
      // 4 Ubicació
      // 5 Latitud
      // 6 Longitud
      // 7 Ultim canvi de codi en APP "DATA HORA"
      // 8 BUIT - DataHora Generació QR (2+3)
      // 9 BUIT - Data Actual
      // 10 BUIT - Hora Actual
      // ----------------------------------------
      $cadena[8]=$cadena[2]." ".$cadena[3];
      $cadena[9]=date("Y-m-d");
      $cadena[10]=date("H:i:s");
      
      //Comprovar si existeix la mateixa entrada QR            
      $controls = $db->select("Control", array('ID'), array('AND' => ['IDPROFESSOR' => $cadena[1], 'TIPO' => $cadena[0],  'UBICACIO' => $cadena[4],  'LATITUD' => $cadena[5],  'LONGITUD' => $cadena[6],  'DATAHORA_CODI_APP' => $cadena[7], 'DATAHORA_QR_GENERAT'=> $cadena[8]]));	
      $controls_num=count($controls);
      if ($controls_num==0){
        //Insertar entrada

        $missatge="";
        if ($cadena[1]!=""){					
          $db->insert("Control", array('IDPROFESSOR' => $cadena[1], 'TIPO' => $cadena[0],  'DATA' => $cadena[9],  'HORA' => $cadena[10],  'UBICACIO' => $cadena[4],  'LATITUD' => $cadena[5],  'LONGITUD' => $cadena[6],  'DATAHORA_CODI_APP' => $cadena[7], 'DATAHORA_QR_GENERAT'=> $cadena[8]));	
          //Contestar
          if($cadena[0] == "IN"){
            $missatge = "<b>".INDEX_CONTROL_ENTRADA."</b><br>";
            $missatge_alert="alert-success";
          }
          if($cadena[0] == "OUT"){
            $missatge = "<b>".INDEX_CONTROL_EIXIDA."</b><br>";
            $missatge_alert="alert-info";
          }        
          
          //Mostrar dades del Guardat        
          $profes = $db->select('Professor', array('ID','NOM'), array('AND' => ['ID' => $cadena[1]]));  	  
          foreach ($profes as $profe){
            $profe_id = $profe['ID'];		
            $profe_nom = $profe['NOM'];		
            $missatge.= " <b>[".$profe_id."]</b> ".$profe_nom."<br>";
          }		        
          $missatge.=$cadena[9]." ".$cadena[10]."<br>";        
          $missatge.="QR generat: ".$cadena[8];
          echo "<div class=\"alert ".$missatge_alert."\" role=\"alert\">".$missatge."</div>";
        }else{
          $missatge=INDEX_CONTROL_ENTRADA;
          $missatge_alert="alert-danger";
          echo "<div class=\"alert ".$missatge_alert."\" role=\"alert\">".$missatge."</div>";
        }

      }else{
        //No introduïr perquè ja està dins de sistema
        $missatge=INDEX_CONTROL_REPETIT;
        $missatge_alert="alert-danger";
        echo "<div class=\"alert ".$missatge_alert."\" role=\"alert\">".$missatge."</div>";
      }
      

      ?>            


    </div>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>