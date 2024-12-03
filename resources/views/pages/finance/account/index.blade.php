@extends('layouts.app')

@section('title', 'Akun Keuangan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        .custom-padding {
            padding: 10px;
        }
        .small-text {
        font-size: 12px;
        }
        .pemasukan {
            color: green;
        }
        .pengeluaran {
            color: red;
        }
        span{
            color: grey;
            font-size: 14px;
        }
        ul li::marker {
            font-size: 1.5em; /* Increase the size of the bullet */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Akun Keuangan</h1>
                <div class="section-header-button">
                    <a href="{{ route('finance.account.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Keuangan</a></div>
                    <div class="breadcrumb-item">Akun Keuangan</div>
                </div>

            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row">
                    @foreach ($accounts as $index => $account)
                        <div class="col-md-4">
                            <div class="card card-statistic-1">
                                <div class="card-wrap p-3">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col" style="line-height: 1">
                                                <h6>{{ $account['name'] }}</h6>
                                                <h8>{{ $account['account_number']?:'-' }}</8>
                                            </div>
                                            <div class="form-group">
                                                <select class="form-control select2" name="category_id" style="width: auto; min-width: 100px; border-radius: 30;" id="categorySelect{{$account['id']}}">
                                                    <option value="">Buat Transaksi</option>
                                                    <option value="1" data-url="#">Pemindahan Internal</option>
                                                    <option value="2" data-url="{{route('finance.credit.create')}}">Buat Pemasukan Lain</option>
                                                    <option value="3" data-url="{{route('finance.debit.create')}}"">Buat Pengeluaran Lain</option>
                                                </select>

                                                @error('category_id')
                                                <div class="invalid-feedback" style="display: block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChart-{{ $index }}" height="200" class="mb-4"></canvas>
                                        <div style="col">
                                            <ul style="padding-left: 20px; list-style-type: disc; line-height: 1;">
                                                <li class="small-text" style="color: green; font-size: 10px;">
                                                    <span>Pemasukan</span>
                                                    <span style="float: right;">@money($account['total_credit'])</span>
                                                </li>
                                                <li class="small-text" style="color: red; font-size: 10px;">
                                                    <span>Pengeluaran</span>
                                                    <span style="float: right;">@money($account['total_debit'])</span>
                                                </li>
                                            </ul>
                                            <div class="border-top my-2"></div>
                                            <ul style="padding-left: 5px; line-height: 1;">
                                                <li class="small-text" style="color: green; font-size: 10px; list-style-type: none;">
                                                    <span style="color:black"><i class="fas fa-wallet fa-3x text-success" style="margin-right: 5px; color:black"></i> Sisa Saldo</span>
                                                    <span style="float: right; color:black">@money($account['total_credit'] - $account['total_debit'])</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
    document.addEventListener('DOMContentLoaded', function () {

        @foreach ($accounts as $index => $account)
            // Data for each chart

            const data{{ $index }} = {
                labels: ['Pemasukan  ', 'Pengeluaran'],
                datasets: [{
                    label: 'Financial Overview',
                    data: [{!!$account['total_credit']!!}, {!!$account['total_debit']!!}], // Replace with dynamic data if available
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderColor: ['#28a745', '#dc3545'],
                    borderWidth: 1

                }]
            };

            // Config for each chart
            const config{{ $index }} = {
                type: 'doughnut',
                data: data{{ $index }},
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                        display: true,  // Enable legend display
                        position: 'left' // Position the legend to the left
                    },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    },
                }
            };

            // Initialize each chart
            const ctx{{ $index }} = document.getElementById('myChart-{{ $index }}').getContext('2d');
            new Chart(ctx{{ $index }}, config{{ $index }});

        @endforeach
    });

    @foreach ($accounts as $account)
        document.getElementById("categorySelect{{$account['id']}}").addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const url = selectedOption.getAttribute('data-url');
            if (url) {
                window.location.href = url; // Redirect in the current window
            }
        });
    @endforeach


    </script>
@endpush
