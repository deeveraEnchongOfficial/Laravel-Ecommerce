@extends('backend.layouts.master')
@section('title', 'E-SHOP || DASHBOARD')
@section('main-content')
    <div class="container-fluid" style=" height: 100%;">
        @include('backend.layouts.notification')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Category -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary bg-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Category</div>
                                <div class="h5 mb-0 font-weight-bold text-white">
                                    {{ \App\Models\Category::countActiveCategory() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-sitemap fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success bg-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Products</div>
                                <div class="h5 mb-0 font-weight-bold text-white">
                                    {{ \App\Models\Product::countActiveProduct() }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cubes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger bg-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-white text-uppercase mb-1">Order</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-white">
                                            {{ \App\Models\Order::countActiveOrder() }}</div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <!-- Earnings Overview Chart -->
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myAreaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Pie Chart -->
                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                        </div>
                        <div class="card-body">
                            <div id="pie_chart" style="height: 320px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Sales Chart -->
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Weekly Sales</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="myBarChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Earnings Chart -->
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daily Earnings Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myDailyEarningsChart" style="height: 320px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Yearly Earnings Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myYearlyEarningsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Product Sales Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="myTopSellingProductsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endsection

        @push('scripts')
            <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            {{-- pie chart --}}
            <script type="text/javascript">
                var analytics = <?php echo $users; ?>

                google.charts.load('current', {
                    'packages': ['corechart']
                });
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = google.visualization.arrayToDataTable(analytics);
                    var options = {
                        title: 'Last 7 Days registered user'
                    };
                    var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
                    chart.draw(data, options);
                }
            </script>
            {{-- line chart --}}
            <script type="text/javascript">
                const url = "{{ route('product.order.income') }}";
                Chart.defaults.global.defaultFontFamily = 'Nunito',
                    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796';

                function number_format(number, decimals, dec_point, thousands_sep) {
                    // *     example: number_format(1234.56, 2, ',', ' ');
                    // *     return: '1 234,56'
                    number = (number + '').replace(',', '').replace(' ', '');
                    var n = !isFinite(+number) ? 0 : +number,
                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                        s = '',
                        toFixedFix = function(n, prec) {
                            var k = Math.pow(10, prec);
                            return '' + Math.round(n * k) / k;
                        };
                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                    if (s[0].length > 3) {
                        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                    }
                    if ((s[1] || '').length < prec) {
                        s[1] = s[1] || '';
                        s[1] += new Array(prec - s[1].length + 1).join('0');
                    }
                    return s.join(dec);
                }

                // Area Chart Example
                var ctx = document.getElementById("myAreaChart");

                axios.get(url)
                    .then(function(response) {
                        const data_keys = Object.keys(response.data);
                        const data_values = Object.values(response.data);
                        var myLineChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: data_keys, // ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                datasets: [{
                                    label: "Earnings",
                                    lineTension: 0.3,
                                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                                    borderColor: "rgba(78, 115, 223, 1)",
                                    pointRadius: 3,
                                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHoverRadius: 3,
                                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                    pointHitRadius: 10,
                                    pointBorderWidth: 2,
                                    data: data_values, // [0, 10000, 5000, 15000, 10000, 20000, 15000, 25000, 20000, 30000, 25000, 40000],
                                }],
                            },
                            options: {
                                maintainAspectRatio: false,
                                layout: {
                                    padding: {
                                        left: 10,
                                        right: 25,
                                        top: 25,
                                        bottom: 0
                                    }
                                },
                                scales: {
                                    xAxes: [{
                                        time: {
                                            unit: 'date'
                                        },
                                        gridLines: {
                                            display: false,
                                            drawBorder: false
                                        },
                                        ticks: {
                                            maxTicksLimit: 7
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            maxTicksLimit: 5,
                                            padding: 10,
                                            // Include a dollar sign in the ticks
                                            callback: function(value, index, values) {
                                                return '₱' + number_format(value);
                                            }
                                        },
                                        gridLines: {
                                            color: "rgb(234, 236, 244)",
                                            zeroLineColor: "rgb(234, 236, 244)",
                                            drawBorder: false,
                                            borderDash: [2],
                                            zeroLineBorderDash: [2]
                                        }
                                    }],
                                },
                                legend: {
                                    display: false
                                },
                                tooltips: {
                                    backgroundColor: "rgb(255,255,255)",
                                    bodyFontColor: "#858796",
                                    titleMarginBottom: 10,
                                    titleFontColor: '#6e707e',
                                    titleFontSize: 14,
                                    borderColor: '#dddfeb',
                                    borderWidth: 1,
                                    xPadding: 15,
                                    yPadding: 15,
                                    displayColors: false,
                                    intersect: false,
                                    mode: 'index',
                                    caretPadding: 10,
                                    callbacks: {
                                        label: function(tooltipItem, chart) {
                                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
                                        }
                                    }
                                }
                            }
                        });
                    })
                    .catch(function(error) {
                        //   vm.answer = 'Error! Could not reach the API. ' + error
                        console.log(error)
                    });
            </script>

            <script type="text/javascript">
                const urlBarChart = "{{ route('weekly.income') }}"; // Update the URL for your weekly income data
                const ctxBar = document.getElementById("myBarChart").getContext('2d');

                axios.get(urlBarChart)
                    .then(function(response) {
                        var userRegistrationData = response.data;
                        var barChart = new Chart(ctxBar, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(userRegistrationData),
                                datasets: [{
                                    label: "Weekly Earnings",
                                    backgroundColor: "rgba(78, 115, 223, 0.9)",
                                    hoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                    borderColor: "rgba(78, 115, 223, 0.8)",
                                    data: Object.values(userRegistrationData),
                                }],
                            },
                            options: {
                                maintainAspectRatio: false,
                                layout: {
                                    padding: {
                                        left: 10,
                                        right: 25,
                                        top: 25,
                                        bottom: 0
                                    }
                                },
                                scales: {
                                    xAxes: [{
                                        time: {
                                            unit: 'week'
                                        },
                                        gridLines: {
                                            display: false,
                                            drawBorder: false
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            maxTicksLimit: 5,
                                            padding: 10,
                                            callback: function(value) {
                                                return value;
                                            }
                                        },
                                        gridLines: {
                                            color: "rgb(234, 236, 244)",
                                            zeroLineColor: "rgb(234, 236, 244)",
                                            drawBorder: false,
                                            borderDash: [2],
                                            zeroLineBorderDash: [2]
                                        }
                                    }],
                                },
                                legend: {
                                    display: false
                                },
                                tooltips: {
                                    backgroundColor: "rgb(255,255,255)",
                                    bodyFontColor: "#858796",
                                    titleMarginBottom: 10,
                                    titleFontColor: '#6e707e',
                                    titleFontSize: 14,
                                    borderColor: '#dddfeb',
                                    borderWidth: 1,
                                    xPadding: 15,
                                    yPadding: 15,
                                    displayColors: false,
                                    intersect: false,
                                    mode: 'index',
                                    caretPadding: 10,
                                }
                            }
                        });
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            </script>

            <script type="text/javascript">
                const yearlyEarningsUrl = "{{ route('yearly.earnings') }}"; // Update the URL for your yearly earnings data
                const yearlyEarningsChartElement = document.getElementById("myYearlyEarningsChart");
                const yearlyEarningsChart = new Chart(yearlyEarningsChartElement, {
                    type: 'line', // Use 'line' for a line chart
                    data: {
                        labels: [],
                        datasets: [{
                            label: "Yearly Earnings",
                            backgroundColor: "rgba(78, 115, 223, 0.5)", // Background color for the area under the line
                            borderColor: "rgba(78, 115, 223, 1)", // Line color
                            pointRadius: 5, // Size of data points
                            pointBackgroundColor: "rgba(78, 115, 223, 1)", // Color of data points
                            pointBorderColor: "rgba(255, 255, 255, 0.8)", // Border color of data points
                            pointHoverRadius: 8, // Size of data points on hover
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)", // Color of data points on hover
                            pointHoverBorderColor: "rgba(255, 255, 255, 1)", // Border color of data points on hover
                            data: [],
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    callback: function(value) {
                                        return '₱' + value;
                                    }
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                },
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                        }
                    }
                });

                axios.get(yearlyEarningsUrl)
                    .then(function(response) {
                        const yearlyEarningsData = response.data;
                        yearlyEarningsChart.data.labels = Object.keys(yearlyEarningsData);
                        yearlyEarningsChart.data.datasets[0].data = Object.values(yearlyEarningsData);
                        yearlyEarningsChart.update(); // Update the chart after setting the data
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            </script>

            <script type="text/javascript">
                const dailyEarningsUrl = "{{ route('daily.earnings') }}"; // Update the URL for your daily earnings data
                const dailyEarningsChartElement = document.getElementById("myDailyEarningsChart");
                const dailyEarningsChart = new Chart(dailyEarningsChartElement, {
                    type: 'line', // Use 'line' for a line chart
                    data: {
                        labels: [],
                        datasets: [{
                            label: "Daily Earnings",
                            backgroundColor: "rgba(78, 115, 223, 0.5)", // Background color for the area under the line
                            borderColor: "rgba(78, 115, 223, 1)", // Line color
                            pointRadius: 5, // Size of data points
                            pointBackgroundColor: "rgba(78, 115, 223, 1)", // Color of data points
                            pointBorderColor: "rgba(255, 255, 255, 0.8)", // Border color of data points
                            pointHoverRadius: 8, // Size of data points on hover
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)", // Color of data points on hover
                            pointHoverBorderColor: "rgba(255, 255, 255, 1)", // Border color of data points on hover
                            data: [],
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    callback: function(value) {
                                        return '₱' + value;
                                    }
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                },
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                        }
                    }
                });

                axios.get(dailyEarningsUrl)
                    .then(function(response) {
                        const dailyEarningsData = response.data;
                        dailyEarningsChart.data.labels = Object.keys(dailyEarningsData);
                        dailyEarningsChart.data.datasets[0].data = Object.values(dailyEarningsData);
                        dailyEarningsChart.update(); // Update the chart after setting the data
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            </script>

            <script type="text/javascript">
                document.addEventListener("DOMContentLoaded", function() {
                    // Get the chart data from the server (you need to define the route that returns the data)
                    axios.get('/product-sales-chart')
                        .then(function(response) {
                            // Parse the data from the server
                            var data = response.data.data;

                            // Create a Chart.js chart
                            var ctx = document.getElementById('myTopSellingProductsChart').getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: data.labels,
                                    datasets: [{
                                        label: 'Number of Orders',
                                        data: data.orderCount,
                                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        })
                        .catch(function(error) {
                            console.error('Error fetching data:', error);
                        });
                });
            </script>
        @endpush
