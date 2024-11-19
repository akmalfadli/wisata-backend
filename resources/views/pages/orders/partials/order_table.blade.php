<div id="tabel-container" class="section-body">
    <div class="row">
        <div class="col-12">
            @include('layouts.alert')
        </div>
    </div>
    <h2 class="section-title">Orders</h2>
    @php $total = 0; @endphp

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    {{-- Uncomment this block if needed --}}
                    {{--
                    <div class="float-right">
                        <form method="GET" action="{{ route('order.index') }}">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="name">
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    --}}
                    <div class="row">
                        @php
                            $colors = ["bg-success", "bg-primary", "bg-warning", "bg-info", "bg-secondary"];
                            $i = 0;
                        @endphp
                        @foreach ($sales as $key => $val)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon {{ $colors[$i % count($colors)] }}">
                                        <i class="far fa-newspaper"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4>{{ $key }}</h4>
                                        </div>
                                        <div class="card-body">
                                            @money($val)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $i++; @endphp
                        @endforeach
                    </div>
                    <div class="clearfix mb-3"></div>
                    <div class="row">
                        <div class="col">
                            <h4>All Orders</h4>
                        </div>
                        <div class="col col-md-auto">
                               <span>Date Range</span>
                        </div>
                        <div class="col col-lg-3 ml-4">
                            <input class="form-control form-control-sm" type="text" name="daterange" value="11/11/2024 - 12/12/2024" />
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table-striped table">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Transaction Time</th>
                                    <th>Payment Method</th>
                                    <th>Total Price</th>
                                    <th>Total Item</th>
                                    <th>Cashier</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}">
                                                {{ \Carbon\Carbon::parse($order->transaction_time)->format('d F Y H:i:s') }}
                                            </a>
                                        </td>
                                        <td>{{ $order->payment_method }}</td>
                                        <td>{{ $order->total_price }}</td>
                                        <td>{{ $order->total_item }}</td>
                                        <td>{{ $order->cashier->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right">
                        {{ $orders->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
