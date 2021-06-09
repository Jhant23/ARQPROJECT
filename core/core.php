<?php 
/*#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-##-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-*/
//*//  #######  #######   #######  #######  #######  #######  #######  #######  ####### ####### //*//
//*//  ##   ##  ##   ##   ##   ##  ##   ##  ##   ##  ##   ##    ##     ##       ##        ##    //*//
//*//  #######  #######   ##   ##  #######  #######  ##   ##    ##     #######  ##        ##    //*//
//*//  ##   ##  ## ##     #######  ##       ## ##    ##   ##    ##     ##       ##        ##    //*//
//*//  ##   ##  ##   ##        ##  ##       ##   ##  #######  ####     #######  #######   ##    //*//
/*#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-##-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-*/

/*
* @ Project name: Arq Project
* @ Release: v1.0
* @ Release Date: 30/09/2016
* @ Developer & Designer: Alejo Rendón
* @ Manager: Benjamin Fernandez
* @ Technologies: PHP 5.6 +, Javascript, CSS 3, HTML 5
**/



@session_start();

header('Content-Type: text/html; charset=utf-8');

/*--------------------------------------------------------------------------*/
// Creamos todas las variables necesarias para obtener la fecha/dia/mes
/*--------------------------------------------------------------------------*/

date_default_timezone_set('America/Bogota');

$d = date('d');
$m = date('m');
$Y = date('Y');
$N = date('N');
$H = date('H');
$i = date('i');
$s = date('s');
$j = date('j');
$n = date('n');

$date = date('d-m-Y',mktime($d,$m,$Y));
$dateFull = date('d-m-Y H:i:s',mktime($H,$i,$s,$m,$d,$Y));
$hour = date('H:i:s',mktime($H,$i,$s));


define('DATE', $date);
define('DATEFULL', $dateFull);
define('HOUR', $hour);

/*--------------------------------------------------------------------------*/
// Realizamos la conexión a la base de datos
/*--------------------------------------------------------------------------*/

require ('core.User.Config.php');

try {
	
	$conexion = new PDO('mysql:host='.$_CONFIG['host'].
		';dbname='.$_CONFIG['db'],$_CONFIG['mysql_user'],$_CONFIG['mysql_pass']
		);

	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conexion->exec("SET NAMES 'utf8'");

	return true;

} catch(Exeption $e){

	return false;
}

?>