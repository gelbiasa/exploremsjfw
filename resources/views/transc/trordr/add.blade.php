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
                        {{-- check authorize add --}}
                        @if ($authorize->add == '1')
                            {{-- button save --}}
                            <button class="btn btn-primary mb-0" id="btn-save"
                                onclick="validateAndSubmit()"><i
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
                    <form role="form" method="POST" action="{{ URL::to($url_menu) }}" id="{{ $dmenu }}-form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <p class="text-uppercase text-sm">Insert {{ $title_menu }}</p>
                            <hr class="horizontal dark mt-0">
                            
                            {{-- logika untuk add --}}
                            <div class="row">
                                <!-- Data Order -->
                                <div class="col-md-12">
                                    <h6>Informasi Order</h6>
                                    
                                    <!-- Customer -->
                                    <div class="form-group">
                                        <label class="form-control-label">Customer <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="hidden" name="fk_cust_id" id="fk_cust_id" required>
                                            <input type="text" class="form-control" id="customer_display" placeholder="Pilih Customer" readonly>
                                            <span class="input-group-text bg-primary text-light" data-bs-toggle="modal"
                                                data-bs-target="#customerModal" style="cursor: pointer;">
                                                <i class="fas fa-search"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Tanggal Order -->
                                    <div class="form-group">
                                        <label class="form-control-label">Tanggal Order <span class="text-danger">*</span></label>
                                        <input type="date" name="ordr_order_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>

                                    <!-- Jumlah Produk -->
                                    <div class="form-group">
                                        <label class="form-control-label">Jumlah Produk <span class="text-danger">*</span></label>
                                        <input type="number" id="jumlah_produk" class="form-control" min="1" max="10" 
                                               placeholder="Masukkan jumlah produk" onchange="generateProductInputs(this.value)">
                                        <small class="text-muted">Maksimal 10 produk per transaksi</small>
                                    </div>

                                    <!-- Total Amount (readonly) -->
                                    <div class="form-group">
                                        <label class="form-control-label">Total Amount</label>
                                        <input type="number" name="ordr_total_amount" id="ordr_total_amount" class="form-control" readonly>
                                    </div>

                                    <!-- Hidden fields -->
                                    <input type="hidden" name="isactive" value="1">
                                </div>

                                <!-- Detail Produk Container -->
                                <div class="col-md-12">
                                    <h6>Detail Produk</h6>
                                    <div id="product_container">
                                        <p class="text-muted">Silakan isi jumlah produk terlebih dahulu</p>
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="horizontal dark">
                        </div>
                        <div class="card-footer align-items-center pt-0 pb-2">

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Customer -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Pilih Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table display" id="customerTable">
                            <thead>
                                <tr>
                                    <th width="80px">Action</th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $customers = DB::table('mst_customer')->where('isactive', '1')->get();
                                @endphp
                                @foreach($customers as $customer)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm"
                                                onclick="selectCustomer('{{ $customer->cust_id }}', '{{ $customer->cust_name }}')">
                                            <i class="fas fa-check"></i> Pilih
                                        </button>
                                    </td>
                                    <td>{{ $customer->cust_id }}</td>
                                    <td>{{ $customer->cust_name }}</td>
                                    <td>{{ $customer->cust_email }}</td>
                                    <td>{{ $customer->cust_phone }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                            <thead>
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
            $('#customerTable').DataTable({
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

        // Variable global untuk menyimpan index produk yang sedang dipilih
        let currentProductIndex = 0;

        // Function select customer
        function selectCustomer(id, name) {
            $('#fk_cust_id').val(id);
            $('#customer_display').val(id + ' - ' + name);
            $('#customerModal').modal('hide');
        }

        // Function generate product inputs
        function generateProductInputs(jumlah) {
            const container = $('#product_container');
            container.empty();
            
            if (jumlah > 0) {
                for (let i = 1; i <= jumlah; i++) {
                    const productHtml = `
                        <div class="card mb-3 product-item" data-index="${i}">
                            <div class="card-header">
                                <h6 class="mb-0">Produk ${i}</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Produk <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="hidden" name="products[${i}][fk_pdrk_id]" id="fk_pdrk_id_${i}" required>
                                                <input type="hidden" name="products[${i}][ordr_it_price]" id="ordr_it_price_${i}">
                                                <input type="hidden" name="products[${i}][max_stock]" id="max_stock_${i}">
                                                <input type="text" class="form-control" id="produk_display_${i}" placeholder="Pilih Produk" readonly>
                                                <span class="input-group-text bg-primary text-light" 
                                                      onclick="openProdukModal(${i})" style="cursor: pointer;">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Quantity <span class="text-danger">*</span></label>
                                            <input type="number" name="products[${i}][ordr_it_quantity]" 
                                                   id="ordr_it_quantity_${i}" class="form-control" min="1" 
                                                   onchange="calculateSubtotal(${i})" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Subtotal</label>
                                            <input type="number" name="products[${i}][ordr_it_subtotal]" 
                                                   id="ordr_it_subtotal_${i}" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    container.append(productHtml);
                }
            } else {
                container.html('<p class="text-muted">Silakan isi jumlah produk terlebih dahulu</p>');
            }
        }

        // Function open produk modal
        function openProdukModal(index) {
            currentProductIndex = index;
            $('#produkModal').modal('show');
        }

        // Function select produk
        function selectProduk(id, name, price, stock) {
            const index = currentProductIndex;
            
            // Validasi produk duplikat
            if (!validateDuplicateProduct(id, index)) {
                return false;
            }
            
            $(`#fk_pdrk_id_${index}`).val(id);
            $(`#ordr_it_price_${index}`).val(price);
            $(`#max_stock_${index}`).val(stock);
            $(`#produk_display_${index}`).val(id + ' - ' + name + ' (Stock: ' + stock + ')');
            $('#produkModal').modal('hide');
            
            // Reset quantity dan subtotal
            $(`#ordr_it_quantity_${index}`).val('');
            $(`#ordr_it_subtotal_${index}`).val('');
            calculateTotal();
        }

        // Function calculate subtotal
        function calculateSubtotal(index) {
            const quantity = parseInt($(`#ordr_it_quantity_${index}`).val()) || 0;
            const price = parseFloat($(`#ordr_it_price_${index}`).val()) || 0;
            const maxStock = parseInt($(`#max_stock_${index}`).val()) || 0;
            
            // Validasi stock
            if (quantity > maxStock) {
                Swal.fire({
                    title: 'Stock Tidak Cukup!',
                    text: `Stock produk ini tinggal ${maxStock}, tidak memenuhi quantity ${quantity}`,
                    icon: 'warning',
                    confirmButtonColor: '#028284'
                });
                $(`#ordr_it_quantity_${index}`).val(maxStock);
                const subtotal = maxStock * price;
                $(`#ordr_it_subtotal_${index}`).val(subtotal);
            } else {
                const subtotal = quantity * price;
                $(`#ordr_it_subtotal_${index}`).val(subtotal);
            }
            
            calculateTotal();
        }

        // Function calculate total
        function calculateTotal() {
            let total = 0;
            $('input[name*="[ordr_it_subtotal]"]').each(function() {
                const subtotal = parseFloat($(this).val()) || 0;
                total += subtotal;
            });
            $('#ordr_total_amount').val(total);
        }

        // Function validate duplicate product
        function validateDuplicateProduct(productId, currentIndex) {
            let isDuplicate = false;
            $('input[name*="[fk_pdrk_id]"]').each(function() {
                const name = $(this).attr('name');
                const match = name.match(/\[(\d+)\]/);
                if (match) {
                    const index = match[1];
                    if (index != currentIndex && $(this).val() == productId) {
                        isDuplicate = true;
                        return false; // break loop
                    }
                }
            });
            
            if (isDuplicate) {
                Swal.fire({
                    title: 'Produk Duplikat!',
                    text: 'Produk ini sudah dipilih. Silakan pilih produk lain atau tingkatkan quantity produk yang sudah ada.',
                    icon: 'warning',
                    confirmButtonColor: '#028284'
                });
                return false;
            }
            return true;
        }

        // Function validate and submit
        function validateAndSubmit() {
            // Validasi customer
            if (!$('#fk_cust_id').val()) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Silakan pilih customer terlebih dahulu',
                    icon: 'error',
                    confirmButtonColor: '#028284'
                });
                return false;
            }

            // Validasi jumlah produk
            const jumlahProduk = $('#jumlah_produk').val();
            if (!jumlahProduk || jumlahProduk < 1) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Silakan isi jumlah produk',
                    icon: 'error',
                    confirmButtonColor: '#028284'
                });
                return false;
            }

            // Validasi setiap produk
            let isValid = true;
            for (let i = 1; i <= jumlahProduk; i++) {
                if (!$(`#fk_pdrk_id_${i}`).val()) {
                    Swal.fire({
                        title: 'Error!',
                        text: `Silakan pilih produk ${i}`,
                        icon: 'error',
                        confirmButtonColor: '#028284'
                    });
                    isValid = false;
                    break;
                }
                if (!$(`#ordr_it_quantity_${i}`).val()) {
                    Swal.fire({
                        title: 'Error!',
                        text: `Silakan isi quantity produk ${i}`,
                        icon: 'error',
                        confirmButtonColor: '#028284'
                    });
                    isValid = false;
                    break;
                }
            }

            if (isValid) {
                document.getElementById('{{ $dmenu }}-form').submit();
            }
        }
    </script>
@endpush