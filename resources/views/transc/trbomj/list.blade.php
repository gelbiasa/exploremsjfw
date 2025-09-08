@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => ''])
    <div class="container-fluid">
        <div class="row">
            {{-- Boleh Diedit --}}
            <div class="col-md-12">
                <div class="row mb-2 mx-1">
                    <div class="card" style="min-height: 50px;">
                        <div class="card-header">
                            <h5 class="mb-0">List {{ $title_menu }}</h5>
                        </div>
                        <hr class="horizontal dark mt-0">
                        {{-- alert --}}
                        @include('components.alert')
                        <div class="row px-4 py-2">
                            <div class="table-responsive">
                                <table class="table display" id="list_header">
                                    <thead class="thead-light" style="background-color: #00b7bd4f;">
                                        <tr>
                                            {{-- Boleh Diedit --}}
                                            <th>No</th>
                                            <th>Mat Type</th>
                                            <th>Resource</th>
                                            <th>Material FG/SFG</th>
                                            <th>Capacity</th>
                                            <th>Width</th>
                                            <th>Length</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Boleh Diedit --}}
                                        @if($table_detail_h && count($table_detail_h) > 0)
                                            @foreach ($table_detail_h as $index => $detail_h)
                                                {{-- Hanya tampilkan data yang isactive = '1' --}}
                                                @if($detail_h->isactive === '1')
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $detail_h->mat_type ?? '-' }}</td>
                                                        <td>{{ $detail_h->resource ?? '-' }}</td>
                                                        <td>{{ $detail_h->material_fg_sfg ?? '-' }}</td>
                                                        <td>{{ $detail_h->capacity ? number_format($detail_h->capacity, 2) : '0.00' }}</td>
                                                        <td>{{ $detail_h->width ? number_format($detail_h->width, 3) : '0.000' }}</td>
                                                        <td>{{ $detail_h->length ? number_format($detail_h->length, 2) : '0.00' }}</td>
                                                        <td class="text-sm font-weight-normal">
                                                            {{-- button detail --}}
                                                            <button type="button" class="btn btn-primary mb-0 py-1 px-3 btn-detail"
                                                                title="View Detail"
                                                                data-id="{{ encrypt($detail_h->trs_bom_h_id) }}"
                                                                data-gmenu="{{ $gmenuid }}"
                                                                data-dmenu="{{ $dmenu }}"
                                                                data-material="{{ $detail_h->material_fg_sfg }}">
                                                                <i class="fas fa-info-circle"></i> Detail
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center">Maaf - Data tidak ada</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Boleh diedit --}}
            <div class="col-md-12">
                <div class="row mx-1">
                    <div class="card" style="min-height: 350px;">
                        <div class="card-header">
                            <h5 class="mb-0" id="label_detail">List Detail</h5>
                        </div>
                        <hr class="horizontal dark mt-0">
                        <div class="row px-4 py-2">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="list_detail">
                                    <thead class="thead-light" style="background-color: #00b7bd4f;">
                                        <tr>
                                            <th>No</th>
                                            <th>Item No</th>
                                            <th>COMP MATERIAL CODE</th>
                                            <th>COMP DESC</th>
                                            <th>Product QTY</th>
                                            <th>Comp QTY</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detail_tbody">
                                        <tr>
                                            <td colspan="7" class="text-center">Pilih data header untuk melihat detail</td>
                                        </tr>
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
        var headerTable, detailTable;
        var detailTableInitialized = false;
        var currentDetailData = null;
        
        $(document).ready(function() {
            console.log('Document ready - initializing tables');
            
            //set table header into datatables dengan pagination 5 per halaman
            try {
                headerTable = $('#list_header').DataTable({
                    "language": {
                        "search": "Cari :",
                        "lengthMenu": "Tampilkan _MENU_ baris",
                        "zeroRecords": "Maaf - Data tidak ada",
                        "info": "Data _START_ - _END_ dari _TOTAL_",
                        "infoEmpty": "Tidak ada data",
                        "infoFiltered": "(pencarian dari _MAX_ data)",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    },
                    "pageLength": 5,  // Maksimal 5 data per halaman
                    "lengthMenu": [5, 10, 25, 50],  // Options untuk jumlah data per halaman
                    responsive: true,
                    dom: 'Blfrtip',  // Tambahkan 'l' untuk length menu
                    "order": [[ 0, "asc" ]], // Sort by No column
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "lengthChange": true,  // Enable length change dropdown
                    "columnDefs": [
                        {
                            "targets": 0,  // Column No
                            "render": function (data, type, row, meta) {
                                // Calculate row number based on current page and page length
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        }
                    ],
                    buttons: [
                        {
                            text: '<i class="fas fa-plus me-1 text-lg btn-add"> </i><span class="font-weight-bold"> Tambah',
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
                console.log('Header table initialized successfully with pagination');
            } catch (error) {
                console.error('Error initializing header table:', error);
            }

            // Initialize detail table secara sederhana tanpa DataTables dulu
            console.log('Detail table ready for manual control');

            //set color button datatables - TAMBAHKAN BAGIAN INI
            $('.dt-button').addClass('btn btn-secondary');
            $('.dt-button').removeClass('dt-button');

            //setting button add
                var btnadd = $('.btn-add').parents('.btn');
                btnadd.removeClass('btn-secondary');
                btnadd.addClass('btn btn-primary');
                btnadd.removeAttr('onclick'); // Remove default redirect
                btnadd.on('click', function(e) {
                    e.preventDefault();
                    $('#modalAddRows').modal('show');
                });
            
            // Event handler untuk button detail
            $(document).on('click', '.btn-detail', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var gmenu = $(this).data('gmenu');
                var dmenu = $(this).data('dmenu');
                var material = $(this).data('material');
                
                console.log('Button detail clicked:', {id, gmenu, dmenu, material});
                detail(id, gmenu, dmenu, material);
            });
            
            //check authorize button datatables
            <?= $authorize->add == '0' ? 'btnadd.remove();' : '' ?>
            <?= $authorize->excel == '0' ? "$('.buttons-excel').remove();" : '' ?>
            <?= $authorize->pdf == '0' ? "$('.buttons-pdf').remove();" : '' ?>
            <?= $authorize->print == '0' ? "$('.buttons-print').remove();" : '' ?>
        });

            // Event untuk tombol konfirmasi modal
            $('#confirmAddRows').on('click', function() {
                var jumlahBaris = $('#jumlahBaris').val();
                if (jumlahBaris) {
                    window.location = "{{ URL::to($url_menu . '/add') }}?rows=" + jumlahBaris;
                }
            });
        // function detail ajax
        function detail(id, gmenu, dmenu, material_name) {
            console.log('Detail function called with:', {id, gmenu, dmenu, material_name});
            
            // Show loading state
            $('#label_detail').html('<i class="fas fa-spinner fa-spin"></i> Loading Detail Data...');
            $('#detail_tbody').html('<tr><td colspan="7" class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</td></tr>');
            
            // Disable semua button detail untuk prevent multiple clicks
            $('.btn-detail').prop('disabled', true);
            
            $.ajax({
                url: "{{ url($url_menu) . '/ajax' }}",
                type: "GET",
                dataType: "JSON",
                timeout: 15000, // 15 second timeout
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    gmenu: gmenu,
                    dmenu: dmenu
                },
                beforeSend: function() {
                    console.log('Ajax request started for ID:', id);
                },
                success: function(data) {
                    console.log('Ajax response received:', data);
                    
                    try {
                        // Validate response
                        if (!data || !data.table_detail_d_ajax) {
                            throw new Error('Invalid response format');
                        }
                        
                        // Store current data
                        currentDetailData = data;
                        
                        // set title detail
                        $('#label_detail').text('List Detail -> ' + (material_name || 'Unknown'));
                        
                        // Build detail table manually
                        buildDetailTable(data.table_detail_d_ajax, data.encrypt_primary || []);
                        
                    } catch (error) {
                        console.error('Error processing response:', error);
                        showErrorMessage('Error processing data: ' + error.message);
                        $('#label_detail').text('List Detail - Error');
                        $('#detail_tbody').html('<tr><td colspan="7" class="text-center text-danger">Error loading data</td></tr>');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Ajax error:', {textStatus, errorThrown, status: jqXHR.status});
                    $('#label_detail').text('List Detail - Error');
                    
                    let errorMsg = 'Error loading data';
                    if (textStatus === 'timeout') {
                        errorMsg = 'Request timeout - please try again';
                    } else if (jqXHR.status === 400) {
                        errorMsg = 'Invalid request - please refresh page';
                    } else if (jqXHR.status === 404) {
                        errorMsg = 'Data not found or inactive';
                    } else if (jqXHR.status === 500) {
                        errorMsg = 'Server error - please try again later';
                    }
                    
                    $('#detail_tbody').html('<tr><td colspan="7" class="text-center text-danger">' + errorMsg + '</td></tr>');
                    showErrorMessage(errorMsg);
                },
                complete: function() {
                    // Re-enable semua button detail
                    $('.btn-detail').prop('disabled', false);
                    console.log('Ajax request completed');
                }
            });
        }

        function buildDetailTable(detailData, encryptKeys) {
            try {
                console.log('Building detail table manually with data:', detailData);
                
                // Clear tbody
                $('#detail_tbody').empty();
                
                // Build table content
                if (detailData && Array.isArray(detailData) && detailData.length > 0) {
                    console.log('Building table with', detailData.length, 'rows');
                    
                    var rowCount = 0;
                    for (let index = 0; index < detailData.length; index++) {
                        const item = detailData[index];
                        const encryptedId = encryptKeys[index] || '';
                        
                        // Validate item and only show active data
                        if (item && item.isactive === '1') {
                            rowCount++;
                            const row = $(`
                                <tr>
                                    <td class="text-sm font-weight-normal">${rowCount}</td>
                                    <td class="text-sm font-weight-normal">${item.item_number || '-'}</td>
                                    <td class="text-sm font-weight-normal">${item.comp_material_code || '-'}</td>
                                    <td class="text-sm font-weight-normal">${item.comp_desc || '-'}</td>
                                    <td class="text-sm font-weight-normal text-end">${item.product_qty ? parseFloat(item.product_qty).toFixed(3) : '0.000'}</td>
                                    <td class="text-sm font-weight-normal text-end">${item.comp_qty ? parseFloat(item.comp_qty).toFixed(3) : '0.000'}</td>
                                    <td class="text-sm font-weight-normal">
                                        <button type="button" class="btn btn-primary mb-0 py-1 px-2"
                                            title="View Data"
                                            onclick="window.location='{{ url($url_menu . '/show/') }}/${encryptedId}'">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                            `);
                            
                            $('#detail_tbody').append(row);
                        }
                    }
                    
                    console.log('Successfully added', rowCount, 'active rows');
                    
                    if (rowCount === 0) {
                        $('#detail_tbody').html('<tr><td colspan="7" class="text-center">Maaf - Tidak ada data detail yang aktif</td></tr>');
                    }
                } else {
                    $('#detail_tbody').html('<tr><td colspan="7" class="text-center">Maaf - Data detail tidak tersedia</td></tr>');
                    console.log('No detail data available');
                }
                
            } catch (error) {
                console.error('Error building table:', error);
                showErrorMessage('Error displaying data: ' + error.message);
                $('#label_detail').text('List Detail - Error');
                $('#detail_tbody').html('<tr><td colspan="7" class="text-center text-danger">Error displaying data</td></tr>');
            }
        }

        function showErrorMessage(message) {
            Swal.fire({
                title: 'Sorry!',
                text: message,
                icon: 'error',
                confirmButtonColor: '#3085d6'
            });
        }

        //function delete
        function deleteData(event, name, msg) {
            event.preventDefault(); // Prevent default form submission
            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah Anda Yakin ${msg} Data ${name} ini?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: `Ya, ${msg}`,
                cancelButtonText: 'Batal',
                confirmButtonColor: '#028284'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Find the closest form element and submit it manually
                    event.target.closest('form').submit();
                }
            });
        }

        // function currency
        function currencyFormat(nominal, decimal = 0, prefix = 'Rp.') {
            return prefix + ' ' + parseFloat(nominal).toFixed(decimal).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    </script>
@endpush
<!-- Modal Pilih Jumlah Baris -->
<div class="modal fade" id="modalAddRows" tabindex="-1" aria-labelledby="modalAddRowsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddRowsLabel">Pilih Jumlah Baris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="jumlahBaris" class="form-label">Berapa baris yang ingin ditambahkan?</label>
                    <input type="number" min="1" max="100" class="form-control" id="jumlahBaris" list="presetRows" value="1" placeholder="Masukkan jumlah baris...">
                    <datalist id="presetRows">
                        <option value="1">
                        <option value="2">
                        <option value="3">
                        <option value="5">
                        <option value="10">
                    </datalist>
                    <small class="form-text text-muted">Anda bisa memilih atau mengetik jumlah baris sendiri.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="confirmAddRows">Tambah</button>
            </div>
        </div>
    </div>
</div>