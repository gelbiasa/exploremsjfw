@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
{{-- section content --}}
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => ''])
    <div class="card shadow-lg mx-4">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-lg">
                    <div class="nav-wrapper">
                        {{-- button back --}}
                        <button class="btn btn-secondary mb-0" onclick="history.back()"><i class="fas fa-circle-left me-1">
                            </i><span class="font-weight-bold">Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="text-uppercase text-sm">Detail {{ $title_menu }}</p>
                        <hr class="horizontal dark mt-0">

                        @if(isset($order) && $order)
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Informasi Order</h6>
                                    <div class="form-group">
                                        <label class="form-control-label">ID Order</label>
                                        <input class="form-control bg-dark text-light" type="text" disabled
                                            value="{{ $order->trordr_id }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Tanggal Order</label>
                                        <input class="form-control" type="text" disabled
                                            value="{{ date('d/m/Y', strtotime($order->ordr_order_date)) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Total Amount</label>
                                        <input class="form-control" type="text" disabled
                                            value="Rp {{ number_format($order->ordr_total_amount, 0, ',', '.') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6>Informasi Customer</h6>
                                    <div class="form-group">
                                        <label class="form-control-label">Nama Customer</label>
                                        <input class="form-control" type="text" disabled value="{{ $order->cust_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Email</label>
                                        <input class="form-control" type="text" disabled value="{{ $order->cust_email }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Telepon</label>
                                        <input class="form-control" type="text" disabled value="{{ $order->cust_phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Alamat</label>
                                        <textarea class="form-control" disabled>{{ $order->cust_address }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="horizontal dark">
                            <h6>Item Yang Dipilih</h6>
                            @if(isset($currentOrderItem))
                                <div class="table-responsive">
                                    <table class="table display">
                                        <thead class="thead-light" style="background-color: #00b7bd4f;">
                                            <tr>
                                                <th>ID Item</th>
                                                <th>Nama Produk</th>
                                                <th>Quantity</th>
                                                <th>Harga Satuan</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr style="background-color: #d2d6da;">
                                                <td class="text-sm font-weight-bold text-dark">{{ $currentOrderItem->trordr_it_id }}
                                                </td>
                                                <td class="text-sm font-weight-normal">{{ $currentOrderItem->pdrk_name }}</td>
                                                <td class="text-sm font-weight-normal">{{ $currentOrderItem->ordr_it_quantity }}
                                                </td>
                                                <td class="text-sm font-weight-normal">Rp
                                                    {{ number_format($currentOrderItem->ordr_it_price, 0, ',', '.') }}</td>
                                                <td class="text-sm font-weight-normal">Rp
                                                    {{ number_format($currentOrderItem->ordr_it_subtotal, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <h6>Semua Item dalam Order Ini</h6>
                            @if($orderItems && $orderItems->count() > 0)
                                <div class="table-responsive">
                                    <table class="table display">
                                        <thead class="thead-light" style="background-color: #00b7bd4f;">
                                            <tr>
                                                <th>No</th>
                                                <th>ID Item</th>
                                                <th>Nama Produk</th>
                                                <th>Quantity</th>
                                                <th>Harga Satuan</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orderItems as $index => $item)
                                                <tr @if(isset($currentOrderItem) && $item->trordr_it_id == $currentOrderItem->trordr_it_id)
                                                style="background-color: #d2d6da;" @endif>
                                                    <td class="text-sm font-weight-normal">{{ $index + 1 }}</td>
                                                    <td class="text-sm font-weight-bold text-dark">
                                                        {{ $item->trordr_it_id }}
                                                        @if(isset($currentOrderItem) && $item->trordr_it_id == $currentOrderItem->trordr_it_id)
                                                            <span class="badge bg-primary">CURRENT</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-sm font-weight-normal">{{ $item->pdrk_name }}</td>
                                                    <td class="text-sm font-weight-normal">{{ $item->ordr_it_quantity }}</td>
                                                    <td class="text-sm font-weight-normal">Rp
                                                        {{ number_format($item->ordr_it_price, 0, ',', '.') }}</td>
                                                    <td class="text-sm font-weight-normal">Rp
                                                        {{ number_format($item->ordr_it_subtotal, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr style="font-weight: bold;">
                                                <td colspan="5" class="text-right">Total:</td>
                                                <td>Rp {{ number_format($order->ordr_total_amount, 0, ',', '.') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            @endif
                        @else
                            <div class="alert alert-danger">
                                Data order tidak ditemukan!
                            </div>
                        @endif

                        <div class="row px-2 py-2">
                            <div class="col-lg">
                                <div class="nav-wrapper"><code>Note : <i aria-hidden="true" style=""
                                                class="fas fa-circle text-dark"></i> Data primary key</code></div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection