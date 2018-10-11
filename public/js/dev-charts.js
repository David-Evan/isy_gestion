/**
 * Ajax query load chart.
 */
$(function(){
let newCustomerStatsURL = $('#_newCustomersChart').data('statsUrl');
$.get( newCustomerStatsURL, function( jsonData ) {
    // Remove later
    console.log('Query success, this is your chart data : ');
    console.log(jsonData);

    new Morris.Line({
        element: '_newCustomersChart',
        
        data: jsonData,
        lineColors: ['#b0d1a1'],
        lineWidth : 4,
        xkey: 'period',
        ykeys: ['newCustomers'],
        labels: ['Nouveaux clients'],
        xLabels: 'day',
        xLabelAngle: 45,
        xLabelFormat: function (date) {

            var jsDate = new Date(date);
            var sDate = jsDate.toLocaleDateString([], {weekday: 'short', month: 'short', day: 'numeric'})
            return sDate; 
        },
        resize: true
      });

      // Remove loader
      $('#loader_newCustomerChart').remove();
  });
});