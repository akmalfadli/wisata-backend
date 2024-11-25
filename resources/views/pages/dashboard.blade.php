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
                <h1>Dashboard</h1>
            </div>
            <div class="row">
                @php
                    $colors = ["bg-success", "bg-primary", "bg-danger", "bg-info", "bg-secondary"];
					$icons = ["fa-motorcycle", "fa-child", "fa-home", "fa-newspaper", "fa-ice-cream"];
                    $i = 0;
                @endphp
                @foreach ($sales as $key => $val)
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon {{ $colors[$i % count($colors)] }}">
                            <i class="fa {{$icons[$i % count($icons)]}} fa-2x" style="color:white"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>{{ $key }}</h4>
                            </div>
                            <div class="card-body" style="font-weight: bold; font-size:16px">
                                @money($val)
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
                            <h4>Statistik Pendapatan</h4>
                            <div class="card-header-action">
                                <div class="btn-group">
                                    <a id="week" href="#"
                                        class="btn btn-secondary">Week</a>
                                    <a id="month" href="#"
                                        class="btn btn-primary">Month</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body mb-4">
                            <div id="chartContainer">
 								<canvas id="myChart" height="140"></canvas>
							</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                			<div class="d-flex justify-content-between">

                				<h4>Aktifitas Terbaru</h4>

                				<a href="{{ route('orders.index') }}" class="btn btn-primary btn-sm btn-round ml-5">
                    				View All
                				</a>
                			</div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                			@foreach ($latestOrders as $order)
                                <li class="media">
                                    <img class="rounded-circle mr-3"
                                        width="50"
                                        src="{{ asset('img/avatar/avatar-1.png') }}"
                                        alt="avatar">
                                    <div class="media-body">
                                        <div class="text-primary float-right">{{$order->created_at->diffForHumans()}}</div>
                                        <div class="media-title">{{$order->cashier_name}}</div>
                                        <span class="text-small text-muted">Membuat pesanan {{$order->total_item}} item dengan jumlah @money($order->total_price)</span>
                                    </div>
                                </li>
                			@endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <div class="row">

                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body pt-2 pb-2">
                            <div id="myWeather">Please wait</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Authors</h4>
                        </div>
                        <div class="card-body">
                            <div class="row pb-2">
                                <div class="col-6 col-sm-3 col-lg-3 mb-md-0 mb-4">
                                    <div class="avatar-item mb-0">
                                        <img alt="image"
                                            src="{{ asset('img/avatar/avatar-5.png') }}"
                                            class="img-fluid"
                                            data-toggle="tooltip"
                                            title="Alfa Zulkarnain">
                                        <div class="avatar-badge"
                                            title="Editor"
                                            data-toggle="tooltip"><i class="fas fa-wrench"></i></div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-lg-3 mb-md-0 mb-4">
                                    <div class="avatar-item mb-0">
                                        <img alt="image"
                                            src="{{ asset('img/avatar/avatar-4.png') }}"
                                            class="img-fluid"
                                            data-toggle="tooltip"
                                            title="Egi Ferdian">
                                        <div class="avatar-badge"
                                            title="Admin"
                                            data-toggle="tooltip"><i class="fas fa-cog"></i></div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-lg-3 mb-md-0 mb-4">
                                    <div class="avatar-item mb-0">
                                        <img alt="image"
                                            src="{{ asset('img/avatar/avatar-1.png') }}"
                                            class="img-fluid"
                                            data-toggle="tooltip"
                                            title="Jaka Ramadhan">
                                        <div class="avatar-badge"
                                            title="Author"
                                            data-toggle="tooltip"><i class="fas fa-pencil-alt"></i></div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-3 col-lg-3 mb-md-0 mb-4">
                                    <div class="avatar-item mb-0">
                                        <img alt="image"
                                            src="{{ asset('img/avatar/avatar-2.png') }}"
                                            class="img-fluid"
                                            data-toggle="tooltip"
                                            title="Ryan">
                                        <div class="avatar-badge"
                                            title="Admin"
                                            data-toggle="tooltip"><i class="fas fa-cog"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                <!--
                    <div class="card">
                        <div class="card-header">
                            <h4>Referral URL</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">2,100</div>
                                <div class="font-weight-bold mb-1">Google</div>
                                <div class="progress"
                                    data-height="3">
                                    <div class="progress-bar"
                                        role="progressbar"
                                        data-width="80%"
                                        aria-valuenow="80"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">1,880</div>
                                <div class="font-weight-bold mb-1">Facebook</div>
                                <div class="progress"
                                    data-height="3">
                                    <div class="progress-bar"
                                        role="progressbar"
                                        data-width="67%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">1,521</div>
                                <div class="font-weight-bold mb-1">Bing</div>
                                <div class="progress"
                                    data-height="3">
                                    <div class="progress-bar"
                                        role="progressbar"
                                        data-width="58%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">884</div>
                                <div class="font-weight-bold mb-1">Yahoo</div>
                                <div class="progress"
                                    data-height="3">
                                    <div class="progress-bar"
                                        role="progressbar"
                                        data-width="36%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">473</div>
                                <div class="font-weight-bold mb-1">Kodinger</div>
                                <div class="progress"
                                    data-height="3">
                                    <div class="progress-bar"
                                        role="progressbar"
                                        data-width="28%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="text-small font-weight-bold text-muted float-right">418</div>
                                <div class="font-weight-bold mb-1">Multinity</div>
                                <div class="progress"
                                    data-height="3">
                                    <div class="progress-bar"
                                        role="progressbar"
                                        data-width="20%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="card">
                        <div class="card-header">
                			<div class="col">
                            	<h4>Produk Populer</h4>
                				<p>Membandingkan pendapatan kemarin dengan hari yang sama minggu lalu.</p>
                			</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                				@foreach($resultsCompare as $results)

                                		<div class="col text-center">
                                    		<img src="{{ asset('storage/' . $results['product_image']) }}" alt="{{ $results['product_name'] }}" style="width: 50px;" >
                                    		<div class="font-weight-bold mt-2">{{$results['product_name']}}</div>
                                    		<div class="text-muted text-small">
                								<span class="text-primary">
            											@if ($results['percentage_change'] > 0)
                											<i class="fas fa-caret-up" style="color: green;"></i>
            											@elseif ($results['percentage_change'] < 0)
            												<i class="fas fa-caret-down" style="color: red;"></i>
            											@else
            												<i class="fas fa-minus" style="color: gray;"></i> <!-- Optional: neutral color for 0% -->
            											@endif
            									</span>
                								{{$results['percentage_change']}}%</div>
                                			</div>

                				@endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card mt-sm-5 mt-md-0">
                        <div class="card-header">
                            <h4>Visitors</h4>
                        </div>
                        <div class="card-body">
                            <div id="visitorMap"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Minggu ini</h4>
                            <div class="card-header-action">
                                <div class="dropdown">
                                    <a href="#"
                                        class="dropdown-toggle btn btn-primary"
                                        data-toggle="dropdown">Filter</a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#"
                                            class="dropdown-item has-icon"><i class="far fa-circle"></i> Electronic</a>
                                        <a href="#"
                                            class="dropdown-item has-icon"><i class="far fa-circle"></i> T-shirt</a>
                                        <a href="#"
                                            class="dropdown-item has-icon"><i class="far fa-circle"></i> Hat</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#"
                                            class="dropdown-item">View All</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="summary">
                                <div class="summary-info">
                                    <h4>@money($salesByProducts->sum('total_sales'))</h4>
                                    <div class="text-muted">{{$salesByProducts->sum('total_item')}} Items Sold!</div>
                                    <div class="d-block mt-2">
                                        <a href="{{route('orders.index')}}">View All</a>
                                    </div>
                                </div>
                                <div class="summary-item">
                                    <h6>Item List <span class="text-muted">({{count($salesByProducts)}} Items)</span></h6>
                                    <ul class="list-unstyled list-unstyled-border">

                						@foreach($salesByProducts as $product)
                                        <li class="media">
                                            <a href="#">
                                                <img class="mr-3 rounded"
												     width="50"
												     src="{{ asset('storage/' . $product->image) }}"
												     alt="product">

                                            </a>
                                            <div class="media-body">
                                                <div class="media-right">@money($product->total_sales)</div>
                                                <div class="media-title"><a href="#">{{$product->name}}</a></div>
                                                <div class="text-muted text-small">by <a href="#">{{$product->cashier_name}}</a>
                									<div class="bullet"></div> {{$product->total_item}} item terjual
                                                </div>
                                            </div>
                                        </li>
                						@endforeach
                                    </ul>
                                </div>
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
        const chartData = {!! json_encode($paymentSumsPerDate) !!};
        const dateOptions = { month: 'short', day: 'numeric' }; // Format dates as 'Month Day'

        // Chart configuration
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [], // Initialize with empty labels
                datasets: [
                    {
                        label: 'Statistik Pendapatan',
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
                const dateObj = new Date(item.date);
                const formattedDate = dateObj.toLocaleDateString('en-US', dateOptions);
                dateArray.push(formattedDate);
                totalPayment.push(item.total_payment);
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
                url: '{{ route('home') }}',
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
        $("#week").click(function (event) {
            event.preventDefault();
            $("#month").removeClass("btn-primary").addClass("btn-secondary");
            $(this).removeClass("btn-secondary").addClass("btn-primary");
            fetchData("week");
        });

        // Handle "month" button click
        $("#month").click(function (event) {
            event.preventDefault();
            $("#week").removeClass("btn-primary").addClass("btn-secondary");
            $(this).removeClass("btn-secondary").addClass("btn-primary");
            fetchData("month");
        });
    });
	</script>


@endpush
