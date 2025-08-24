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
                        {{-- check authorize edit --}}
                        @if ($authorize->edit == '1')
                            {{-- button save --}}
                            <button class="btn btn-primary mb-0" id="btn-save"
                                onclick="validateAndSubmitUpdate()"><i
                                    class="fas fa-floppy-disk me-1"> </i><span class="font-weight-bold">Simpan</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <form role="form" method="POST" action="{{ URL::to($url_menu . '/' . $idencrypt) }}" id="{{ $dmenu }}-form"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Edit Item {{ $title_menu }}</p>
                            <hr class="horizontal dark mt-0">
                            
                            @if(isset($order) && $order && isset($orderItem) && $orderItem)
                            <div class="row">
                                <!-- Informasi Order (readonly) -->
                                <div class="col-md-12">
                                    <h6>Informasi Order</h6>
                                    
                                    <div class="form-group">
                                        <label class="form-control-label">ID Order</label>
                                        <input type="text" class="form-control bg-dark text-light" 
                                               value="{{ $order->trordr_id }}" readonly>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="form-control-label">Customer</label>
                                        <input type="text" class="form-control" 
                                               value="{{ $order->fk_cust_id }} - {{ $order->cust_name }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Tanggal Order</label>
                                        <input type="text" class="form-control" 
                                               value="{{ date('d/m/Y', strtotime($order->ordr_order_date)) }}" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-control-label">Total Order Saat Ini</label>
                                        <input type="text" class="form-control" 
                                               value="Rp {{ number_format($order->ordr_total_amount, 0, ',', '.') }}" readonly>
                                    </div>
                                </div>

                                <!-- Edit Item Produk -->
                                <div class="col-md-12">
                                    <hr class="horizontal dark">
                                    <h6>Edit Item Produk</h6>
                                    
                                    <!-- ID Item (hidden) -->
                                    <input type="hidden" name="trordr_it_id" value="{{ $orderItem->trordr_it_id }}">
                                    
                                    <!-- Produk -->
                                    <div class="form-group">
                                        <label class="form-control-label">Produk <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="hidden" name="fk_pdrk_id" id="fk_pdrk_id" 
                                                   value="{{ $orderItem->fk_pdrk_id }}" required>
                                            <input type="hidden" name="ordr_it_price" id="ordr_it_price" 
                                                   value="{{ $orderItem->ordr_it_price }}">
                                            <input type="hidden" name="original_quantity" id="original_quantity" 
                                                   value="{{ $orderItem->ordr_it_quantity }}">
                                            <input type="hidden" name="max_stock" id="max_stock" 
                                                   value="{{ $orderItem->pdrk_stock + $orderItem->ordr_it_quantity }}">
                                            <input type="text" class="form-control" id="produk_display" 
                                                   value="{{ $orderItem->fk_pdrk_id }} - {{ $orderItem->pdrk_name }} (Stock: {{ $orderItem->pdrk_stock}})" readonly>
                                            <span class="input-group-text bg-primary text-light" data-bs-toggle="modal"
                                                data-bs-target="#produkModal" style="cursor: pointer;">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" name="ordr_it_quantity" id="ordr_it_quantity" 
                                                       class="form-control" min="1" value="{{ $orderItem->ordr_it_quantity }}"
                                                       onchange="calculateSubtotal()" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Subtotal</label>
                                                <input type="number" name="ordr_it_subtotal" id="ordr_it_subtotal" 
                                                       class="form-control" value="{{ $orderItem->ordr_it_subtotal }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-danger">
                                Data order item tidak ditemukan!
                            </div>
                            @endif
                            
                            <hr class="horizontal dark">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Produk -->
    <div class="modal fade" id="produkModal" tabindex="-1" role="dialog" aria-labelledby="produkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="produkModalLabel">Pilih Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table display" id="produkTable">
                            <thead class="thead-light" style="background-color: #00b7bd4f;">
                                <tr>
                                    <th width="80px">Action</th>
                                    <th>ID</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $produk = DB::table('mst_produk')->where('isactive', '1')->get();
                                @endphp
                                @foreach($produk as $prod)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm"
                                                onclick="selectProduk('{{ $prod->pdrk_id }}', '{{ $prod->pdrk_name }}', '{{ $prod->pdrk_price }}', '{{ $prod->pdrk_stock }}')">
                                            <i class="fas fa-check"></i> Pilih
                                        </button>
                                    </td>
                                    <td>{{ $prod->pdrk_id }}</td>
                                    <td>{{ $prod->pdrk_name }}</td>
                                    <td>Rp {{ number_format($prod->pdrk_price, 0, ',', '.') }}</td>
                                    <td>{{ $prod->pdrk_stock }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- check flag js on dmenu --}}
    @if ($jsmenu == '1')
        @if (view()->exists("js.{$dmenu}"))
            @push('addjs')
                {{-- file js in folder (resources/views/js) --}}
                @include('js.' . $dmenu);
            @endpush
        @else
            @push('addjs')
                <script>
                    Swal.fire({
                        title: 'JS Not Found!!',
                        text: 'Please Create File JS',
                        icon: 'error',
                        confirmButtonColor: '#028284'
                    });
                </script>
            @endpush
        @endif
    @endif
