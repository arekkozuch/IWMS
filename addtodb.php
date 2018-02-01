<?php

define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 't00r');
define('DB_NAME', 'IWMS');

$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

$temp = $_REQUEST['temp'];
$pres = $_REQUEST['pres'];
$humi = $_REQUEST['humi'];
$seid = $_REQUEST['seid'];

$insert = $mysqli->query( "INSERT INTO `IWMS`.`WeatherData` (`ID`, `ReadTime`, `Temp`, `Pressure`, `Humidity`, `SensorID`) VALUES (NULL, CURRENT_TIMESTAMP, '$temp', '$pres', '$humi', '$seid')" );
//http://192.168.1.101/addtodb.php?temp=28.75&pres=953&humi=75&seid=1

$mysqli->close();

echo date("Y-m-d H:i:s");
?>