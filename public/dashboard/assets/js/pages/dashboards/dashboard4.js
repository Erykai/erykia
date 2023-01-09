// -------------------------------------------------------------------------------------------------------------------------------------------
// Dashboard 4 : Chart Init Js
// -------------------------------------------------------------------------------------------------------------------------------------------
$(function () {
  "use strict";
  // -----------------------------------------------------------------------
  // Total revenue chart
  // -----------------------------------------------------------------------

  var options_Total_Revenue = {
        series: [{
            name: '2020',
            data: [800000, 1200000, 1400000, 1300000, 1200000, 1400000, 1300000, 1300000, 1200000,]
        }, {
            name: '2016',
            data: [200000,400000,500000,300000,400000,500000,300000,300000,400000,]
        }, {
            name: '2015',
            data: [100000,200000,400000,600000,200000,400000,600000,600000,200000,]
        }],
        chart: {
            fontFamily: 'Poppins,sans-serif',
            type: 'bar',
            height: 360,
            stacked: true,
            toolbar: {
                show: false,
            },
            zoom: {
                enabled: true
            }
        },
        grid: {
            borderColor: 'rgba(0,0,0,0.1)',
            strokeDashArray: 3,
        },
        colors: ['#0f8edd', '#11a0f8', '#51bdff'],
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            },
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '45%',
            },
        },
        dataLabels: {
            enabled: false,
        },
        xaxis: {
          axisBorder: {
            show: false,
          },
          axisTicks: {
            show: false, 
          },
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept"],
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        yaxis: {
          tickAmount: 10,
            labels: {
                style: {
                    colors: "#a1aab2",
                },
            },
        },
        tooltip: {
            theme: "dark",
        },
        legend: {
            show: false
        },
        fill: {
            opacity: 1,
        }
    };

    var chart_column_stacked = new ApexCharts(document.querySelector("#total-revenue"), options_Total_Revenue);
    chart_column_stacked.render();
// -----------------------------------------------------------------------
// sales difference
// -----------------------------------------------------------------------

var option_Sales_Difference = {
        series: [25, 10],
        labels: ["", "", ""],
        chart: {
            type: 'donut',
            height: 150,
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
        colors: ['#39c449',  '#ebf3f5'],
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
                    height: 150,
                    width: 135
                },
            }
        }]
    };

    var chart_pie_donut = new ApexCharts(document.querySelector("#sales-difference"), option_Sales_Difference);
    chart_pie_donut.render(); 
// -----------------------------------------------------------------------
// world map
// -----------------------------------------------------------------------
  jQuery("#visitfromworld").vectorMap({
    map: "world_mill_en",
    backgroundColor: "#fff",
    borderColor: "#ccc",
    borderOpacity: 0.9,
    borderWidth: 1,
    zoomOnScroll: false,
    color: "#ddd",
    regionStyle: {
      initial: {
        fill: "rgba(0,0,0,0.1)",
      },
    },
    markerStyle: {
      initial: {
        r: 8,
        fill: "#55ce63",
        "fill-opacity": 1,
        stroke: "#000",
        "stroke-width": 0,
        "stroke-opacity": 1,
      },
    },
    enableZoom: true,
    hoverColor: "#79e580",
    markers: [
      {
        latLng: [21.0, 78.0],
        name: "India : 9347",
        style: { fill: "#55ce63" },
      },
      {
        latLng: [-33.0, 151.0],
        name: "Australia : 250",
        style: { fill: "#02b0c3" },
      },
      {
        latLng: [36.77, -119.41],
        name: "USA : 250",
        style: { fill: "#11a0f8" },
      },
      {
        latLng: [55.37, -3.41],
        name: "UK   : 250",
        style: { fill: "#745af2" },
      },
      {
        latLng: [25.2, 55.27],
        name: "UAE : 250",
        style: { fill: "#ffbc34" },
      },
    ],
    hoverOpacity: null,
    normalizeFunction: "linear",
    scaleColors: ["#fff", "#ccc"],
    selectedColor: "#c9dfaf",
    selectedRegions: [],
    showTooltip: true,
    onRegionClick: function (element, code, region) {
      var message =
        'You clicked "' +
        region +
        '" which has the code: ' +
        code.toUpperCase();
      alert(message);
    },
  });
  $("#calendar").fullCalendar("option", "height", 590);
