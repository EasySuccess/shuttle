$(function() {
		var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
				var lineChartData1 = {
					labels : ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
					datasets : [
						{
							label: "My First dataset",
							fillColor : "rgba(220,220,220,0.2)",
							strokeColor : "rgba(220,220,220,1)",
							pointColor : "rgba(220,220,220,1)",
							pointStrokeColor : "#fff",
							pointHighlightFill : "#fff",
							pointHighlightStroke : "rgba(220,220,220,1)",
							data :[
								100,
								200,
								300,
								400,
								550,
								600,
								700,
								800,
								900,
								1000,
								1100,
								2200]
						},
					]
				}
		
			$(function(){
				var ctx = document.getElementById("chart-price1").getContext("2d");
				window.myLine = new Chart(ctx).Line(lineChartData1, {
					responsive: true
				});
			});
			
			
			var lineChartData2 = {
				labels : ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
				datasets : [
					{
						label: "My First dataset",
						fillColor : "rgba(220,220,220,0.2)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						pointHighlightFill : "#fff",
						pointHighlightStroke : "rgba(220,220,220,1)",
						data :[
							1000,
							200,
							300,
							4000,
							550,
							600,
							1000,
							880,
							3900,
							2000,
							1100,
							2200]
					},
				]
			}
			$(function(){
				var ctx = document.getElementById("chart-price2").getContext("2d");
				window.myLine = new Chart(ctx).Line(lineChartData2, {
					responsive: true
				});
			});        
});
