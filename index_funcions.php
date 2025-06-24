<?php if (!defined("VERSION")) {echo "No, no, no...";exit;} ?>
<?php

//Mostrar la data com una cadena de text amigable
//Utilitzada: index.php
function data_en_cadena($var)
{
	global $config_data_dies;
	global $config_data_mesos;
	$cadena = "";
	$date = DateTime::createFromFormat("Y-m-d", $var);
	$temp = strftime("%u", $date->getTimestamp());
	$temp = intval($temp) - 1;
	$cadena = $cadena . "" . $config_data_dies[$temp] . ", ";
	$temp = strftime("%e", $date->getTimestamp());
	$cadena = $cadena . "" . $temp . " ";
	$temp = strftime("%m", $date->getTimestamp());
	$temp = intval($temp) - 1;
	$cadena = $cadena . "" . $config_data_mesos[$temp] . "";
	$temp = strftime("%Y", $date->getTimestamp());
	$cadena = $cadena . " de " . $temp . " ";
	return $cadena;
}

//Calcular el dilluns de la setmana actual
function dilluns_setmana($var)
{
	$date = DateTime::createFromFormat("Y-m-d", $var);
	$day = strftime("%u", $date->getTimestamp());
	$day = intval($day) - 1;
	$week_start = date('Y-m-d', strtotime('-' . $day . ' days'));
	return $week_start;
}

//Calcular el divendres de la setmana actual
function divendres_setmana($var)
{
	$date = DateTime::createFromFormat("Y-m-d", $var);
	$day = strftime("%u", $date->getTimestamp());
	$day = intval($day) + 1;
	$week_end = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
	return $week_end;
}

//Calcular el dia actual en notació LMXJVSD
//Utilitzada: accio_mostrar.php
function dia_actual($var)
{
	$diaactual = date('N', strtotime($var));
	switch ($diaactual) {
		case 1:$dia = "L";break;
		case 2:$dia = "M";break;
		case 3:$dia = "X";break;
		case 4:$dia = "J";break;
		case 5:$dia = "V";break;
		case 6:$dia = "S";break;
		case 7:$dia = "D";break;
	}
	return $dia;
}

//Calcular el codi personal del Control Horari
function codi_validacio_control($var)
{
	$result = 0;
	$result = (100 + $var) * (100 + $var);
	$result = dechex($result);
	return $result;
}

?>