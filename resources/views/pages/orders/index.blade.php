@extends('layouts.app')

@section('title', 'Orders')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endpush

@section('main')
    <div id="data-container" class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Orders</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Orders</a></div>
                    <div class="breadcrumb-item">All Orders</div>
                </div>
            </div>
            <div id="table-container">
                @include('pages.orders.partials.order_table')
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

	<script>
		function initializeDateRangePicker() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end) {
                console.log("Date selected: " + start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD'));

                // Send AJAX Request
                $.ajax({
                    url: '{{ route('orders.index') }}',
                    type: 'GET',
                    data: {
                        start: start.format('YYYY-MM-DD'),
                        end: end.format('YYYY-MM-DD'),
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('#table-container').html('<div class="text-center py-5"><div class="spinner-border text-primary"></div></div>');
                    },
                    success: function(response) {
                        // Replace table content
                        $('#table-container').html(response.html);
                        // Reinitialize date picker
                        initializeDateRangePicker();

                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        $('#table-container').html('<p class="text-danger">Failed to load data. Please try again.</p>');
                    }
                });
            });
        }

        // Initialize Date Range Picker on Page Load
        $(document).ready(function() {
            initializeDateRangePicker();
        });
    </script>

@endpush
