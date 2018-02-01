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
      <li class="active"><a href="#">Statystyka</a></li>
      <li><a href="settings.php">Ustawienia</a></li>
      <li><a href="charts.php">Wykresy</a></li>

      <li><a href="about.php">About</a></li>

      </ul>
  </div>
</nav>

<form method="POST">
<select name="ilerek" onchange="this.form.submit()">
<option value="" disabled selected>Wyświetl dane z ostatnich:</option>
<option value="1">1h</option>
<option value="2">2h</option>
<option value="4">4h</option>
<option value="12">12h</option>
<option value="24">24h</option>
<option value="48">48h</option>
<option value="24*5">5 dni</option>
<option value="24*7">7 dni</option>
<option value="24*14">2 tygodni</option>
<option value="24*28">4 tygodni</option>

</select>
 </form>

<?php
$ilerek = $_REQUEST['ilerek'];;
if ($ilerek!=NULL)
{$ilerekordow = $ilerek;}
else {$ilerekordow = 12;}

if (strlen($ilerekordow)<3){
  echo("Obecnie wyświetlam dane z $ilerekordow ostatnich godzin.");}
  else
  {
     echo("Obecnie wyświetlam dane z ");
    echo(substr($ilerekordow,3,4));
    echo(" ostatnich dni");
  }
?>

<table class="table">
  <col>
  <colgroup span="2"></colgroup>
  <colgroup span="2"></colgroup>
  <tr>
    <td rowspan="2"></td>
    <th colspan="2" scope="colgroup">Temperatura</th>
    <th colspan="2" scope="colgroup">Wilgotność (%)</th>   
    <th colspan="2" scope="colgroup">Ciśnienie (hPa)</th>

    
  </tr>
  <tr>
    <th scope="col">Max</th>
    <th scope="col">Min</th>
    <th scope="col">Max</th>
    <th scope="col">Min</th>
    <th scope="col">Max</th>
    <th scope="col">Min</th>
  </tr>
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
  
  $pobierzdanetempmax = sprintf("SELECT max(Temp) from (SELECT Temp FROM WeatherData WHERE SensorID = $i AND ReadTime>(NOW() - INTERVAL $ilerekordow HOUR) ORDER BY ReadTime)as Avg_ReadTime");
  $pobranedanetempmax = $mysqli->query($pobierzdanetempmax);
  $temperaturamax=mysqli_fetch_array($pobranedanetempmax,MYSQLI_ASSOC);
  $pobierzdanetempmin = sprintf("SELECT min(Temp) from (SELECT Temp FROM WeatherData WHERE SensorID = $i AND ReadTime>(NOW() - INTERVAL $ilerekordow HOUR) ORDER BY ReadTime)as Avg_ReadTime");
  $pobranedanetempmin = $mysqli->query($pobierzdanetempmin);
  $temperaturamin=mysqli_fetch_array($pobranedanetempmin,MYSQLI_ASSOC);
  
  $czujnik =sprintf("SELECT SensorName from SensorNames where SensorID like $i");
  $nazwaczujnika = $mysqli->query($czujnik);
  $rowczujnik=mysqli_fetch_array($nazwaczujnika,MYSQLI_ASSOC);

  $pobierzdanecismax = sprintf("SELECT max(Pressure) from (SELECT Pressure FROM WeatherData WHERE SensorID = $i AND ReadTime>(NOW() - INTERVAL $ilerekordow HOUR) ORDER BY ReadTime) as Avg_ReadTime");
  $pobranedanecismax = $mysqli->query($pobierzdanecismax);
  $cisnieniemax=mysqli_fetch_array($pobranedanecismax,MYSQLI_ASSOC);
  $pobierzdanecismin = sprintf("SELECT min(Pressure) from (SELECT Pressure FROM WeatherData WHERE SensorID = $i AND ReadTime>(NOW() - INTERVAL $ilerekordow HOUR) ORDER BY ReadTime) as Avg_ReadTime");
  $pobranedanecismin = $mysqli->query($pobierzdanecismin);
  $cisnieniemin=mysqli_fetch_array($pobranedanecismin,MYSQLI_ASSOC);
  
  $pobierzdanewilmax = sprintf("SELECT max(Humidity) from (SELECT Humidity FROM WeatherData WHERE SensorID = $i AND ReadTime>(NOW() - INTERVAL $ilerekordow HOUR) ORDER BY ReadTime) as Avg_ReadTime");
  $pobranedanewilmax = $mysqli->query($pobierzdanewilmax);
  $wilgotnoscmax=mysqli_fetch_array($pobranedanewilmax,MYSQLI_ASSOC);
  $pobierzdanewilmin = sprintf("SELECT min(Humidity) from (SELECT Humidity FROM WeatherData WHERE SensorID = $i AND ReadTime>(NOW() - INTERVAL $ilerekordow HOUR) ORDER BY ReadTime) as Avg_ReadTime");
  $pobranedanewilmin = $mysqli->query($pobierzdanewilmin);
  $wilgotnoscmin=mysqli_fetch_array($pobranedanewilmin,MYSQLI_ASSOC);
//var_dump($temperatura);
  echo "<td>".$rowczujnik["SensorName"]."</td>";
  echo "<td>".$temperaturamax["max(Temp)"]."</td>";
  echo "<td>".$temperaturamin["min(Temp)"]."</td>";
  echo "<td>".$wilgotnoscmax["max(Humidity)"]."</td>";
  echo "<td>".$wilgotnoscmin["min(Humidity)"]."</td>";
   echo "<td>".$cisnieniemax["max(Pressure)"]."</td>";
  echo "<td>".$cisnieniemin["min(Pressure)"]."</td>";
  echo "</tr>";



//  var_dump($row);


//  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//  var_dump($row);
}

$mysqli->close();
?>
</tbody>
</table>
