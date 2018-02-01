<?php
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 't00r');
define('DB_NAME', 'IWMS');
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if(!$mysqli){
die("Connection failed: " . $mysqli->error);
}
$IDNowegoCzujnika = $_REQUEST['ID'];
$NazwaNowegoCzujnika = $_REQUEST['NNC'];
$DodajNowyCzujnik = sprintf("INSERT INTO SensorNames (SensorID, SensorName) VALUES ($IDNowegoCzujnika, \"$NazwaNowegoCzujnika\")");
$Dodaj = $mysqli->query($DodajNowyCzujnik);
$mysqli->close();
?>

<script language="javascript">
<!--
  window.location = "/settings.php";
-->
</script>
