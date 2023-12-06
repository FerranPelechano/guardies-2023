<?php if (!defined("VERSION")) {echo "No, no, no...";exit;} ?>
<?php
//Configuració general
$usuari_privilegiat="admin";
$config_columnes=false; //Configurar 2n 2 columnes (true) o sols en 1 (false)
$config_semafor=true; //Configurar colors d'advertència en semafor (true) o en fons (false)
$config_paginacio_control_diari=10; //Repetir encapçalament cada x files
$config_mostrar_reserves=true; //Mostrar reserves en pàgina principal
//Conexió a BD
require_once "lib/Medoo.php";
use Medoo\Medoo;
$config_bd_carpeta="bd";
$config_bd_carpeta_backup="backup";
$config_bd_nomfitxer="Guardies.db";
$config_bd_ruta=$config_bd_carpeta."/".$config_bd_nomfitxer;
$config_bd_ruta_default=$config_bd_carpeta."/default-".$config_bd_nomfitxer;
$db = new Medoo(['type' => 'sqlite','database' => $config_bd_ruta]);

//Fitxer d'importació
$config_csv_carpeta="import";
$config_csv_nomfitxer="import.csv";
$config_csv_ruta=$config_csv_carpeta."/".$config_csv_nomfitxer;
$config_csv_rutadefault=$config_csv_carpeta."/default-".$config_csv_nomfitxer;;

//Configuració de franges horaries: R indica patis
$config_mati="1,2,3,R1,4,5,6,R2,7";
$config_vesprada="7,8,9,10,R3,11,12,13";
$config_dia="1,2,3,R1,4,5,6,R2,7,7,8,9,10,R3,11,12,13";
$config_intervals=["1" ,"2" ,"3" ,"R1","4" ,"5" ,"6" ,"R2","7" ,"8" ,"9" ,"10","R3","11","12","13"];
$config_intervals_hores=["08:00","08:55","09:50","10:45","11:15","12:10","13:05","14:00","14:30","15:25","16:20","17:15","18:10","18:30","19:25","20:20"];
$config_hores=["1" => "8:00","2" => "8:55","3" => "9:50","R1" => "10:45","4" => "11:15","5" => "12:10","6" => "13:05","R2" => "14:00","7" => "14:30","8" => "15:25","9" => "16:20","10" => "17:15","R3" => "18:10","11" => "18:30",	"12" => "19:25","13" => "20:20"];
$config_temps=["1" => "55","2" => "55","3" => "55","R1" => "30","4" => "55","5" => "55","6" => "55","R2" => "20","7" => "55","8" => "55","9" => "55","10" => "55","R3" => "20","11" => "55", "12" => "55","13" => "55"];
$config_dies_setmana=["L","M","X","J","V"];

//Configuració dies i mesos
$config_data_dies=[DIA_1,DIA_2,DIA_3,DIA_4,DIA_5,DIA_6,DIA_7];
$config_data_mesos=[MES_1,MES_2,MES_3,MES_4,MES_5,MES_6,MES_7,MES_8,MES_9,MES_10,MES_11,MES_12];

//$config_info_aules=["A01 MULTIUSOS" => "20 Portàtils","B01 BIBLIOTECA" => "24 Tauletes", "C13 GH" => "30 Portàtils", "B25 TALLER INF (+B24)" => "Portàtils 12 CF", "C21 FILO+ANG" => "EOI la utilitza L-M-X-J de 16h-20h","C22 ANG" => "EOI la utilitza L-M-X-J de 16h-20h", "GIMNÀS"=>"Cal consultar els horaris de PATI1 i PATI2 perquè es gasten alhora!" ];
$config_info_aules=["A01" => "20 Portàtils","B00" => "18 Portàtils", "C03" => "30 Portàtils", "B24" => "Portàtils 12 CF", "C21" => "EOI MJ 16h-20h","C22" => "EOI LMXJ de 16h-20h", "GIMNÀS"=>"Cal consultar els horaris de PATI1 i PATI2 perquè es gasten alhora!", "C15"=>"Aula Lliurex 24 PCs Fixes", "B33"=>"16 Tauletes","P6"=>"24 Tauletes" ];

//Departaments
$config_departaments=["Anglés","Biologia i Geologia","Castellà","Economia","Educacio Fisica","Educació Plàstica i Visual","Filosofia","Física i Química","FOL","Francés","Geografia i Història","Hosteleria i Turisme","Informàtica i Comunicacions","Llatí i Grec","Matemàtiques","Música","Orientació","Religió","Serveis Socioculturals i a la Comunitat","Tecnologia","Valencià"];