<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
//----- Llevar carrecs i departaments de substituts que ja no estiguen alcentre -----
$query = "SELECT P.* FROM Professor AS P LEFT JOIN Substitucions AS S ON S.SUBSTITUT=P.ID WHERE S.PROFE IS NOT NULL AND S.A<'".date("Y-m-d")."'";
//echo $query."<br>";
$llista_llevar = $db->query($query)->fetchAll();
$missatge_alert="";
foreach($llista_llevar as $valor){  
  $condicio="";
  $condicio=$valor['COCOPE'].$valor['TUTESO'].$valor['TUTBAT'].$valor['TUTCF'].$valor['TUTSEMI'].$valor['DEP'];
  if($condicio!=""){  
    $query = "UPDATE Professor SET COCOPE='', TUTESO='', TUTBAT='', TUTCF='', TUTSEMI='', DEP='' WHERE ID=".$valor['ID'];    
    //echo $query."<br>";
    $eliminar = $db->query($query)->fetchAll();
    $missatge_alert.=$valor['NOM']." (".$valor['ID'].") ";
  }
}
if ($missatge_alert!=""){echo "<div class='alert alert-warning' role='alert'>".LC_MISSATGE_ALERT.$missatge_alert."</div>";}

//----- Departaments -----
$query = "SELECT * FROM Professor AS PRO ORDER BY PRO.DEP, PRO.NOM";
$llista_departament = $db->query($query)->fetchAll();
$cadena_dep="";
$dep_actual="";
$cadena_dep.="<b>".LC_SENSEDEP."</b> ";
$cadena_dep.="<button class='btn btn-outline-secondary btn-sm' id='copy' onclick=\"$('#ta-').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
$cadena_dep.="<textarea class='form-control' id='ta-' rows='1' readonly>";
$i=0;
foreach($llista_departament as $valor){
    if ($dep_actual==$valor['DEP']){
        if($valor['MAIL']!=""){$cadena_dep.=$valor['MAIL'].",";}        
    }else{
        $dep_actual=$valor['DEP'];
        $i++;
        //$cadena_dep = substr($cadena_dep,0,-1);
        $cadena_dep.="</textarea>";
        $cadena_dep.="<b>".$valor['DEP']."</b> ";        
        $cadena_dep.="<button class='btn btn-outline-secondary btn-sm' id='copy".$i."' onclick=\"$('#ta-".$i."').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
        $cadena_dep.="<textarea class='form-control' id=ta-".$i." rows='1' readonly>";
        if($valor['MAIL']!=""){$cadena_dep.=$valor['MAIL'].",";}
    }           
}
$cadena_dep.="</textarea>";
//-----
//----- Cocope + Tutories ESO BAT CF SEMI DIR -----
//COCOPE
$query = "SELECT * FROM Professor AS PRO WHERE COCOPE='on'ORDER BY PRO.NOM";
$llista = $db->query($query)->fetchAll();
$cadena_cocope="";
$cadena_cocope.="<b>".LC_TAULA_5."</b> ";
$cadena_cocope.="<button class='btn btn-outline-secondary btn-sm' id='copyb1' onclick=\"$('#tb1-').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
$cadena_cocope.="<textarea class='form-control' id='tb1-' rows='1' readonly>";
foreach($llista as $valor){
    if($valor['MAIL']!=""){$cadena_cocope.=$valor['MAIL'].",";}
}
$cadena_cocope.="</textarea>";
//TUT ESO
$query = "SELECT * FROM Professor AS PRO WHERE TUTESO='on'ORDER BY PRO.NOM";
$llista = $db->query($query)->fetchAll();
$cadena_tuteso="";
$cadena_tuteso.="<b>".LC_TAULA_6."</b> ";
$cadena_tuteso.="<button class='btn btn-outline-secondary btn-sm' id='copyb2' onclick=\"$('#tb2-').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
$cadena_tuteso.="<textarea class='form-control' id='tb2-' rows='1' readonly>";
foreach($llista as $valor){
    if($valor['MAIL']!=""){$cadena_tuteso.=$valor['MAIL'].",";}
}
$cadena_tuteso.="</textarea>";
//TUTBAT
$query = "SELECT * FROM Professor AS PRO WHERE TUTBAT='on'ORDER BY PRO.NOM";
$llista = $db->query($query)->fetchAll();
$cadena_tutbat="";
$cadena_tutbat.="<b>".LC_TAULA_7."</b> ";
$cadena_tutbat.="<button class='btn btn-outline-secondary btn-sm' id='copyb3' onclick=\"$('#tb3-').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
$cadena_tutbat.="<textarea class='form-control' id='tb3-' rows='1' readonly>";
foreach($llista as $valor){
    if($valor['MAIL']!=""){$cadena_tutbat.=$valor['MAIL'].",";}
}
$cadena_tutbat.="</textarea>";
//TUT CF
$query = "SELECT * FROM Professor AS PRO WHERE TUTCF='on'ORDER BY PRO.NOM";
$llista = $db->query($query)->fetchAll();
$cadena_tutcf="";
$cadena_tutcf.="<b>".LC_TAULA_8."</b> ";
$cadena_tutcf.="<button class='btn btn-outline-secondary btn-sm' id='copyb4' onclick=\"$('#tb4-').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
$cadena_tutcf.="<textarea class='form-control' id='tb4-' rows='1' readonly>";
foreach($llista as $valor){
    if($valor['MAIL']!=""){$cadena_tutcf.=$valor['MAIL'].",";}
}
$cadena_tutcf.="</textarea>";
//TUT SEMI
$query = "SELECT * FROM Professor AS PRO WHERE TUTSEMI='on'ORDER BY PRO.NOM";
$llista = $db->query($query)->fetchAll();
$cadena_tutsemi="";
$cadena_tutsemi.="<b>".LC_TAULA_9."</b> ";
$cadena_tutsemi.="<button class='btn btn-outline-secondary btn-sm' id='copy5' onclick=\"$('#tb5-').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
$cadena_tutsemi.="<textarea class='form-control' id='tb5-' rows='1' readonly>";
foreach($llista as $valor){
    if($valor['MAIL']!=""){$cadena_tutsemi.=$valor['MAIL'].",";}
}
$cadena_tutsemi.="</textarea>";
//DIR
$query = "SELECT * FROM Professor AS PRO WHERE DIR='on'ORDER BY PRO.NOM";
$llista = $db->query($query)->fetchAll();
$cadena_dir="";
$cadena_dir.="<b>".LC_TAULA_11."</b> ";
$cadena_dir.="<button class='btn btn-outline-secondary btn-sm' id='copy6' onclick=\"$('#tb6-').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
$cadena_dir.="<textarea class='form-control' id='tb6-' rows='1' readonly>";
foreach($llista as $valor){
    if($valor['MAIL']!=""){$cadena_dir.=$valor['MAIL'].",";}
}
$cadena_dir.="</textarea>";
//Conformar resultat final
$cadena_carrec=$cadena_cocope.$cadena_tuteso.$cadena_tutbat.$cadena_tutcf.$cadena_tutsemi.$cadena_dir;
//-----
//----- Equips Docents (amb substituts i no titulars)-----
$query="SELECT DISTINCT P.NOM, P.MAIL AS MAIL, H.GRUP, S.DE AS D, S.A AS A, P1.NOM, P1.MAIL AS MAIL2 FROM Horari AS H LEFT JOIN Professor AS P ON H.IDPROFESSOR = P.ID LEFT JOIN Substitucions AS S ON S.PROFE=P.ID LEFT JOIN Professor AS P1 ON S.SUBSTITUT=P1.ID WHERE H.GRUP<>'' ORDER BY H.GRUP, P.NOM";
$llista_ed = $db->query($query)->fetchAll();
$cadena_ed="";
$ed_actual="";
$cadena_ed.="<b>".LC_SENSEED."</b> ";
$cadena_ed.="<button class='btn btn-outline-secondary btn-sm' id='copyed' onclick=\"$('#taed-').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
$cadena_ed.="<textarea class='form-control' id='taed-' rows='1' readonly>";
$i=0;
foreach($llista_ed as $valor){
  //Si tenim substitut actiu elegim mail de substitut
  $mail_temporal="";
  if($valor['MAIL2']!="" && $valor['A']>=date("Y-m-d") && $valor['DE']<date("Y-m-d")){$mail_temporal=$valor['MAIL2'];}else{$mail_temporal=$valor['MAIL'];}
  //--
  if ($ed_actual==$valor['GRUP']){               
        if($mail_temporal!=""){$cadena_ed.=$mail_temporal.",";}        
    }else{
        $ed_actual=$valor['GRUP'];
        $i++;
        //$cadena_ed = substr($cadena_ed,0,-1);
        $cadena_ed.="</textarea>";
        $cadena_ed.="<b>".$valor['GRUP']."</b> ";        
        $cadena_ed.="<button class='btn btn-outline-secondary btn-sm' id='copyed".$i."' onclick=\"$('#taed-".$i."').select();document.execCommand('copy');\">".LC_COPIAR."</button>";
        $cadena_ed.="<textarea class='form-control' id=taed-".$i." rows='1' readonly>";
        if($mail_temporal!=""){$cadena_ed.=$mail_temporal.",";}        
    }           
}
$cadena_ed.="</textarea>";
//-----
//----- Taula docents amb AF -----
$query ="SELECT PRO.*, (SELECT H.DATA FROM Horari AS H WHERE TIPUS='AF' AND H.IDPROFESSOR=PRO.ID) AS DATA,(SELECT H.HORA FROM Horari AS H WHERE TIPUS='AF' AND H.IDPROFESSOR=PRO.ID) AS HORA FROM Professor AS PRO ORDER BY PRO.NOM";
$llista_docents = $db->query($query)->fetchAll();
$cadena_taula="";
foreach ($llista_docents as $docent){    
    $cadena_taula.="<tr>";
    $cadena_taula.="<td>".$docent['ID']."</td>";
    $cadena_taula.="<td>".$docent['NOM']."</td>";
    $cadena_taula.="<td>".$docent['MAIL']."</td>";
    $cadena_taula.="<td>".$docent['DEP']."</td>";
    if($docent['COCOPE']=="on"){$valor="X";}else{$valor="";}
    $cadena_taula.="<td>".$valor."</td>";
    if($docent['TUTESO']=="on"){$valor="X";}else{$valor="";}
    $cadena_taula.="<td>".$valor."</td>";
    if($docent['TUTBAT']=="on"){$valor="X";}else{$valor="";}
    $cadena_taula.="<td>".$valor."</td>";
    if($docent['TUTCF']=="on"){$valor="X";}else{$valor="";}
    $cadena_taula.="<td>".$valor."</td>";
    if($docent['TUTSEMI']=="on"){$valor="X";}else{$valor="";}
    $cadena_taula.="<td>".$valor."</td>";
    $cadena_taula.="<td>".$docent['DATA']."-".$config_hores[$docent['HORA']]."</td>";
    $cadena_taula.="</tr>";
}
//-----
?>
<div class="container-fluid">     
    <div class="accordion" id="accordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading1">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
          <h4><?=LC_DEP;?></h4>
          </button>
        </h2>
        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#accordion">
          <div class="accordion-body">
            <?=$cadena_dep;?>        
          </div>
        </div>
      </div>
    </div>

    <div class="accordion" id="accordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
          <h4><?=LC_CARREC;?></h4>
          </button>
        </h2>
        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#accordion">
          <div class="accordion-body">
            <?=$cadena_carrec;?>        
          </div>
        </div>
      </div>
    </div>

    <div class="accordion" id="accordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading3">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
          <h4><?=LC_ED;?></h4>
          </button>
        </h2>
        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#accordion">
          <div class="accordion-body">
            <?=$cadena_ed;?>
          </div>
        </div>
      </div>
    </div>    

    <div class="accordion" id="accordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading4">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
          <h4><?=LC_TAULA_TITUL;?></h4>
          </button>
        </h2>
        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#accordion">
          <div class="accordion-body">
              <table class="table table-sm table-bordered table-striped">
                <thead>    
                    <tr>
                        <th><?=LC_TAULA_1;?></th>
                        <th><?=LC_TAULA_2;?></th>
                        <th><?=LC_TAULA_3;?></th>
                        <th><?=LC_TAULA_4;?></th>
                        <th><?=LC_TAULA_5;?></th>
                        <th><?=LC_TAULA_6;?></th>
                        <th><?=LC_TAULA_7;?></th>
                        <th><?=LC_TAULA_8;?></th>
                        <th><?=LC_TAULA_9;?></th>
                        <th><?=LC_TAULA_10;?></th>
                    </tr>
                </thead>
                <tbody><?=$cadena_taula;?></tbody>
            </table>        
          </div>
        </div>
      </div>
    </div>
</div>


