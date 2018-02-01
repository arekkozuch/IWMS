<html>
<head>
<link rel="stylesheet" href="/ext/bootstrap.min.css">
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="/ext/jquery.min.js"></script>
<script src="/ext/popper.min.js"></script>
<script src="/ext/Chart.min.js"></script>
<script src="/ext/bootstrap.min.js"></script>
<style>
.chart {
  width: 100%;
  min-height: 450px;
}</style>




</head>

<nav class="navbar navbar-default">
<div class="container-fluid">
  <div class="navbar-header">
    <a class="navbar-brand" href="index.php">IWMS</a>
  </div>
  <ul class="nav navbar-nav">
    <li><a href="index.php">Dane bieżące</a></li>
    <li><a href="statystyka.php">Statystyka</a></li>
    <li><a href="settings.php">Ustawienia</a></li>
    <li class="active"><a href="#">Wykresy</a></li>
    <li><a href="about.php">About</a></li>
    </ul>
</div>
</nav>
<body>

  <?php include 'charts_temp.php';?>
  <?php include 'charts_humi.php';?>
  <?php include 'charts_pres.php';?>
  <?php
   $con = mysqli_connect('localhost','root','t00r','IWMS');

   $query_ktoreczujniki = sprintf("SELECT DISTINCT SensorID FROM WeatherData");
   $result = mysqli_query($con, $query_ktoreczujniki);
   $ileczujnikow=$result->num_rows;
   ?>

   <h3>Temperatura</h3>
   <div class="col-md-4 col-md-offset-4">
     <hr />
  </div>
  <div class="clearfix"></div>
<?php
for ($i=1; $i<=$ileczujnikow-1; $i++){
echo "<div class=\"col-md-auto\">
    <div id=temperatura".$i." class=\"chart\"></div>
  </div>";}

  ?>

  <h3>Wilgotność</h3>
<hr />
<?php  for ($i=1; $i<=$ileczujnikow-1; $i++){
echo"  <div class=\"col-md-auto\">
    <div id=wilgotnosc".$i." class=\"chart\"></div>
  </div>
";}?>
  <h3>Ciśnienie</h3>
<hr />
  <?php  for ($i=1; $i<=$ileczujnikow-1; $i++){
  echo"  <div class=\"col-md-auto\">
      <div id=cisnienie".$i." class=\"chart\"></div>
    </div>
  ";}?>








</div>
</body>
</html>
