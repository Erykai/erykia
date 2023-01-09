// -------------------------------------------------------------------------------------------------------------------------------------------
// Dashboard 2 : Chart Init Js
// -------------------------------------------------------------------------------------------------------------------------------------------
$(function() {
    "use strict"
    // -----------------------------------------------------------------------
    // Revenue Statistics
    // -----------------------------------------------------------------------
var option_Product_Calculation = {
        series: [
            {
                name: "2016",
                data: [0, 2, 3.5, 0, 13, 1, 4, 1],
            },
            {
                name: "2020",
                data: [0, 4, 0, 4, 0, 4, 0, 4],
            },
        ],
        chart: {
            fontFamily: 'Rubik,sans-serif',
            height: 350,
            type: "area",
            toolbar: {
                show: false,
            },
        },
        fill: {
            type: 'solid',
            opacity: 0.2,
            colors: ['#009efb', '#39c449']
        },
        grid: {
            show: true,
            strokeDashArray: 3,
            borderColor: "rgba(0,0,0,0.1)",
            xaxis: {
                lines: {
                    show: true
                }
            }, 
        },
        colors: ["#39c449", "#009efb"],
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: "smooth",
            width: 1,
            colors: ['#009efb', '#39c449']
        },
        markers: {
            size: 3,
            strokeColors: "transparent",
            colors: ['#009efb', '#39c449']
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            categories: ['0', '4', '8', '12', '16', '20', '24', '30'],
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            x: {
                format: "dd/MM/yy HH:mm",
            },
            theme: "dark",
        },
        legend: {
            show: false,
        },
    };

    var chart_area_spline = new ApexCharts(document.querySelector("#product-calculation"), option_Product_Calculation);
    chart_area_spline.render();
    
});