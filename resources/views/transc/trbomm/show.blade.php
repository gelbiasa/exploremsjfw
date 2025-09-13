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
                        {{-- check authorize edi --}}
                        @if ($authorize->edit == '1')
                            {{-- check status active --}}
                            @if ($list->isactive == 1)
                                {{-- button save --}}
                                <button class="btn btn-primary mb-0" style="display: none;" id="{{ $dmenu }}-save"
                                    onclick="event.preventDefault(); document.getElementById('{{ $dmenu }}-form').submit();"><i
                                        class="fas fa-floppy-disk me-1"> </i><span class="font-weight-bold">Simpan</button>
                                {{-- button edit --}}
                                <button class="btn btn-warning mb-0" id="{{ $dmenu }}-edit"><i
                                        class="fas fa-edit me-1"> </i><span class="font-weight-bold">Edit</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12"> {{-- sejajarkan panjang card --}}
                <div class="card shadow-sm">
                    <form role="form" method="POST" action="{{ URL::to($url_menu . '/' . $idencrypt) }}"
                        enctype="multipart/form-data" id="{{ $dmenu }}-form">
                        @csrf
                        @method('PUT')
                        <div class="card-body">

                            {{-- Detail Transaksi BOM --}}
                            <h5 class="mb-2">Detail Transaksi BOM</h5>
                            <hr class="border border-secondary opacity-25">

                            {{-- Row 1 --}}
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Resources</label>
                                    <div class="form-control bg-light">{{ $bom->resource }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Material FG/SFG</label>
                                    <div class="form-control bg-light">{{ $bom->material_fg_sfg }}</div>
                                </div>
                            </div>

                            {{-- Row 2 --}}
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Mat Type</label>
                                    <div class="form-control bg-light">{{ $bom->mat_type }}</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Width</label>
                                    <div class="form-control bg-light">{{ $bom->width }}</div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Length</label>
                                    <div class="form-control bg-light">{{ $bom->length }}</div>
                                </div>
                            </div>

                            {{-- Row 3 --}}
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label fw-bold">Capacity</label>
                                    <div class="form-control bg-light">{{ $bom->capacity }}</div>
                                </div>
                            </div>

                            <hr class="border border-secondary opacity-25">

                            {{-- Baris Yang Dipilih --}}
                            <h6 class="fw-bold">Baris Yang Dipilih</h6>
                            <div class="table-responsive">
                                <table class="table display" id="selected-row-table">
                                    <thead class="thead-light" style="background-color: #00b7bd4f;">
                                        <tr>
                                            <th>No</th>
                                            <th>ALTERNATIVE BOM TEXT</th>
                                            <th>Product QTY</th>
                                            <th>Base UOM Header</th>
                                            <th>Item Number</th>
                                            <th>Type</th>
                                            <th>COMP MATERIAL CODE (18)</th>
                                            <th>COMP DESC (40)</th>
                                            <th>COMP QTY</th>
                                            <th>UOM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($selectedRow)
                                            <tr>
                                                <td>1</td>
                                                <td>{{ $selectedRow->alternative_bom_text }}</td>
                                                <td>{{ $selectedRow->product_qty }}</td>
                                                <td>{{ $selectedRow->base_uom_header }}</td>
                                                <td>{{ $selectedRow->item_number }}</td>
                                                <td>{{ $selectedRow->type }}</td>
                                                <td>{{ $selectedRow->comp_material_code }}</td>
                                                <td>{{ $selectedRow->comp_desc }}</td>
                                                <td>{{ $selectedRow->comp_qty }}</td>
                                                <td>{{ $selectedRow->uom }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <hr class="border border-secondary opacity-25">

                            {{-- Semua Baris Pada Data Transaction BOM --}}
                            <h6 class="fw-bold">Semua Baris Pada Data Transaction BOM</h6>
                            <div class="table-responsive">
                                <table class="table display" id="all-rows-table">
                                    <thead class="thead-light" style="background-color: #00b7bd4f;">
                                        <tr>
                                            <th>No</th>
                                            <th>ALTERNATIVE BOM TEXT</th>
                                            <th>Product QTY</th>
                                            <th>Base UOM Header</th>
                                            <th>Item Number</th>
                                            <th>Type</th>
                                            <th>COMP MATERIAL CODE (18)</th>
                                            <th>COMP DESC (40)</th>
                                            <th>COMP QTY</th>
                                            <th>UOM</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allRows as $index => $row)
                                            <tr>
                                                <td>{{ $index+1 }}</td>
                                                <td>{{ $row->alternative_bom_text }}</td>
                                                <td>{{ $row->product_qty }}</td>
                                                <td>{{ $row->base_uom_header }}</td>
                                                <td>{{ $row->item_number }}</td>
                                                <td>{{ $row->type }}</td>
                                                <td>{{ $row->comp_material_code }}</td>
                                                <td>{{ $row->comp_desc }}</td>
                                                <td>{{ $row->comp_qty }}</td>
                                                <td>{{ $row->uom }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </form>
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
        $(document).ready(function() {
            //set disable all input form
            $('#{{ $dmenu }}-form').find('label').addClass('disabled');
            $('#{{ $dmenu }}-form').find('input').attr('disabled', 'disabled');
            $('#{{ $dmenu }}-form').find('select').attr('disabled', 'disabled');
            $('#{{ $dmenu }}-form').find('textarea').attr('disabled', 'disabled');
            $('#{{ $dmenu }}-form').find('input[key="true"]').parent('.form-group').css('display', '');
            $('#{{ $dmenu }}-form').find('select[key="true"]').parent('.form-group').css('display', '');
            $('.icon-modal-search').css('display', 'none');

            // Initialize DataTables untuk kedua tabel dengan framework style - TAMBAHKAN BAGIAN INI
            try {
                // Initialize Selected Row Table
                $('#selected-row-table').DataTable({
                    "language": {
                        "search": "Cari :",
                        "lengthMenu": "Tampilkan _MENU_ baris",
                        "zeroRecords": "Tidak ada baris yang dipilih",
                        "info": "Data _START_ - _END_ dari _TOTAL_",
                        "infoEmpty": "Tidak ada data",
                        "infoFiltered": "(pencarian dari _MAX_ data)",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Next",
                            "previous": "Previous"
                        }
                    },
                    "pageLength": 5,
                    "lengthMenu": [5, 10, 25, 50],
                    responsive: true,
                    dom: 'lfrtip', // Layout framework tanpa buttons
                    "order": [[ 0, "asc" ]], // Sort by No column
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "columnDefs": [
                        {
                            "targets": [0], // No column
                            "width": "5%",
                            "className": "text-center"
                        },
                        {
                            "targets": [1], // Alternative BOM Text
                            "width": "15%"
                        },
                        {
                            "targets": [2, 3], // Product QTY, Base UOM Header
                            "width": "10%",
                            "className": "text-center"
                        },
                        {
                            "targets": [4], // Item Number
                            "width": "10%",
                            "className": "text-center"
                        },
                        {
                            "targets": [5], // Type
                            "width": "8%",
                            "className": "text-center"
                        },
                        {
                            "targets": [6, 7], // Comp Material Code, Comp Desc
                            "width": "15%"
                        },
                        {
                            "targets": [8], // Comp QTY
                            "width": "10%",
                            "className": "text-end"
                        },
                        {
                            "targets": [9], // UOM
                            "width": "8%",
                            "className": "text-center"
                        }
                    ],
                    "responsive": {
                        "details": {
                            "type": 'column',
                            "target": 'tr'
                        }
                    }
                });

                // Initialize All Rows Table
                $('#all-rows-table').DataTable({
                    "language": {
                        "search": "Cari :",
                        "lengthMenu": "Tampilkan _MENU_ baris",
                        "zeroRecords": "Tidak ada data transaction BOM",
                        "info": "Data _START_ - _END_ dari _TOTAL_",
                        "infoEmpty": "Tidak ada data",
                        "infoFiltered": "(pencarian dari _MAX_ data)",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Next",
                            "previous": "Previous"
                        }
                    },
                    "pageLength": 10,
                    "lengthMenu": [5, 10, 25, 50],
                    responsive: true,
                    dom: 'lfrtip', // Layout framework tanpa buttons
                    "order": [[ 0, "asc" ]], // Sort by No column
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "lengthChange": true,
                    "autoWidth": false,
                    "columnDefs": [
                        {
                            "targets": [0], // No column
                            "width": "5%",
                            "className": "text-center"
                        },
                        {
                            "targets": [1], // Alternative BOM Text
                            "width": "15%"
                        },
                        {
                            "targets": [2, 3], // Product QTY, Base UOM Header
                            "width": "10%",
                            "className": "text-center"
                        },
                        {
                            "targets": [4], // Item Number
                            "width": "10%",
                            "className": "text-center"
                        },
                        {
                            "targets": [5], // Type
                            "width": "8%",
                            "className": "text-center"
                        },
                        {
                            "targets": [6, 7], // Comp Material Code, Comp Desc
                            "width": "15%"
                        },
                        {
                            "targets": [8], // Comp QTY
                            "width": "10%",
                            "className": "text-end"
                        },
                        {
                            "targets": [9], // UOM
                            "width": "8%",
                            "className": "text-center"
                        }
                    ],
                    "responsive": {
                        "details": {
                            "type": 'column',
                            "target": 'tr'
                        }
                    }
                });

                console.log('DataTables initialized successfully for show page');
            } catch (error) {
                console.error('Error initializing DataTables:', error);
            }

            // function enable input form
            function enable_text() {
                $('#{{ $dmenu }}-form').find('label').removeClass('disabled');
                $('#{{ $dmenu }}-form').find('input').removeAttr('disabled');
                $('#{{ $dmenu }}-form').find('select').removeAttr('disabled');
                $('#{{ $dmenu }}-form').find('textarea').removeAttr('disabled');
                $('#{{ $dmenu }}-form').find('input[key="true"]').parent('.form-group').css('display', 'none');
                $('#{{ $dmenu }}-form').find('select[key="true"]').parent('.form-group').css('display', 'none');
                $('.icon-modal-search').css('display', '');
            }
            
            //event button edit
            $('#{{ $dmenu }}-edit').click(function() {
                enable_text();
                $(this).css('display', 'none');
                $('#{{ $dmenu }}-save').css('display', '');
            });
        });
    </script>
@endpush
