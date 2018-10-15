/**
 * Load chart.
 * Using session storage to avoid request duplication
 */
$(function(){

    function createNewCustomersChart(jsonData){
        function isToday(today) {
            var d = new Date();
            return today.getDate() == d.getDate() && today.getMonth() == d.getMonth() && today.getFullYear() == d.getFullYear();
        }
    
        function isYesterday(today){
            var d = new Date();
            d.setDate(d.getDate() - 1);
            return today.getDate() == d.getDate() && today.getMonth() == d.getMonth() && today.getFullYear() == d.getFullYear();
        }

        new Morris.Line({
            element: '_jQ_newCustomersChart',
            
            data: jsonData,
            lineColors: ['#b0d1a1'],
            lineWidth : 4,
            xkey: 'period',
            ykeys: ['newCustomers'],
            labels: ['Nouveaux clients'],
            xLabels: 'day',
            xLabelAngle: 49,
            xLabelFormat: function (date) {

                var jsDate = new Date(date);

                if(isToday(jsDate))
                    return 'Aujourd\'hui';

                if(isYesterday(jsDate))
                    return 'Hier';
                    
                var sDate = jsDate.toLocaleDateString([], {weekday: 'short', month: 'short', day: 'numeric'})
                return sDate; 
            },
            resize: true
            });

        $('#_jQ_loader_newCustomerChart').remove();
    }

    // If cache cache data doesn't exist, create them.
    if(sessionStorage.getItem("newCustomersChartData")){
        var jsonData = JSON.parse(sessionStorage.getItem("newCustomersChartData"));

        console.log('Chart data loader from session storage. Data : ')
        console.log(jsonData);

        createNewCustomersChart(jsonData);

    }
    else {
    let newCustomerStatsURL = $('#_jQ_newCustomersChart').data('statsUrl');
    $.get( newCustomerStatsURL, function( jsonData ) {
        // Remove later
        console.log('Query success, this is your chart data : ');
        console.log(jsonData);

        sessionStorage.setItem('newCustomersChartData', JSON.stringify(jsonData));
        createNewCustomersChart(jsonData);
    });
    }
});