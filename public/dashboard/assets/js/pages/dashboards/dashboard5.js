// -------------------------------------------------------------------------------------------------------------------------------------------
// Dashboard 5 : Chart Init Js
// -------------------------------------------------------------------------------------------------------------------------------------------
$(function () {
    "use strict";
    // -----------------------------------------------------------------------
    // Total revenue chart
    // -----------------------------------------------------------------------
        var option_Total_Revenue = {
        series: [
            {
                name: "2016 ",
                data: [4, 2, 3.5, 1.5, 4, 3],
            },
            {
                name: "2020 ",
                data: [2, 4, 2, 4, 2, 4],
            },
        ],
        chart: {
            fontFamily: 'Rubik,sans-serif',
            height: 220,
            type: "line",
            toolbar: {
                show: false,
            },
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
            width: 2,
            colors: ["#009efb", "#39c449"],
        },
        markers: {
            size: 3,
            strokeColors: "transparent",
            colors: ["#009efb", "#39c449"],
        },
        xaxis: {
            axisTicks: {
                show: false
            },
            axisBorder: {
                show: false
            },
            categories: ['0', '4', '8', '12', '16', '20', '24', '30'],
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
            min: 1,
            max: 5,
            tickAmount: 5,
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

    var chart_area_spline = new ApexCharts(document.querySelector("#total-revenue"), option_Total_Revenue);
    chart_area_spline.render();
    // -----------------------------------------------------------------------
    // doughnut chart option
    // -----------------------------------------------------------------------

    var option_Sales_of_the_Month = {
        series: [9, 3, 2, 2],
        labels: ["Social", "Marketing", "Search Engine", "Organic Sales"],
        chart: {
            type: 'donut',
            height: 270,
            offsetY: 20,
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
        responsive: [{
            breakpoint: 1025,
            options: {
                chart: {
                    width: 250
                },
            }
        }, {
            breakpoint: 769,
            options: {
                chart: {
                    height: 270,
                    width: "100%"
                }
            }
        }, {
            breakpoint: 426,
            options: {
                chart: {
                    height: 250,
                    offsetX: -20,
                    width: 250
                }
            }
        }]
    };

    var chart_pie_donut = new ApexCharts(document.querySelector("#sales-of-the-month"), option_Sales_of_the_Month);
    chart_pie_donut.render();
    // -----------------------------------------------------------------------
    // Income of the year chart
    // -----------------------------------------------------------------------

       var options_Income_of_the_Year = {
        series: [{
            name: 'Growth ',
            data: [5, 4, 3, 7, 5, 10, 3]
        }, {
            name: 'Net ',
            data: [3, 2, 9, 5, 4, 6, 4]
        }],
        chart: {
            fontFamily: 'Poppins,sans-serif',
            type: 'bar',
            height: 315,
            offsetY: 10,
            toolbar: {
                show: false,
            },
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
        colors: ['#009efb', '#39c449'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                endingShape: 'flat'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 5,
            colors: ['transparent']
        },
        xaxis: {
            type: 'category',
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            tickAmount: '16',
            tickPlacement: 'on',
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
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
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: "dark",
        },
        legend: {
            show: false
        }
    };

    var chart_column_basic = new ApexCharts(document.querySelector("#income-of-the-year"), options_Income_of_the_Year);
    chart_column_basic.render();
});    