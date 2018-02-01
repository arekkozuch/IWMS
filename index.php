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
      <li class="active"><a href="#">Dane bieżące</a></li>
      <li><a href="statystyka.php">Statystyka</a></li>
      <li><a href="settings.php">Ustawienia</a></li>
      <li><a href="charts.php">Wykresy</a></li>

      <li><a href="about.php">About</a></li>

      </ul>
  </div>
</nav>
<table class="table">
    <thead>
      <tr>
        <th>Nazwa Czujnika</th>
        <th>Temperatura (*C)</th>
        <th>Ciśnienie (hPa)</th>
        <th>Wilgotność (%)</th>
        <th>Ostatni odczyt</th>
      </tr>
      </thead>
      <tbody>
        <tr>
        <?php
    define('DB_HOST', '127.0.0.1');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 't00r');
    define('DB_NAME', 'IWMS');
    $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if(!$mysqli){
    	die("Connection failed: " . $mysqli->error);
    }
$query_ktoreczujniki = sprintf("SELECT DISTINCT SensorID FROM WeatherData");
$result = $mysqli->query($query_ktoreczujniki);
$ileczujnikow=$result->num_rows;

for ($i=1; $i<=$ileczujnikow; $i++){
  $pobierzdane = sprintf("SELECT ReadTime,Temp,Pressure,Humidity, SensorID FROM WeatherData where SensorID=$i ORDER BY ReadTime DESC LIMIT 1");
  $pobranedane = $mysqli->query($pobierzdane);
  $row=mysqli_fetch_array($pobranedane,MYSQLI_ASSOC);
  $czujnik =sprintf("SELECT SensorName from SensorNames where SensorID like $row[SensorID]");
  $nazwaczujnika = $mysqli->query($czujnik);
  $rowczujnik=mysqli_fetch_array($nazwaczujnika,MYSQLI_ASSOC);
//var_dump($rowczujnik);
  echo "<td>".$rowczujnik["SensorName"]."</td>";
  echo "<td>".$row["Temp"]."</td>";
  echo "<td>".$row["Pressure"]."</td>";
  echo "<td>".$row["Humidity"]."</td>";
  echo "<td>".$row["ReadTime"]."</td>";
  echo "</tr>";



//  var_dump($row);


//  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//  var_dump($row);
}

$mysqli->close();
?>
</tbody>
</table>
