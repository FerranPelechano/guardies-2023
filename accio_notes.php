<?php if (!defined("VERSION")){ echo "No, no, no...";exit;}?>
<?php
$Fdata = $_GET['data'];
$Fhora = $_GET['hora'];
$Fnotes = $db->select(
    'Notes(N)',
    array('N.ID','N.NOTES'),
    array('AND' => array('DATA' => ''.$Fdata.'', 'HORA'=>''.$Fhora.''))
);	  
$cadena_notes="";
$Fnota_id=0;
foreach ($Fnotes as $nota){
	  $Fnota_id = $nota['ID'];
	  $nota_notes = $nota['NOTES'];
	  $cadena_notes=$cadena_notes.$nota_notes;
}
?>
<div class="container-fluid">     
    <h4><?=NOTES_TITUL;?> (<?=data_en_cadena($Fdata)." ".NOTES_A_LES." ".$config_hores[$Fhora];?>)</h4>
    <form  method="post" action="index.php?accio=notes_crear&data=<?=$Fdata;?>">
        <div class="form-group">
            <label for="labelObservacions"><?=NOTES_OBSERVACIONS;?></label>
            <textarea class="form-control" id="textObservacions" name="textObservacions" rows="3"><?=$cadena_notes;?></textarea>
        </div>
	      <br>
        <div class="form-group">	
		    <button type="button" class="btn btn-outline-primary btn-sm" onclick="textObservacions.value='';"><?=NOTES_NETEJAR;?></button>
            <input type="hidden"  name="Fdata" id="data" value="<?=$Fdata;?>">
            <input type="hidden"  name="Fhora" id="hora" value="<?=$Fhora;?>">
            <input type="hidden"  name="Fnota_id" id="nota_id" value="<?=$Fnota_id;?>">
		        <button type="submit" class="btn btn-primary"><?=NOTES_DESAR;?></button>	
	      </div>
    </form>
</div>