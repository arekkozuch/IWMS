$(document).ready(function(){
	$.ajax({
		url: "data.php?zakres=30",
		method: "GET",
		success: function(data) {
			console.log(data);
            var ReadTime = [];
            var Temp = [];
            var Pressure = [];
            var Humidity = [];
            var SensorID = [];

			for(var i in data) {
                var w = data[i].ReadTime;
                w= w.slice(11);
                ReadTime.push(w);
                Temp.push(data[i].Temp);
                Pressure.push(data[i].Pressure);
                Humidity.push(data[i].Humidity);
                }

			var Temperatura = {
				labels: ReadTime,
				datasets : [
					{
						label: 'Temperatura',
//						backgroundColor: 'rgb(42, 212, 121)',
						borderColor: 'rgb(42, 212, 121)',//kolor zielony
//						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
//calc						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: Temp
					}]};
            var Wilgotnosc = {
                labels: ReadTime,
                datasets : [
                            {
						label: 'Wilgotność',
//						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgb(42, 133, 212)', //kolor niebieski
//						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
//						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: Humidity
                    }]};
                    var Cisnienie = {
                        labels: ReadTime,
                        datasets : [
                            
                    {
						label: 'Ciśnienie',
//						backgroundColor: 'rgba(200, 200, 200, 0.75)',
						borderColor: 'rgb(212, 42, 47)', //kolor czerwony
//						hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
//						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						data: Pressure
                    },
                    
                ]
			};

            var options={
                scales:{
                    yAxes:[{
                        display:true,
                        ticks:{
                            suggestedMin:0
                        }
                    }]
                },
                line:{
                    tension:0
                }
            };
			var ctx = $("#mycanvas");
            var ctx2 = $("#mycanvas2");
            var ctx3 = $("#mycanvas3");
            
			var LineChart = new Chart(ctx, {
				type: 'line',
                data: Temperatura,
                options: {
                    line:{tension: 0},
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
                var LineChart = new Chart(ctx2, {
                    type: 'line',
                    data: Wilgotnosc,
                    options: {
                        bezierCurve: false,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true,
                                }}
                            ]
                       }   }
                    });
             var LineChart = new Chart(ctx3, {
                 type: 'line',
                 data: Cisnienie,
                 options: {
                    bezierCurve: false,
                    scales: {
                        yAxes: [{
                            ticks: {
                                min:900,
                            }}]
                    }
                }
			});
		},
		error: function(data) {
			console.log(data);
		}
	});
});


