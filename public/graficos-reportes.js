google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {



  var data = google.visualization.arrayToDataTable([
    ['Task', 'Hours per Day'],
    ['{{destino}}', 4],
    ['{{nombre}}', 4]

  ]);


  var options = {'title':'My Average Day', 'width':1550, 'height':1400};


  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}