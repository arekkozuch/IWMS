<?php
//setting header to json
header('Content-Type: application/json');

//database
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 't00r');
define('DB_NAME', 'IWMS');

//get connection
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
	die("Connection failed: " . $mysqli->error);
}

$zakres = $_REQUEST['zakres'];
if ($zakres==NULL){
	$query = sprintf("SELECT * FROM(SELECT ReadTime, Temp,Pressure,Humidity,SensorID FROM WeatherData WHERE SensorID = 2 and ReadTime>(NOW() - INTERVAL 12 HOUR) ORDER BY ID DESC)sub ORDER BY ReadTime ASC ");
}
else
{
	$query = sprintf("SELECT * FROM(SELECT ReadTime, Temp,Pressure,Humidity,SensorID FROM WeatherData WHERE SensorID = 2 and ReadTime>(NOW() - INTERVAL $zakres HOUR) ORDER BY ID DESC)sub ORDER BY ReadTime ASC ");
}


//execute query
$result = $mysqli->query($query);

//loop through the returned data
$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

//free memory associated with result
$result->close();

//close connection
$mysqli->close();

//now print the data
print json_encode($data);