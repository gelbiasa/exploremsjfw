@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])
{{-- section content --}}
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => ''])
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="row mb-2 mx-1">
                    <div class="card" style="min-height: 650px;">
                        <div class="card-header">
                            <h5 class="mb-0">List {{ $title_menu }}</h5>
                        </div>
                        <hr class="horizontal dark mt-0">
                        <div class="row px-4 py-2">
                            <div class="table-responsive">
                                <table class="table display" id="list_header">
                                    <thead class="thead-light" style="background-color: #00b7bd4f;">
                                        <tr>
                                            <th>ID Order</th>
                                            <th>Nama Customer</th>
                                            <th>Tanggal</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($table_detail_h as $order)
                                            <tr>
                                                <td class="text-sm font-weight-bold text-dark">{{ $order->trordr_id }}</td>
                                                <td class="text-sm font-weight-normal">{{ $order->nama_customer }}</td>
                                                <td class="text-sm font-weight-normal">
                                                    {{ date('d/m/Y', strtotime($order->ordr_order_date)) }}</td>
                                                <td class="text-sm font-weight-normal">Rp
                                                    {{ number_format($order->ordr_total_amount, 0, ',', '.') }}</td>
                                                <td class="text-sm font-weight-normal">
                                                    <button type="button" class="btn btn-primary mb-0 py-1 px-2"
                                                        onclick="detail('{{ encrypt($order->trordr_id) }}', '{{ $gmenuid }}', '{{ $dmenu }}')">
                                                        <i class="fas fa-info-circle"></i> Detail
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row mx-1">
                    <div class="card" style="min-height: 650px;">
                        <div class="card-header">
                            <h5 class="mb-0" id="label_detail">List Detail</h5>
                        </div>
                        <hr class="horizontal dark mt-0">
                        {{-- alert --}}
                        @include('components.alert')
                        <div class="row px-4 py-2">
                            <div class="table-responsive">
                                <table class="table display" id="list_detail">
                                    <thead class="thead-light" style="background-color: #00b7bd4f;">
                                        <tr>
                                            <th>ID Item</th>
                                            <th>Nama Produk</th>
                                            <th>Quantity</th>
                                            <th>Harga Satuan</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Data akan diisi via AJAX --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
