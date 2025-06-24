<?php if (!defined("VERSION")) {echo "No, no, no...";exit;} ?>
<?php
//accio_aules.php
define("AULES_TITUL", "Aules Lliures");
define("AULES_DESC", "Si l'aula està lliure, pots reservar-la fent clic al botó corresponent. Apareix en roig si l'aula té reserves pendents (en qualsevol dia i franja!) i caldrà comprovar si en l'espai desitjat la tens disponible.");
define("AULES_RESERVADA", "R");
define("AULES_LLIURE", "Lliure");
//accio_absencies.php
define("ABSENCIES_TITUL", "Introduïr absències de professorat");
define("ABSENCIES_COMMUTA", "Conmuta de mode (AFEGIR / ELIMINAR)");
define("ABSENCIES_COMMUTA_AFEGIR_TXT", "Estem en mode AFEGIR");
define("ABSENCIES_COMMUTA_AFEGIR", "Afegir");
define("ABSENCIES_COMMUTA_ELIMINAR_TXT", "Estem en mode ELIMINAR");
define("ABSENCIES_COMMUTA_ELIMINAR", "Eliminar");
define("ABSENCIES_LABEL_PROFES", "Professorat (CTRL+clic per selecció múltiple)");
define("ABSENCIES_LABEL_MC", "Mati Complet");
define("ABSENCIES_LABEL_VC", "Vesprada Completa");
define("ABSENCIES_LABEL_DC", "Dia Complet");
define("ABSENCIES_LABEL_NETEJAR", "Netejar");
define("ABSENCIES_LABEL_ACTIVITAT", "Activitat");
define("ABSENCIES_LABEL_OBSERVACIONS", "Observacions");
define("ABSENCIES_LABEL_PF", "Permís de Formació");
define("ABSENCIES_LABEL_A5", "Visita a Empresa FCT/DUAL");
define("ABSENCIES_MSG_HORA", "No has elegit cap HORA!");
define("ABSENCIES_MSG_PROFE", "No has elegit cap PROFESSOR!");
define("ABSENCIES_MSG_DATA", "No has elegit cap DATA!");
define("ABSENCIES_LABEL_AVISO", "Sols es poden Afegir/Eliminar esdeveniments Actuals o Futurs!");
//accio_assigna.php
define("ASSIGNA_TITUL", "Introduïr assignació");
define("ASSIGNA_A_LES", "a les");
define("ASSIGNA_SELECT_ELIMINA", "Eliminar assignació prèvia");
define("ASSIGNA_SELECT_GUARDIA", "Professorat de Guardia");
define("ASSIGNA_SELECT_LLISTA", "Llista completa");
define("ASSIGNA_DESAR", "Desar");
//accio_control_actes.php
define("CONTROL_ACTES_TITUL", "Full de Control d'Actes");
//accio_control_llista.php
//accio_control_vaga.php
define("CONTROL_VAGA_TITUL", "Full de Control Diari");
//accio_reserves_llista.php
define("CONTROL_TH_1", "#");
define("CONTROL_TH_2", "Tipus");
define("CONTROL_TH_3", "Professor");
define("CONTROL_TH_4", "Data");
define("CONTROL_TH_5", "Hora");
define("CONTROL_TH_6", "Map/APP/QR");
define("CONTROL_TH_7", "Total = Acumulat - Horari");
define("CONTROL_TH_8", "Accions");
define("CONTROL_LLISTA_ELIMINA", "Elimina");
//accio_gestio.php
define("GESTIO_TITUL", "Gestió de camps extra");
define("GESTIO_LABEL_MATERIA", "Materia");
define("GESTIO_LABEL_GRUP", "Grup");
define("GESTIO_LABEL_AULA", "Aula");
define("GESTIO_LABEL_TIPUS", "Tipus");
define("GESTIO_LABEL_SUBMIT", "Desar");
define("GESTIO_ALERT_MATERIA", "Materia afegida: ");
define("GESTIO_ALERT_GRUP", "Grup afegit: ");
define("GESTIO_ALERT_AULA", "Aula afegida: ");
define("GESTIO_ALERT_TIPUS", "Tipus afegit: ");
//accio_importar_pregunta.php
define("IMPORTAR_PREGUNTA_1", "El procés d'Importació de dades restablirà el programa a l'estat inicial!");
define("IMPORTAR_PREGUNTA_2", "Ha arribat el moment... Executeu ordre 66!");
//accio_importar.php
define("IMPORTAR_BD", "DROP i CREATE DE LES TAULES DEL SISTEMA");
define("IMPORTAR_ERROR_GUARDIA", "Error GUARDIA");
define("IMPORTAR_ERROR_PROFESSOR", "Error PROFESSOR");
define("IMPORTAR_ERROR_HORARI", "Error HORARI");
define("IMPORTAR_ERROR_NOTES", "Error NOTES");
define("IMPORTAR_ERROR_SUBSTITUCIONS", "Error SUBSTITUCIONS");
define("IMPORTAR_ERROR_GUARDIALOG", "Error GUARDIALOG");
define("IMPORTAR_ERROR_RESERVES", "Error RESERVES");
define("IMPORTAR_ERROR_CONTROL", "Error CONTROL");
define("IMPORTAR_CSV", "IMPORTAR DADES DEL CSV");
define("IMPORTAR_PROFES", "AFEGIR DADES DE PROFESSORS");
define("IMPORTAR_HORARI", "AFEGIR DADES D'HORARI");
define("IMPORTAR_COMPLETAT", "PROCÉS COMPLETAT!");
//accio_informe_base.php
define("INFORME_BASE_TH_1", "Data");
define("INFORME_BASE_TH_2", "Hora");
define("INFORME_BASE_TH_3", "Absent");
define("INFORME_BASE_TH_4", "Guarda");
define("INFORME_BASE_TH_5", "Observacions");
define("INFORME_BASE_TH_6", "Activitat");
define("INFORME_BASE_TH_7", "Eliminat");
define("INFORME_BASE_DESDE", "Informe desde");
//accio_informes_crear.php
define("INFORMES_CREAR_TH_1", "Data");
define("INFORMES_CREAR_TH_2", "Hora");
define("INFORMES_CREAR_TH_3", "Absent");
define("INFORMES_CREAR_TH_4", "Guarda");
define("INFORMES_CREAR_TH_5", "Observacions");
define("INFORMES_CREAR_TH_6", "Activitat");
define("INFORMES_CREAR_TH_7", "Eliminat");
define("INFORMES_CREAR_INFORME", "Informe");
define("INFORMES_CREAR_A", "a");
//accio_informe_ranking.php
define("INFORME_RANKING", "Rànquing de Guàrdies, Convivències i  Absències");
define("INFORME_RANK_TH_1", "Professor");
define("INFORME_RANK_TH_2", "Total");
define("INFORME_RANK_TH_3", "Guardies");
define("INFORME_RANK_TH_4", "Convivències");
define("INFORME_RANK_TH_5", "Gràfic");
define("INFORME_RANK_TH_6", "Absències");
define("INFORME_RANK_TH_7", "Dies de Formació");
define("INFORME_RANK_TH_8", "Visites FCT/DUAL");
define("INFORME_RANKING_TOTALS", "Totals Guàrdies, Convivències i  Absències");
define("RANKING_MODAL_TITUL", "Dies de Formació");
define("RANKING_MODAL2_TITUL", "Visites Empreses FCT/DUAL");
define("RANKING_MODAL_TANCAR", "Tancar");
//accio_informes.php
define("INFORMES_TITUL", "Generador d'informes");
define("INFORMES_GENERAR", "Generar Informe");
define("INFORMES_0", "Setmana actual (Guàrdies)");
define("INFORMES_1", "Setmana actual (Convivència)");
define("INFORMES_2", "Setmana actual (Eliminats)");
define("INFORMES_3", "Informe: Ranking Global");
define("INFORMES_BASE", "Informe: D'avui al final");
define("INFORMES_ERROR_INICI", "No has elegit cap DATA d'INICI!");
define("INFORMES_ERROR_FINAL", "No has elegit cap DATA DE FI");
define("INFORMES_LABEL_PROFES", "Professorat (CTRL+clic per selecció múltiple)");
define("INFORMES_SELECT", "Escull Professors");
define("INFORMES_DATA_INICI", "Data Inicial");
define("INFORMES_DATA_FI", "Data Final");
define("INFORMES_MOSTRAR_CONVIVENCIA", "Mostrar Convivència");
define("INFORMES_MOSTRAR_ELIMINATS", "Eliminats");
//accio_mostrar.php
define("MOSTRAR_ALERT_PASSAT","No es pot accedir a dates passades!");
define("MOSTRAR_TH_1", "Hora");
define("MOSTRAR_TH_2", "Professorat de Guàrdia");
define("MOSTRAR_TH_3", "Absències");
define("MOSTRAR_TH_4", "Observacions");
define("MOSTRAR_TH_5", "#");
define("MOSTRAR_CONVIVENCIA", "Convivència");
define("MOSTRAR_PROTOCOL_TITUL", "Professorat Reserva amb permanència al centre");
define("MOSTRAR_PROTOCOL_TEXT", "<p><b>Protocol per a cobrir les absències del professorat: </b></p><ol><li>Codocència o grups desdoblats: es farà càrrec l'altre professor/a del grup. </li><li>Grup sense professorat: es farà càrrec el professorat de Guàrdia.</li></ol><p><b>En cas que el professorat de Guàrdia siga insuficient, es farà càrrec la resta del professorat seguint aquest ordre:</b></p><ol><li>Cap de Departament de l'assignatura del professorat absent, sempre que tinga a eixa hora CD. </li><li>Cap de Departament de qualsevol assignatura, sempre que tinga en eixa hora una CD. </li><li>Professorat que tinga en eixa hora una AC. </li><li>Professorat que tinga en eixa hora una AF. </li><li>Professorat que tinga en eixa hora RD.</li></ol>");
define("MOSTRAR_PROTOCOL_TANCAR", "Tancar");
define("MOSTRAR_RESERVES_TITUL", "Aules Reservades");
define("MOSTRAR_RESERVES_TANCAR", "Tancar");
define("MOSTRAR_CONTROL_TITUL", "Control de Guàrdies");
define("MOSTRAR_CONTROL_TOTAL", "Total");
define("MOSTRAR_CONTROL_GUARDIES", "Guàrdies");
define("MOSTRAR_CONTROL_CONVIVENCIA", "Convivències");
define("MOSTRAR_PATI_1", "Pati Zona A1");
define("MOSTRAR_PATI_2", "Pati Zona B1");
define("MOSTRAR_PATI_3", "Pati Zona C1");
define("MOSTRAR_PATI_4", "Pati Zona Pigmalió");
define("MOSTRAR_PATI_5", "Pati Zona Cantina");
define("MOSTRAR_PATI_6", "Pati Zona Gimnàs");
define("MOSTRAR_PATI_7", "Consergeria");
//accio_notes.php
define("NOTES_TITUL", "Introduïr observacions");
define("NOTES_A_LES", "a les");
define("NOTES_OBSERVACIONS", "Observacions");
define("NOTES_NETEJAR", "Netejar");
define("NOTES_DESAR", "Desar");
//accio_grup.php
define("GRUP_TITUL", "Grup");
define("GRUP_LABEL_GRUP", "Seleccionar Grup");
define("GRUP_LABEL_SUBMIT", "Horari");
define("GRUP_HORARI", "Horari de grup");
define("GRUP_HORA", "Hora");
//accio_edocent.php
define("EDOCENT_TITUL", "Horari d'Equip Docent");
define("EDOCENT_LABEL_GRUP", "Seleccionar Grup");
define("EDOCENT_LABEL_SUBMIT", "Mostrar Horari");
define("EDOCENT_HORARI", "Horari Solapat d'Equip Docent");
define("EDOCENT_HORA", "Hora");
//accio_edirectiu.php
define("EDIRECTIU_TITUL", "Horari d'Equip Directiu");
define("EDIRECTIU_LABEL_GRUP", "Seleccionar Grup");
define("EDIRECTIU_LABEL_SUBMIT", "Mostrar Horari");
define("EDIRECTIU_HORARI", "Horari Solapat d'Equip Directiu");
define("EDIRECTIU_HORA", "Hora");
//accio_professor.php
define("LC_TAULA_TITUL", "Llista de Professors");
define("LC_TAULA_1", "#");
define("LC_TAULA_2", "Professor");
define("LC_TAULA_3", "Correu Electrònic");
define("LC_TAULA_4", "Departament");
define("LC_TAULA_5", "Cap");
define("LC_TAULA_6", "Tut ESO");
define("LC_TAULA_7", "Tut BAT");
define("LC_TAULA_8", "Tut CF Pres");
define("LC_TAULA_9", "Tut CF Semi");
define("LC_TAULA_10", "AF");
define("LC_TAULA_11", "Direció");
define("LC_MISSATGE_ALERT", "Llevar càrrecs i departaments de substituts que no està ja al centre: ");
define("LC_DEP", "Llistes de Correu per Departaments");
define("LC_CARREC", "Llistes de Correu per Càrrecs");
define("LC_ED", "Llistes de Correu per Equips Docents (actuals!)");
define("LC_SENSEDEP", "Sense Departament");
define("LC_SENSEED", "Sense Equip Docent");
define("LC_COPIAR", "Copiar");
//accio_professor2.php
define("PROFESSOR_TITUL_TAULA", "Horari de professor en format taula");
//accio_professor.php
define("PROFESSOR_TITUL", "Introduïr professor");
define("PROFESSOR_TITUL_VORE", "Horari de professor");
define("PROFESSOR_LABEL_PROFE", "Professor a editar (Deixar sense seleccionar per introduïr un nou professor)");
define("PROFESSOR_LABEL_PROFE_VORE", "Professor");
define("PROFESSOR_LABEL_NOM", "Nom del professor");
define("PROFESSOR_LABEL_SUBMIT", "Desar / Horari");
define("PROFESSOR_LABEL_SUBMIT_VORE", "Horari");
define("PROFESSOR_HORARI", "Horari de professor");
define("PROFESSOR_HORA", "Hora");
define("PROFESSOR_LABEL_EDITAR", "Mostrar caselles d'edició de sessions");
//accio_professor_editar.php
define("PROFESSOR_EDITAR_TITUL", "Editar professor");
define("PROFESSOR_EDITAR_LABEL_PROFE", "Professor a editar");
define("PROFESSOR_EDITAR_LABEL_NOM", "Nom del professor");
define("PROFESSOR_EDITAR_LABEL_SUBMIT", "Guardar");
define("PROFESSOR_EDITAR_LABEL_MAIL", "Correu Electrònic");
define("PROFESSOR_EDITAR_LABEL_DEP", "Departament");
define("PROFESSOR_EDITAR_LABEL_CHECK_CCP", "Cap");
define("PROFESSOR_EDITAR_LABEL_CHECK_TESO", "Tutoria ESO");
define("PROFESSOR_EDITAR_LABEL_CHECK_TBAT", "Tutoria BAT");
define("PROFESSOR_EDITAR_LABEL_CHECK_TCF", "Tutoria CF Presencial");
define("PROFESSOR_EDITAR_LABEL_CHECK_TSEMI", "Tutoria CF Semi");
define("PROFESSOR_EDITAR_LABEL_CHECK_DIR", "Direcció");
define("PROFESSOR_EDITAR_ALERTA", "Registre Editat");
//accio_professor_sessio.php
define("PROFESSOR_SESSIO_TITUL", "Introduïr sessió");
define("PROFESSOR_SESSIO_LABEL_PROFESSOR", "Professor");
define("PROFESSOR_SESSIO_LABEL_DATA", "Data");
define("PROFESSOR_SESSIO_LABEL_HORA", "Hora");
define("PROFESSOR_SESSIO_LABEL_MATERIA", "Materia");
define("PROFESSOR_SESSIO_LABEL_GRUP", "Grup");
define("PROFESSOR_SESSIO_LABEL_AULA", "Aula");
define("PROFESSOR_SESSIO_LABEL_TIPUS", "Tipus");
define("PROFESSOR_SESSIO_LABEL_SUBMIT", "Desar");
define("PROFESSOR_SESSIO_LABEL_ESBORRAR", "Esborrar");
//accio_reserves.php
define("RESERVES_TITUL", "Reserves de Recursos/Aulari");
define("RESERVES_LABEL_AULA", "Aula");
define("RESERVES_SUBMIT", "Escollir Ubicació");
define("RESERVES_LABEL_PROFESSOR", "Professor");
define("RESERVES_LABEL_RESERVAR", "Reservar");
define("RESERVES_LABEL_OBSERVACIONS", "Observacions");
define("RESERVES_CREAR_SUBMIT", "Crear Reserva");
//accio_reserves_llista.php
define("RESERVES_LLISTA_TITUL", "Llista de reserves");
define("RESERVES_TH_1", "#");
define("RESERVES_TH_2", "Aula");
define("RESERVES_TH_3", "Data");
define("RESERVES_TH_4", "Hora");
define("RESERVES_TH_5", "Id Professor");
define("RESERVES_TH_6", "Professor");
define("RESERVES_TH_7", "Observacions");
define("RESERVES_TH_8", "Accions");
define("RESERVES_ELIMINA", "Eliminar");
//accio_substitucio.php
define("SUBSTITUCIO_TITUL", "Introduïr professor");
define("SUBSTITUCIO_AFEGIR", "Afegir");
define("SUBSTITUCIO_ERROR_SUBSTITUT", "No has elegit cap SUBSTITUT!");
define("SUBSTITUCIO_ERROR_PROFESSOR", "No has elegit cap PROFESSOR!");
define("SUBSTITUCIO_ERROR_INICI", "No has elegit cap DATA d'INICI!");
define("SUBSTITUCIO_ERROR_FI", "No has elegit cap DATA DE FI");
define("SUBSTITUCIO_LABEL_SUBSTITUT", "Substitut");
define("SUBSTITUCIO_LABEL_SUBSTITUIT", "Professor substituït");
define("SUBSTITUCIO_LABEL_DESDE", "Des de data");
define("SUBSTITUCIO_LABEL_FINS", "Fins a data");
define("SUBSTITUCIO_LLISTA_TITUL", "Llista de Substitucions");
define("SUBSTITUCIO_TH_1", "#");
define("SUBSTITUCIO_TH_2", "Professorat");
define("SUBSTITUCIO_TH_3", "Substituït per");
define("SUBSTITUCIO_TH_4", "De");
define("SUBSTITUCIO_TH_5", "A");
define("SUBSTITUCIO_TH_6", "Accions");
//funcions.php
//index.php
define("INDEX_TITUL", "Gestió de Guardies");
define("INDEX_FUTUR", "Futur");
define("INDEX_PASSAT", "Passat");
define("INDEX_AVUI", "Avui");
define("INDEX_ABSENCIA", "Absències");
define("INDEX_INFORMES", "Informes");
define("INDEX_GRUP", "Grup");
define("INDEX_PROFESSOR", "Professor");
define("INDEX_PROFESSOR2", "Professor Taula");
define("INDEX_PROFESSOR_EDITAR", "Gestió Professorat");
define("INDEX_EDOCENT", "Equip Docent");
define("INDEX_EDIRECTIU", "Equip Directiu");
define("INDEX_SUBSTITUCIO", "Substitució");
define("INDEX_GESTIO", "Gestió");
define("INDEX_IMPORTACIO", "Importació de Dades");
define("INDEX_RESERVES", "Generar Reserves");
define("INDEX_RESERVES_LLISTA", "Llistar Reserves");
define("INDEX_CONTROL_MANUAL", "Control Horari Manual");
define("INDEX_CONTROL_LLISTA", "Control Horari Llistat");
define("INDEX_MENU_ADMIN", "Administrar");
define("INDEX_MENU_USER", "Informes");
define("INDEX_MENU_RESERVES", "Reserves");
define("INDEX_CONTROL_VAGA", "Full de Control Diari");
define("INDEX_CONTROL_ACTES", "Full de Control Actes");
define("INDEX_LLISTES_CORREU", "Llistes Correu");
define("INDEX_AULES", "Aules");
//index_config.php
define("DIA_1", "dilluns");
define("DIA_2", "dimarts");
define("DIA_3", "dimecres");
define("DIA_4", "dijous");
define("DIA_5", "divendres");
define("DIA_6", "dissabte");
define("DIA_7", "diumenge");
define("MES_1", "de gener");
define("MES_2", "de febrer");
define("MES_3", "de març");
define("MES_4", "d'abril");
define("MES_5", "de maig");
define("MES_6", "de juny");
define("MES_7", "de juliol");
define("MES_8", "d'agost");
define("MES_9", "de setembre");
define("MES_10", "d'octubre");
define("MES_11", "de novembre");
define("MES_12", "de desembre");
//index_control.php
define("INDEX_CONTROL_TITUL", "Control QR");
define("INDEX_CONTROL_ENTRADA", "ENTRADA REGISTRADA");
define("INDEX_CONTROL_EIXIDA", "EIXIDA REGISTRADA");
define("INDEX_CONTROL_ERROR", "ERROR");
define("INDEX_CONTROL_REPETIT", "JA EN SISTEMA");
//index_control_manual.php
define("INDEX_CONTROL_MANUAL_TITUL", "Control Manual");
define("INDEX_CONTROL_MANUAL_PROFE", "Usuari");
define("INDEX_CONTROL_MANUAL_VALIDADOR", "Codi de Validació");
define("INDEX_CONTROL_MANUAL_IN", "Registrar ENTRADA");
define("INDEX_CONTROL_MANUAL_OUT", "Registrar EIXIDA");
define("INDEX_CONTROL_MANUAL_VALIDACIO_MAL", "Validació Incorrecta!");
//index_sense-permisos.php
define("SENSEPERMISOS_1", "Sense permisos per executar");
define("SENSEPERMISOS_2", "... Què fas ací?");
?>