// -----------------------------------------------------------------------
// sparkline chart
// -----------------------------------------------------------------------

   var option_Page_Views = {
        series: [{
            name: '',
            data: [0, 5, 6, 10, 9, 12, 4, 9]
        }
        ],
        chart: {
            type: 'bar',
            height: 50,
            width: 70,
            offsetX: -20,
            toolbar: {
                show: false,
            },
            sparkline: {
                enabled: true
            },
        },
        colors: ["#55ce63"],
        grid: {
            show: false,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                startingShape: 'flat',
                endingShape: 'flat',
                columnWidth: '70%',
                barHeight: '100%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 3,
            colors: ['transparent']
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: false,
            },
        },
        axisBorder: {
            show: false,
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: "dark",
            style: {
                fontSize: '12px',
                fontFamily: 'Poppins,sans-serif',
            },
            x: {
                show: false,
            },
            y: {
                formatter: undefined,
            }
        }
    };

    var chart_column_basic = new ApexCharts(document.querySelector("#page-views"), option_Page_Views);
    chart_column_basic.render();

   var option_Unique_Visits = {
        series: [{
            name: '',
            data: [0, 5, 6, 10, 9, 12, 4, 9]
        }
        ],
        chart: {
            type: 'bar',
            height: 50,
            width: 70,
            offsetX: -20,
            toolbar: {
                show: false,
            },
            sparkline: {
                enabled: true
            },
        },
        colors: ["#7460ee"],
        grid: {
            show: false,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                startingShape: 'flat',
                endingShape: 'flat',
                columnWidth: '70%',
                barHeight: '100%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 3,
            colors: ['transparent']
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: false,
            },
        },
        axisBorder: {
            show: false,
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: "dark",
            style: {
                fontSize: '12px',
                fontFamily: 'Poppins,sans-serif',
            },
            x: {
                show: false,
            },
            y: {
                formatter: undefined,
            }
        }
    };

    var chart_column_basic = new ApexCharts(document.querySelector("#unique-visits"), option_Unique_Visits);
    chart_column_basic.render();


   var option_Total_Visits = {
        series: [{
            name: '',
            data: [0, 5, 6, 10, 9, 12, 4, 9]
        }
        ],
        chart: {
            type: 'bar',
            height: 50,
            width: 70,
            offsetX: -20,
            toolbar: {
                show: false,
            },
            sparkline: {
                enabled: true
            },
        },
        colors: ["#03a9f3"],
        grid: {
            show: false,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                startingShape: 'flat',
                endingShape: 'flat',
                columnWidth: '70%',
                barHeight: '100%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: 3,
            show: true,
            colors: ['transparent']
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: false,
            },
        },
        axisBorder: {
            show: false,
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: "dark",
            style: {
                fontSize: '12px',
                fontFamily: 'Poppins,sans-serif',
            },
            x: {
                show: false,
            },
            y: {
                formatter: undefined,
            }
        }
    };

    var chart_column_basic = new ApexCharts(document.querySelector("#total-visits"), option_Total_Visits);
    chart_column_basic.render();

   var option_Bounce_Rate = {
        series: [{
            name: '',
            data: [0, 5, 6, 10, 9, 12, 4, 9]
        }
        ],
        chart: {
            type: 'bar',
            height: 50,
            width: 70,
            offsetX: -20,
            toolbar: {
                show: false,
            },
            sparkline: {
                enabled: true
            },
        },
        colors: ["#f62d51"],
        grid: {
            show: false,
        },
        plotOptions: {
            bar: {
                horizontal: false,
                startingShape: 'flat',
                endingShape: 'flat',
                columnWidth: '70%',
                barHeight: '100%',
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 3,
            colors: ['transparent']
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
            },
        },
        yaxis: {
            labels: {
                show: false,
            },
        },
        axisBorder: {
            show: false,
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: "dark",
            style: {
                fontSize: '12px',
                fontFamily: 'Poppins,sans-serif',
            },
            x: {
                show: false,
            },
            y: {
                formatter: undefined,
            }
        }
    };

    var chart_column_basic = new ApexCharts(document.querySelector("#bounce-rate"), option_Bounce_Rate);
    chart_column_basic.render();
// -----------------------------------------------------------------------
// Gauge chart option
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
        series: [100],
        colors: ["#8c76f9"],
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                track: {
                    background: '#E0E0E0',
                    startAngle: -135,
                    endAngle: 135,
                },
                hollow: {
                    size: '35%',
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
        grid: {
            padding: {
                top: 20,
            }
        },
        fill: {
            type: "solid",
        },
        stroke: {
            lineCap: "butt"
        },
        tooltip: {
          enabled: true, 
          fillSeriesColor: false,
          theme: "dark"
        },
        responsive: [{
            breakpoint: 1025,
            options: {
                chart: {
                    height: 150
                }
            }
        }, {
            breakpoint: 769,
            options: {
                chart: {
                    height: 190
                }
            }
        }, {
            breakpoint: 426,
            options: {
                chart: {
                    height: 150
                }
            }
        }],
        labels: ["Sales Prediction"]
    };

    new ApexCharts(document.querySelector("#sales-prediction"), option_Sales_Prediction).render();

  });
