@extends('dashboard-layouts.app')

@section('title')
    Dashboard
@endsection

@section('sidebar')
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 mt-3 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="javascript:void(0)">
                        <span class="sidebar-icon"><i class="fas fa-home"></i></span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/shopping-cart-finder">
                        <span class="sidebar-icon"><i class="fas fa-shopping-cart"></i></span>
                        Shopping cart finder
                    </a>
                </li>
            </ul>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>Bookings</span>
                <a class="link-secondary" href="#" aria-label="Add a new report">
                    <span class="sidebar-icon"><i class="far fa-minus-square"></i></span>
                </a>
            </h6>
            <ul class="nav flex-column mb-2 ms-2">
                <li class="nav-item">
                    <a class="nav-link" href="/bookings-calendar">
                        <span class="sidebar-icon"><i class="far fa-calendar-alt"></i></span>
                        Calendar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/bookings-searcher">
                        <span class="sidebar-icon"><i class="fas fa-search"></i></span>
                        Search
                    </a>
                </li>
            </ul>
        </div>
    </nav>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
    </div>
    <div class="row mb-3">
        <div class="col-4">
            <div class="card mb-3 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title">Q4 Goal: 50 New Clients</h5>
                    <h6 class="card-subtitle mb-2 text-muted">Total Q4 New Clients:</h6>
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped bg-info text-black" role="progressbar" style="width: {{round(36*100/50,0)}}%;color: black;font-weight: bold" aria-valuenow="36" aria-valuemin="0" aria-valuemax="50">36 of 50</div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg">
                <div class="card-header">
                    <h5 class="card-title mb-0">Latest BOOMs</h5>
                </div>
                <div id="latest-booms-content">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card mb-3 shadow-lg">
                <div class="card-body">
                    <h5 class="card-title text-center">Closing Ratio, %</h5>
                    <div class="row text-center">
                        <div class="col-4">
                            <h6 class="card-subtitle mb-2 text-muted">Weekly</h6>
                            <canvas id="weekly-cr-container"></canvas>
                            <div><span id="weekly-cr-container-value"></span>%</div>
                        </div>
                        <div class="col-4">
                            <h6 class="card-subtitle mb-2 text-muted">Monthly</h6>
                            <canvas id="monthly-cr-container"></canvas>
                            <div><span id="monthly-cr-container-value"></span>%</div>
                        </div>
                        <div class="col-4">
                            <h6 class="card-subtitle mb-2 text-muted">Yearly</h6>
                            <canvas id="yearly-cr-container"></canvas>
                            <div><span id="yearly-cr-container-value"></span>%</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3 shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title text-center">Commissions, 2020</h5>
                            <div class="row text-center">
                                <div class="col-12" style="height: 200px;">
                                    <canvas id="commissions-paid-chart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3 shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title text-center">Pending Commissions</h5>
                            <div class="row text-center">
                                <div class="col-12 align-self-center">
                                    <h6>USD $2,345</h6>
                                    <h6>CAD $9,876</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3 shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title text-center">Your Rating</h5>
                            <div class="row text-center">
                                <div class="col-12">
                                    <h5>#2</h5>
                                    <div class="align-item-end"><a href="#">Show Team Leaderboard</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h5 class="card-title mb-0">Open opportunities</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">FirstName LastName</li>
                    <li class="list-group-item">FirstName1 LastName1</li>
                    <li class="list-group-item">FirstName2 LastName2</li>
                    <li class="list-group-item">FirstName3 LastName3</li>
                    <li class="list-group-item">FirstName4 LastName4</li>
                    <li class="list-group-item"><a href="#">Click to see full list >></a></li>
                </ul>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h5 class="card-title mb-0">Upcoming Booking Calls</h5>
                </div>
                <div id="upcoming-booking-calls-content"></div>
            </div>
        </div>
        <div class="col-4">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h5 class="card-title mb-0">Empty Call Reports</h5>
                </div>
                <div id="empty-call-reports-content"></div>
            </div>
        </div>
    </div>
{{--        <div class="col-3">
            <div class="shadow-lg p-4 mb-5 bg-info rounded text-center"><h2>XXX</h2><h3>Key Metric</h3></div>
        </div>
        <div class="col-3">
            <div class="shadow-lg p-4 mb-5 bg-warning rounded text-center"><h2>XXX</h2><h3>Key Metric</h3></div>
        </div>
        <div class="col-3">
            <div class="shadow-lg p-4 mb-5 bg-danger rounded text-center"><h2>XXX</h2><h3>Key Metric</h3></div>
        </div>--}}
@endsection

@section('css')
   <link href="{{ asset('css/closers-dashboard.css') }}" rel="stylesheet">
   <style>
       .sidebar-icon{width:10px;}

       canvas#weekly-cr-container,
       canvas#monthly-cr-container,
       canvas#yearly-cr-container {
           max-width: 250px !important;
           height: auto !important;
           margin: auto;
       }
   </style>
@endsection


@section('modals')
    @include('closers-dashboard.common-modal')
@endsection

@section('external-jscss')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" rel="stylesheet">
    <script src="/js/gauge.min.js"></script>
    <script src="https://trademarkfactory.com/js/Chart.js"></script>
    <script type="text/javascript">

        var opts = {
            angle: 0.1, /// The span of the gauge arc
            lineWidth: 0.44, // The line thickness
            pointer: {
                length: 0.9, // Relative to gauge radius
                strokeWidth: 0.035 // The thickness
            },
            colorStart: '#6FADCF',   // Colors
            colorStop: '#8FC0DA',    // just experiment with them
            strokeColor: '#E0E0E0',   // to see which ones work best for you
            staticZones: [
                {strokeStyle: "#F03E3E", min: 0, max: 15}, // Red from 100 to 130
                {strokeStyle: "#FFDD00", min: 16, max: 30}, // Yellow
                {strokeStyle: "#30B32D", min: 31, max: 100}, // Green
            ],
            staticLabels: {
                font: "10px sans-serif",  // Specifies font
                labels: [0, 15, 30, 100],  // Print labels at these values
                color: "#000000",  // Optional: Label text color
                fractionDigits: 0  // Optional: Numerical precision. 0=round off.
            },
        };


        function paintClosingRatioGraphs(id,value) {
            var target = document.getElementById(id); // your canvas element
            var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
            gauge.setTextField(document.getElementById(id+'-value'),value+'%');
            gauge.maxValue = 100; // set max gauge value
            gauge.setMinValue(0);  // set min value
            gauge.set(value); // set actual value
        }


        paintClosingRatioGraphs('weekly-cr-container',53);
        paintClosingRatioGraphs('monthly-cr-container',40);
        paintClosingRatioGraphs('yearly-cr-container',14);

        var chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min)) + min; //Максимум не включается, минимум включается
        }

        var MONTHS = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var config = {
            type: 'line',
            data: {
                labels: MONTHS,
                datasets: [{
                    label: 'Paid, USD',
                    backgroundColor: chartColors.red,
                    borderColor: chartColors.red,
                    data: [
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000),
                        getRandomInt(1000,5000)
                    ],
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Commissions paid in 2020'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Paid, USD'
                        }
                    }]
                }
            }
        };

        window.onload = function() {
            var ctx = document.getElementById('commissions-paid-chart').getContext('2d');
            window.myLine = new Chart(ctx, config);
        };

    </script>
    @include('closers-dashboard.js')
@endsection