@endsection

{{-- Manual --}}
@push('js')
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#produkTable').DataTable({
                "language": {
                    "search": "Cari :",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Maaf - Data tidak ada",
                    "info": "Data _START_ - _END_ dari _TOTAL_",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(pencarian dari _MAX_ data)"
                },
                "pageLength": 5,
                responsive: true
            });
        });

        // Function select produk
        function selectProduk(id, name, price, stock) {
            // Hitung stock yang tersedia (stock asli + quantity original jika produk sama)
            const currentProductId = $('#fk_pdrk_id').val();
            const originalQuantity = parseInt($('#original_quantity').val()) || 0;
            
            let availableStock = parseInt(stock);
            if (currentProductId == id) {
                // Jika produk sama, tambahkan quantity original
                availableStock += originalQuantity;
            }
            
            $('#fk_pdrk_id').val(id);
            $('#ordr_it_price').val(price);
            $('#max_stock').val(availableStock);
            $('#produk_display').val(id + ' - ' + name + ' (Stock: ' + availableStock + ')');
            $('#produkModal').modal('hide');
            
            // Hitung ulang subtotal
            calculateSubtotal();
        }

        // Function calculate subtotal
        function calculateSubtotal() {
            const quantity = parseInt($('#ordr_it_quantity').val()) || 0;
            const price = parseFloat($('#ordr_it_price').val()) || 0;
            const maxStock = parseInt($('#max_stock').val()) || 0;
            
            // Validasi stock
            if (quantity > maxStock) {
                Swal.fire({
                    title: 'Stock Tidak Cukup!',
                    text: `Stock produk ini tinggal ${maxStock}, tidak memenuhi quantity ${quantity}`,
                    icon: 'warning',
                    confirmButtonColor: '#028284'
                });
                $('#ordr_it_quantity').val(maxStock);
                const subtotal = maxStock * price;
                $('#ordr_it_subtotal').val(subtotal);
            } else {
                const subtotal = quantity * price;
                $('#ordr_it_subtotal').val(subtotal);
            }
        }

        // Function validate and submit
        function validateAndSubmitUpdate() {
            // Validasi produk
            if (!$('#fk_pdrk_id').val()) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Silakan pilih produk terlebih dahulu',
                    icon: 'error',
                    confirmButtonColor: '#028284'
                });
                return false;
            }

            // Validasi quantity
            if (!$('#ordr_it_quantity').val() || $('#ordr_it_quantity').val() <= 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Silakan isi quantity dengan benar',
                    icon: 'error',
                    confirmButtonColor: '#028284'
                });
                return false;
            }

            document.getElementById('{{ $dmenu }}-form').submit();
        }
    </script>
@endpush