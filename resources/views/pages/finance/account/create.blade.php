@extends('layouts.app')

@section('title', 'Category Create')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Akun Keuangan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Keuangan</a></div>
                    <div class="breadcrumb-item">Akun Keuangan</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Credit</h2>
                <div class="card">
                    <form action="{{ route('finance.account.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4>Input Text</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text"
                                    class="form-control @error('name')
                                is-invalid
                            @enderror"
                                    name="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group" id="rekeningfield">
                                <label>Nomor Rekening</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-landmark"></i>
                                        </span>
                                    </div>
                                    <input
                                        type="text"
                                        class="form-control @error('rekening') is-invalid @enderror"
                                        name="account_number"
                                        id="nominalInput">
                                </div>
                                @error('rekening')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text"
                                    class="form-control @error('description')
                                is-invalid
                            @enderror"
                                    name="description">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Tipe Akun</label>
                                        <div class="selectgroup w-100">
                                            <label class="selectgroup-item">
                                                <input type="radio" name="account_type" value="bank" class="selectgroup-input"
                                                    checked="">
                                                <span class="selectgroup-button">Bank</span>
                                            </label>
                                            <label class="selectgroup-item">
                                                <input type="radio" name="account_type" value="cash" class="selectgroup-input">
                                                <span class="selectgroup-button">Cash</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    document.getElementById('nominalInput').addEventListener('input', function (e) {
        let value = this.value.replace(/[^0-9]/g, ''); // Only allow numeric values
        // this.value = value ? 'Rp ' + value : ''; // Prepend 'Rp ' to the value
    });
    // Initialize Flatpickr on the input field

    $(document).ready(function(){
        $('#credit_date').datepicker({
            format: 'yyyy-mm-dd',  // Change the date format if needed
            autoclose: true
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const rekeningField = document.getElementById('rekeningfield');
        const accountTypeInputs = document.getElementsByName('account_type');

        accountTypeInputs.forEach(input => {
            input.addEventListener('change', function () {
                if (this.value === 'cash') {
                    rekeningField.style.display = 'none'; // Hide Nomor Rekening
                } else {
                    rekeningField.style.display = 'block'; // Show Nomor Rekening
                }
            });
        });
    });
</script>
@endpush
