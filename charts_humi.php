<?php
 $con = mysqli_connect('localhost','root','t00r','IWMS');

 $query_ktoreczujniki = sprintf("SELECT DISTINCT SensorID FROM WeatherData");
 $result = mysqli_query($con, $query_ktoreczujniki);
 $ileczujnikow=$result->num_rows;

 for ($i=1; $i<=$ileczujnikow; $i++){


echo "<script type=\"text/javascript\">
 google.charts.load(\"visualization\", \"1\", {packages:[\"corechart\"]});
 google.charts.setOnLoadCallback(drawChart);
 function drawChart() {
 var data = google.visualization.arrayToDataTable([";
   $czujnik =sprintf("SELECT SensorName from SensorNames where SensorID like $i");
   $nazwaczujnika = mysqli_query($con,$czujnik);
   $rowczujnik=mysqli_fetch_array($nazwaczujnika,MYSQLI_ASSOC);
echo "['ReadTime', 'Humidity'],";

 $query = "SELECT * FROM(SELECT ReadTime, Humidity FROM WeatherData WHERE SensorID = $i ORDER BY ID DESC LIMIT 200)sub ORDER BY ReadTime ASC ";

 $exec = mysqli_query($con,$query);
 while($row = mysqli_fetch_array($exec)){
 echo "['".$row['ReadTime']."',".$row['Humidity']."],";
 }

echo "   ]);

 var options = {
 title: '".$rowczujnik["SensorName"]."',
 legend:'none' };

 var chart = new google.visualization.LineChart(document.getElementById(\"wilgotnosc";echo $i; echo "\"));
 google.visualization.events.addListener(chart, 'error', function (googleError) {
      google.visualization.errors.removeError(googleError.id);
      document.getElementById(\"error_msg\").innerHTML = \"Message removed = '\" + googleError.message + \"'\"});
 chart.draw(data, options);
}
 </script>
 ";
 }
 ?>
