(function (drupalSettings) {

  google.charts.load('current', {'packages': ['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Social media network', 'Clicks'],
      ['Facebook', drupalSettings.chart_data.facebook],
      ['Linkedin', drupalSettings.chart_data.linkedin],
      ['Twitter', drupalSettings.chart_data.twitter],
      ['Foursquare', drupalSettings.chart_data.foursquare],
      ['Google Plus', drupalSettings.chart_data.google_plus]
    ]);

    var options = {
      title: 'Clicked Social media links'
    };

    var chart = new google.visualization.PieChart(document.getElementById('chart'));

    chart.draw(data, options);
  }

})(drupalSettings);
