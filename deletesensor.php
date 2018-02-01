<?php
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 't00r');
define('DB_NAME', 'IWMS');
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
die("Connection failed: " . $mysqli->error);
}
$a=$_REQUEST['seid'];
$DodajNowyCzujnik = sprintf("DELETE FROM SensorNames WHERE SensorID = $a");
$Dodaj = $mysqli->query($DodajNowyCzujnik);
$mysqli->close();
?>

<script language="javascript">
<!--
  window.location = "/settings.php";
-->
</script>
