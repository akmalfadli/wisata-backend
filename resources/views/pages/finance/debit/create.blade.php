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
                <h1>Advanced Forms</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Keuangan</a></div>
                    <div class="breadcrumb-item">Credit</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Credit</h2>
                <div class="card">
                    <form action="{{ route('finance.debit.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4>Input Text</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Akun Keuangan</label>
                                <select class="form-control select2" name="account_finance">
                                    <option value="">Belum ada akun yang dipilih</option>
                                    @foreach ($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @endforeach
                                </select>

                                @error('account_finance')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

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
                            <div class="form-group">
                                <label>Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input
                                        type="text"
                                        class="form-control @error('nominal') is-invalid @enderror"
                                        name="nominal"
                                        id="nominalInput">
                                </div>
                                @error('nominal')
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
                            <div class="form-group">
                                <label for="debit_date" class="text-start">Tanggal</label> <!-- Align label to the left -->
                                <div class="row g-0">
                                    <div class="col-4"> <!-- Align the input group container to the left -->
                                        <div class="input-group">
                                            <input type="text" id="credit_date" class="form-control datetimepicker" name="debit_date" placeholder="Pilih Tanggal">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @error('debit_date')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select class="form-control select2" name="category_id" style="width: 100%">
                                            <option value="">-- Pilih Kategory --</option>
                                            @foreach ($categories as $categori)
                                                <option value="{{$categori->id}}">{{$categori->name}}</option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                        @enderror
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

    document.querySelector('form').addEventListener('submit', function(event) {
        let isValid = true;

        // Check if "Akun Keuangan" is selected
        const accountFinance = document.querySelector('select[name="account_finance"]');
        if (!accountFinance.value) {
            accountFinance.classList.add('is-invalid');
            isValid = false;
        } else {
            accountFinance.classList.remove('is-invalid');
        }

        // Check if "Name" is filled
        const name = document.querySelector('input[name="name"]');
        if (!name.value.trim()) {
            name.classList.add('is-invalid');
            isValid = false;
        } else {
            name.classList.remove('is-invalid');
        }

        // Check if "Nominal" is filled
        const nominal = document.querySelector('input[name="nominal"]');
        if (!nominal.value.trim()) {
            nominal.classList.add('is-invalid');
            isValid = false;
        } else {
            nominal.classList.remove('is-invalid');
        }

        // Check if "Description" is filled
        const description = document.querySelector('input[name="description"]');
        if (!description.value.trim()) {
            description.classList.add('is-invalid');
            isValid = false;
        } else {
            description.classList.remove('is-invalid');
        }

        // Check if "Tanggal" is filled
        const debitDate = document.querySelector('input[name="debit_date"]');
        if (!debitDate.value.trim()) {
            debitDate.classList.add('is-invalid');
            isValid = false;
        } else {
            debitDate.classList.remove('is-invalid');
        }

        // Check if "Kategori" is selected
        const category = document.querySelector('select[name="category_id"]');
        if (!category.value) {
            category.classList.add('is-invalid');
            isValid = false;
        } else {
            category.classList.remove('is-invalid');
        }

        // Prevent form submission if validation fails
        if (!isValid) {
            event.preventDefault();
        }
    });

</script>
@endpush
