@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Keuangan</h1>
            </div>
            <div class="row">
                @php
                    $colors = ["bg-success", "bg-primary", "bg-danger", "bg-info", "bg-secondary"];
					$icons = ["fa-motorcycle", "fa-child", "fa-home", "fa-newspaper", "fa-ice-cream"];
                    $i = 0;
                @endphp
                @foreach ($saldos as $key => $saldo)

                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon {{ $colors[$i % count($colors)] }}">
                            <i class="fas {{$icons[$i % count($icons)]}} fa-2x" style="color:white"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{$key}}</h4>
                            </div>
                            <div class="card-body" style="font-weight: bold; font-size:16px">
                                @money($saldo)
                            </div>
                        </div>
                    </div>
                </div>
                @php $i++; @endphp
                @endforeach
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Saldo</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a id="this_month" href="#"
                                        class="btn btn-primary">This Month</a>
                                    <a id="last_month" href="#"
                                        class="btn">Last Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chartContainer">
                                <canvas id="myChart" height="140"></canvas>
                           </div>
                                <!--
                            <div class="statistic-details mt-sm-4">
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i
                                                class="fas fa-caret-up"></i></span> 7%</span>
                                    <div class="detail-value">$243</div>
                                    <div class="detail-name">Today's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-danger"><i
                                                class="fas fa-caret-down"></i></span> 23%</span>
                                    <div class="detail-value">$2,902</div>
                                    <div class="detail-name">This Week's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i
                                                class="fas fa-caret-up"></i></span>9%</span>
                                    <div class="detail-value">$12,821</div>
                                    <div class="detail-name">This Month's Sales</div>
                                </div>
                                <div class="statistic-details-item">
                                    <span class="text-muted"><span class="text-primary"><i
                                                class="fas fa-caret-up"></i></span> 19%</span>
                                    <div class="detail-value">$92,142</div>
                                    <div class="detail-name">This Year's Sales</div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Activities</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($transactions as $transaction)
                                <li class="media">
                                    <img class="rounded-circle mr-3"
                                        width="50"
                                        src="{{ asset('img/avatar/avatar-1.png') }}"
                                        alt="avatar">
                                    <div class="media-body">
                                        <div class="text-primary float-right">{{$transaction->created_at->diffForHumans()}}</div>
                                        <div class="media-title">{{$transaction->user_name}}</div>
                                        <span class="text-small text-muted">{{$transaction->name}}</span>
                                        <span class="text-small text-muted">{{$transaction->description}}</span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            <div class="pt-1 pb-1 text-center">
                                <a href="#"
                                    class="btn btn-primary btn-lg btn-round">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
    <script>

        $(document).ready(function () {
        // Reinitialize chart container
        const chartContainer = document.getElementById("chartContainer");
        chartContainer.innerHTML = '<canvas id="myChart"></canvas>';
        const ctx = document.getElementById("myChart").getContext("2d");

        // Initial chart data
        const chartData = {!! json_encode($credits) !!};


        const dateOptions = { month: 'short', day: 'numeric' }; // Format dates as 'Month Day'

        // Chart configuration
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // Initialize with empty labels
                datasets: [
                    {
                        label: 'Statistik Saldo',
                        backgroundColor: 'rgba(254,86,83,.7)',
                        borderColor: 'rgba(254,86,83,.7)',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4,
                        data: [], // Initialize with empty data
                    },
                ],
            },
            options: {
                responsive: true,
                legend: { display: false },
                scales: {
                    yAxes: [
                        {
                            gridLines: {
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                            ticks: {
                                beginAtZero: true, // Ensure it starts from zero
                                stepSize: 1500000, // Adjust as needed
                            },
                        },
                    ],
                    xAxes: [
                        {
                            gridLines: { display: false },
                        },
                    ],
                },
            },
        });

        // Helper function to format and update chart data
        function updateChart(data) {
            const dateArray = [];
            const totalPayment = [];
            data.forEach((item) => {
                // console.log(item);
                const dateObj = new Date(item.credit_date);
                const formattedDate = dateObj.toLocaleDateString('en-US', dateOptions);
                dateArray.push(formattedDate);
                totalPayment.push(item.total_nominal);
            });

            myChart.data.labels = dateArray;
            myChart.data.datasets[0].data = totalPayment;
            myChart.update();
        }

        // Initialize chart with backend data
        updateChart(chartData);

        // AJAX helper function to fetch and update chart
        function fetchData(dateRange) {
            $.ajax({
                url: '{{ route('keuangan') }}',
                type: 'GET',
                data: { date: dateRange },
                success: function (response) {
                    updateChart(response);
                },
                error: function (xhr, status, error) {
                    console.error(`Error fetching data for ${dateRange} range:`, error);
                },
            });
        }

        // Handle "week" button click
        $("#last_month").click(function (event) {
            event.preventDefault();
            $("#this_month").removeClass("btn-primary").addClass("btn-secondary");
            $(this).removeClass("btn-secondary").addClass("btn-primary");
            fetchData("last_month");
        });

        // Handle "month" button click
        $("#this_month").click(function (event) {
            event.preventDefault();
            $("#last_month").removeClass("btn-primary").addClass("btn-secondary");
            $(this).removeClass("btn-secondary").addClass("btn-primary");
            fetchData("this_month");
        });
    });
    </script>
@endpush
