<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/ext/bootstrap.min.css">
<script src="/ext/jquery.min.js"></script>
<script src="/ext/popper.min.js"></script>
<script src="/ext/Chart.min.js"></script>
<script src="/ext/bootstrap.min.js"></script>
<?php error_reporting( E_ALL ); ?>
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">IWMS</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Dane bieżące</a></li>
      <li><a href="statystyka.php">Statystyka</a></li>
      <li class="active"><a href="#">Ustawienia</a></li>
      <li><a href="about.php">About</a></li>
      </ul>
  </div>
</nav>

<?php
define('DB_HOST', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 't00r');
define('DB_NAME', 'IWMS');
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if(!$mysqli){
die("Connection failed: " . $mysqli->error);
}

  $listaczujnikow =sprintf("SELECT SensorID,SensorName from SensorNames");
  $czujniki = $mysqli->query($listaczujnikow);

echo "<table class=\"table\">";
$ileczujnikow=$czujniki->num_rows;
echo "Skonfigurowane czujniki: ";

for ($i=1; $i<=$ileczujnikow; $i++){
  $rowczujnik=mysqli_fetch_array($czujniki,MYSQLI_ASSOC);

echo "<tr>";
echo "<td>".$rowczujnik["SensorID"]."</td>";
echo "<td>".$rowczujnik["SensorName"]."</td>";
echo "<td> <a href=\"deletesensor.php?seid=".$rowczujnik["SensorID"]."\"> Usuń czujnik</a> </td>";
echo "</tr>";
}
echo "</table>";
echo "Dodaj czujnik: ";



echo "<form action=\"addsensor.php\" method=\"post\">
ID Czujnika: <input type=\"text\" name=\"ID\"><br>
Nazwa Czujnika: <input type=\"text\" name=\"NNC\"><br>
<input type=\"submit\">
</form>";








$mysqli->close();
?>
