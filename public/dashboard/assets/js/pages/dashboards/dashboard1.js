// -------------------------------------------------------------------------------------------------------------------------------------------
// Dashboard 1 : Chart Init Js
// -------------------------------------------------------------------------------------------------------------------------------------------
$(function () {
    "use strict";
    // -----------------------------------------------------------------------
    // Sales of the Month
    // -----------------------------------------------------------------------

var option_Sales_of_the_Month = {
        series: [9, 3, 2, 2],
        labels: ["Item A", "Item B", "Item C", "Item D"],
        chart: {
            type: 'donut',
            height: 280,
            fontFamily: 'Rubik,sans-serif',
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 0,
        },
        plotOptions: {
            pie: {
                expandOnClick: true,
                donut: {
                    size: '88',
                    labels: {
                        show: false,
                        name: {
                            show: true,
                            offsetY: 7,

                        },
                        value: {
                            show: false,
                        },
                        total: {
                            show: false,
                            color: '#a1aab2',
                            fontSize: '13px',
                            label: 'Our Visitor',
                        }
                    },
                },
            },
        },
        colors: ['#edf1f5', '#009efb', '#55ce63', '#745af2'],
        tooltip: {
            show: true,
            fillSeriesColor: false,
        },
        legend: {
            show: false
        },
    };

    var chart_pie_donut = new ApexCharts(document.querySelector("#sales-of-the-month"), option_Sales_of_the_Month);
    chart_pie_donut.render();

// -----------------------------------------------------------------------
// Revenue Statistics
// -----------------------------------------------------------------------

    var Revenue_Statistics = {
        series: [
            {
                name: "Product A ",
                data: [0, 2, 3.5, 0, 13, 1, 4, 1],
            },
            {
                name: "Product B ",
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
            colors: ["#009efb", "#39c449"],
        },
        grid: {
            show: true,
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
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
            colors: ["#009efb", "#39c449"],
        },
        markers: {
            size: 3,
            colors: ["#009efb", "#39c449"],
            strokeColors: "transparent",
        },
        xaxis: {
            axisBorder: {
                show: true,
            },
            axisTicks: {
                show: true,
            },
            categories: ['0', '4', '8', '12', '16', '20', '24', '30'],
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
            tickAmount: 9,
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

    var chart_area_spline = new ApexCharts(document.querySelector("#revenue-statistics"), Revenue_Statistics);
    chart_area_spline.render();
    
// ----------------------------------------------------------------------- 
// Sales difference
// -----------------------------------------------------------------------

var option_Sales_Difference = {
        series: [35, 15, 10],
        labels: ["", "", ""],
        chart: {
            type: 'donut',
            height: 140,
            fontFamily: 'Rubik,sans-serif',
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            width: 0,
        },

        plotOptions: {
            pie: {
                expandOnClick: true,
                donut: {
                    size: '65%',
                    labels: {
                        show: false,
                        name: {
                            show: true,
                            offsetY: 7,

                        },
                        value: {
                            show: false,
                        },
                        total: {
                            show: false,
                            color: '#a1aab2',
                            fontSize: '13px',
                            label: 'Visits',
                        }
                    },
                },
            },
        },
        colors: ['#39c449',  '#ebf3f5', '#009efb'],
        tooltip: {
            show: true,
            fillSeriesColor: false,
        },
        legend: {
            show: false
        },
        responsive: [{
            breakpoint: 426,
            options: {
                chart: {
                    height: 130,
                    offsetY: 10,
                    offsetX: -35,
                    width: 200
                },
            }
        }]
    };

    var chart_pie_donut = new ApexCharts(document.querySelector("#sales-difference"), option_Sales_Difference);
    chart_pie_donut.render(); 


// ----------------------------------------------------------------------- 
// Sales Prediction
// ----------------------------------------------------------------------- 


var option_Sales_Prediction = {
        chart: {
            height: 170,
            type: "radialBar",
            fontFamily: 'Rubik,sans-serif',
            spacingTop: 0,
            spacingBottom: 0,
            spacingLeft: 0,
            spacingRight: 0,
            offsetY: -30,
            sparkline: {
                enabled: true
            }
        },
        series: [60],
        colors: ["#1badcb"],
        stroke: {
          dashArray: 2
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                track: {
                    background: '#f1f1f1',
                    startAngle: -135,
                    endAngle: 135,
                },
                hollow: {
                    size: '30%',
                    background: 'transparent',
                },
                dataLabels: {
                    show: true,
                    name: {
                        show: false,
                    },
                    value: {
                        show: false,
                    },
                    total: {
                      show: true,
                      fontSize: '20px',
                      color: '#000', 
                      label: '91.4 %', 
                  }
                }
            }
        },
        fill: {
            type: "solid",
        },
        tooltip: {
          enabled: true, 
          fillSeriesColor: false,
          theme: "dark"
        },
        responsive: [{
            breakpoint: 426,
            options: {
                chart: {
                    offsetX: -15,
                }
            }
        }],
        labels: ["Progress"]
    };

    new ApexCharts(document.querySelector("#sales-prediction"), option_Sales_Prediction).render();
});