@push('js')
    <script>
        $(document).ready(function () {
            //set table header into datatables
            $('#list_header').DataTable({
                "language": {
                    "search": "Cari :",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Maaf - Data tidak ada",
                    "info": "Data _START_ - _END_ dari _TOTAL_",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(pencarian dari _MAX_ data)"
                },
                "pageLength": 15,
                responsive: true,
                dom: 'frtip'
            });

            //set table detail into datatables (kosong dulu)
            $('#list_detail').DataTable({
                "language": {
                    "search": "Cari :",
                    "lengthMenu": "Tampilkan _MENU_ baris",
                    "zeroRecords": "Maaf - Data tidak ada",
                    "info": "Data _START_ - _END_ dari _TOTAL_",
                    "infoEmpty": "Tidak ada data",
                    "infoFiltered": "(pencarian dari _MAX_ data)"
                },
                "pageLength": 15,
                responsive: true,
                dom: 'Bfrtip',
                buttons: [{
                    text: '<i class="fas fa-plus me-1 text-lg btn-add"> </i><span class="font-weight-bold"> Tambah'
                },
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel me-1 text-lg text-success"> </i><span class="font-weight-bold"> Excel',
                    exportOptions: {
                        columns: ':visible:not(:last-child)'
                    },
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf me-1 text-lg text-danger"> </i><span class="font-weight-bold"> PDF',
                    exportOptions: {
                        columns: ':visible:not(:last-child)'
                    },
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print me-1 text-lg text-info"> </i><span class="font-weight-bold"> Print',
                    exportOptions: {
                        columns: ':visible:not(:last-child)'
                    },
                },
                ]
            });

            //set color button datatables
            $('.dt-button').addClass('btn btn-secondary');
            $('.dt-button').removeClass('dt-button');

            //setting button add
            var btnadd = $('.btn-add').parents('.btn-secondary');
            btnadd.removeClass('btn-secondary');
            btnadd.addClass('btn btn-primary');
            btnadd.attr('onclick', "window.location='{{ URL::to($url_menu . '/add') }}'");

            //check authorize button datatables
            <?= $authorize->add == '0' ? 'btnadd.remove();' : '' ?>
            <?= $authorize->excel == '0' ? "$('.buttons-excel').remove();" : '' ?>
            <?= $authorize->pdf == '0' ? "$('.buttons-pdf').remove();" : '' ?>
            <?= $authorize->print == '0' ? "$('.buttons-print').remove();" : '' ?>
        });

        // Auto refresh detail table jika ada session idtrans (setelah delete)
        @if(Session::has('idtrans') && Session::has('message'))
            @if(Session::get('class') == 'success')
                // Jika ada idtrans dan operasi berhasil, refresh detail untuk order yang bersangkutan
                var orderId = '{{ encrypt(Session::get('idtrans')) }}';
                if (orderId) {
                    setTimeout(function() {
                        detail(orderId, '{{ $gmenuid }}', '{{ $dmenu }}');
                    }, 1000);
                }
            @endif
        @endif

        // function detail ajax
        function detail(id, gmenu, dmenu) {
            $.ajax({
                url: "{{ url($url_menu) . '/ajax' }}",
                type: "GET",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    gmenu: gmenu,
                    dmenu: dmenu
                },
                success: function (data) {
                    // set title detail
                    $('#label_detail').text('List Detail -> Order ID: ' + data['ajaxid']);

                    // reset datatables
                    $('#list_detail').DataTable().destroy();
                    $('#list_detail tbody').remove();

                    // retrieve data into table
                    $('#list_detail').append('<tbody></tbody>');
                    var result = data['table_detail_d_ajax'];

                    //looping data detail
                    for (var index in result) {
                        var item = result[index];

                        // set variable columns
                        var vtd = `
                                <tr>
                                    <td class="text-sm font-weight-bold text-dark">${item.trordr_it_id}</td>
                                    <td class="text-sm font-weight-normal">${item.pdrk_name}</td>
                                    <td class="text-sm font-weight-normal">${item.ordr_it_quantity}</td>
                                    <td class="text-sm font-weight-normal">Rp ${currencyFormat(item.ordr_it_price, 0, '')}</td>
                                    <td class="text-sm font-weight-normal">Rp ${currencyFormat(item.ordr_it_subtotal, 0, '')}</td>
                                    <td class="text-sm font-weight-normal">
                                        <button type="submit" class="btn btn-primary mb-0 py-1 px-2"
                                            onclick="window.location='{{ url($url_menu . '/show/') }}/${data['encrypt_primary'][index]}'">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @if ($authorize->edit == '1')
                                            <button type="submit" class="btn btn-warning mb-0 py-1 px-2"
                                                onclick="window.location='{{ url($url_menu . '/edit/') }}/${data['encrypt_primary'][index]}'">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                        @if ($authorize->delete == '1')
                                            <form action="{{ url($url_menu) }}/${data['encrypt_primary'][index]}"
                                                method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mb-0 py-1 px-2"
                                                    onclick="return deleteData(event, '${item.trordr_it_id}', 'hapus')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            `;

                        // add rows into table
                        $('#list_detail tbody').append(vtd);
                    }

                    //redraw table into datatables
                    $('#list_detail').DataTable({
                        "language": {
                            "search": "Cari :",
                            "lengthMenu": "Tampilkan _MENU_ baris",
                            "zeroRecords": "Maaf - Data tidak ada",
                            "info": "Data _START_ - _END_ dari _TOTAL_",
                            "infoEmpty": "Tidak ada data",
                            "infoFiltered": "(pencarian dari _MAX_ data)"
                        },
                        "pageLength": 15,
                        responsive: true,
                        dom: 'Bfrtip',
                        buttons: [{
                            text: '<i class="fas fa-plus me-1 text-lg btn-add"> </i><span class="font-weight-bold"> Tambah'
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fas fa-file-excel me-1 text-lg text-success"> </i><span class="font-weight-bold"> Excel',
                            exportOptions: {
                                columns: ':visible:not(:last-child)'
                            },
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="fas fa-file-pdf me-1 text-lg text-danger"> </i><span class="font-weight-bold"> PDF',
                            exportOptions: {
                                columns: ':visible:not(:last-child)'
                            },
                        },
                        {
                            extend: 'print',
                            text: '<i class="fas fa-print me-1 text-lg text-info"> </i><span class="font-weight-bold"> Print',
                            exportOptions: {
                                columns: ':visible:not(:last-child)'
                            },
                        },
                        ]
                    });

                    //set color button datatables
                    $('.dt-button').addClass('btn btn-secondary');
                    $('.dt-button').removeClass('dt-button');

                    //setting button add
                    var btnadd = $('.btn-add').parents('.btn-secondary');
                    btnadd.removeClass('btn-secondary');
                    btnadd.addClass('btn btn-primary');
                    btnadd.attr('onclick', "window.location='{{ URL::to($url_menu . '/add') }}'");

                    //check authorize button datatables
                    <?= $authorize->add == '0' ? 'btnadd.remove();' : '' ?>
                    <?= $authorize->excel == '0' ? "$('.buttons-excel').remove();" : '' ?>
                    <?= $authorize->pdf == '0' ? "$('.buttons-pdf').remove();" : '' ?>
                    <?= $authorize->print == '0' ? "$('.buttons-print').remove();" : '' ?>
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: 'Maaf!',
                        text: 'Error mengambil data!',
                        icon: 'error',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        }

        //function delete
        function deleteData(event, name, msg) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                title: 'Konfirmasi Hapus Item',
                html: `
                <div class="text-left">
                    <p><strong>Apakah Anda yakin ingin menghapus item order ID: ${name}?</strong></p>
                    <div class="alert alert-warning mt-3">
                        <small>
                            <i class="fas fa-exclamation-triangle"></i> 
                            <strong>Perhatian:</strong><br>
                            • Stock produk akan dikembalikan<br>
                            • Total amount order akan diupdate<br>
                            • Jika ini item terakhir, seluruh order akan dihapus
                        </small>
                    </div>
                </div>
            `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus Item',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                width: '500px'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Find the closest form element and submit it manually
                    event.target.closest('form').submit();
                }
            });
        }

        // function currency
        function currencyFormat(nominal, decimal = 0, prefix = '') {
            return prefix + parseFloat(nominal).toFixed(decimal).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    </script>
@endpush