import ApexCharts from 'apexcharts'

$( function()
{
    var options = {
        chart: {
            type: 'bar'
        },
        series: [
            {
                name: 'sales',
                data: [30, 40, 35, 50, 49, 60, 70, 91, 125]
            }
        ],
        xaxis: {
            categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
        }
    }
    
    var chart = new ApexCharts( document.querySelector( '#basic_bar_chart' ), options );
    chart.render();
});
