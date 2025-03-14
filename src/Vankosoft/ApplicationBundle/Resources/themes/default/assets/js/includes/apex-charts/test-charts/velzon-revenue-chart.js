import ApexCharts from 'apexcharts'

$( function()
{
    var linechartcustomerColors = getChartColorsArray( "customer_impression_charts" );
    
    var options = {
        series:[
            {
                name:"Orders",
                type:"area",
                data:[34,65,46,68,49,61,42,44,78,52,63,67]
            },{
                name:"Earnings",
                type:"bar",
                data:[89.25,98.58,68.74,108.87,77.54,84.03,51.24,28.57,92.57,42.36,88.51,36.57]
            },{
                name:"Refunds",
                type:"line",
                data:[8,12,7,17,21,11,5,9,7,29,12,35]
            }
        ],
        chart:{
            height:370,
            type:"line",
            toolbar:{show:!1}
        },
        stroke:{
            curve:"straight",
            dashArray:[0,0,8],
            width:[2,0,2.2]
        },
        fill:{opacity:[.1,.9,1]},
        markers:{
            size:[0,0,0],
            strokeWidth:2,
            hover:{size:4}
        },
        xaxis:{
            categories:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            axisTicks:{show:!1},
            axisBorder:{show:!1}
        },
        grid:{
            show:!0,
            xaxis:{lines:{show:!0}},
            yaxis:{lines:{show:!1}},
            padding:{top:0,right:-2,bottom:15,left:10}
        },
        legend:{
            show:!0,
            horizontalAlign:"center",
            offsetX:0,offsetY:-5,
            markers:{width:9,height:9,radius:6},
            itemMargin:{horizontal:10,vertical:0}
        },
        plotOptions:{bar:{columnWidth:"30%",barHeight:"70%"}},
        colors:linechartcustomerColors,
        tooltip:{
            shared:!0,y:[
                {
                    formatter:function(e){
                        return void 0!==e?e.toFixed(0):e
                    }
                },{
                    formatter:function(e){
                        return void 0!==e?"$"+e.toFixed(2)+"k":e
                    }
                },{
                    formatter:function(e){
                        return void 0!==e?e.toFixed(0)+" Sales":e
                    }
                }
            ]
        }
    }
    
    var chart = new ApexCharts( document.querySelector( '#customer_impression_charts' ), options );
    chart.render();
});

function getChartColorsArray( e )
{
    if( null !== document.getElementById( e ) ) {
        var t = document.getElementById( e ).getAttribute( "data-colors" );
        if ( t )
            return ( t = JSON.parse( t ) ).map( function( e ) {
                var t = e.replace( " ","" );
                return-1 === t.indexOf( "," ) ? getComputedStyle( document.documentElement ).getPropertyValue( t ) ||
                        t : 2 == ( e = e.split( "," ) ).length ? 
                            "rgba( " + getComputedStyle( document.documentElement ).getPropertyValue( e[0]) + "," +e[1] + ")" : t
                }
            );
        console.warn( "data-colors atributes not found on",e )
    }
}
