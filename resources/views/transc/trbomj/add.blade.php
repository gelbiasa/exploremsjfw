@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

{{-- Include Value Recommendation Component --}}
@include('components.value-recommendation')

{{-- section content --}}
@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => ''])
    
    <!-- Add CSRF token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <div class="card shadow-lg mx-4">
        <div class="card-body p-3">
            <div class="row gx-4">
                <div class="col-lg">
                    <div class="nav-wrapper">
                        {{-- button back --}}
                        <button class="btn btn-secondary mb-0" onclick="window.location='{{ URL::to($url_menu) }}'"><i class="fas fa-circle-left me-1">
                            </i><span class="font-weight-bold">Kembali</button>
                        {{-- check authorize add --}}
                        @if ($authorize->add == '1')
                            {{-- button save --}}
                            <button class="btn btn-primary mb-0"
                                onclick="validateAndSubmit()"><i
                                    class="fas fa-floppy-disk me-1"> </i><span class="font-weight-bold">Simpan</button>
                        @endif
                        {{-- button pilih jumlah page --}}
                        <button class="btn btn-success mb-0" data-bs-toggle="modal" data-bs-target="#modalAddRows">
                            <i class="fas fa-plus me-1"></i><span class="font-weight-bold">Pilih Jumlah Halaman</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <input type="number" min="1" max="100" class="form-control" id="jumlahBaris" list="presetRows" value="{{ request()->get('rows', 1) }}" placeholder="Masukkan jumlah baris...">
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

    <div class="container-fluid py-4">
        <form role="form" method="POST" action="{{ URL::to($url_menu) }}" id="{{ $dmenu }}-form" enctype="multipart/form-data">
            @csrf
            <div class="row">
                @php
                    $rows = request()->get('rows', 1);
                    $rows = is_numeric($rows) && $rows > 0 ? intval($rows) : 1;
                @endphp
                @for ($i = 1; $i <= $rows; $i++)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Form Transaksi BOM #{{ $i }}</h5>
                                @if ($i == $rows && $rows > 1)
                                <button type="button" class="btn btn-outline-danger btn-sm btn-hapus-halaman" title="Hapus Halaman" style="margin-left: 10px;">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </div>
                            <div class="row">
                                {{-- Resource Search --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Resources <span class="text-danger">*</span></label>
                                    <input type="hidden" name="bom_data[{{ $i }}][resources]" id="resources-{{ $i }}" required>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="resource_display_{{ $i }}" placeholder="Pilih Resource..." readonly>
                                        <span class="input-group-text bg-primary text-light" onclick="openResourceModal({{ $i }})" style="cursor: pointer;">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>

                                {{-- Material FG/SFG Search dengan Recommendation --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Material FG/SFG <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control material-search-recommendation" name="bom_data[{{ $i }}][material]" id="material-{{ $i }}" autocomplete="off" placeholder="Cari Material...">
                                        <span class="input-group-text bg-primary text-light material-apply-btn" style="cursor: pointer;" data-index="{{ $i }}">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>
                                </div>

                                {{-- Auto-filled fields from Resource --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Mat Type</label>
                                    <input type="text" class="form-control mat-type" name="bom_data[{{ $i }}][mat_type]" id="mat_type-{{ $i }}" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-control-label">Width</label>
                                    <input type="text" class="form-control width" name="bom_data[{{ $i }}][width]" id="width-{{ $i }}" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-control-label">Length</label>
                                    <input type="text" class="form-control length" name="bom_data[{{ $i }}][length]" id="length-{{ $i }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Capacity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control capacity" name="bom_data[{{ $i }}][capacity]" id="capacity-{{ $i }}">
                                </div>

                                {{-- Alternative BOM Text Custom dengan Recommendation --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Alternative BOM Text Custom <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text machine-code" id="machine-code-{{ $i }}"></span>
                                        <input type="text" class="form-control alt-bom-input-recommendation" name="bom_data[{{ $i }}][alt_bom_text]" id="alt_bom_text-{{ $i }}" placeholder="Input Custom...">
                                        <span class="input-group-text bg-primary text-light alt-bom-apply-btn" style="cursor: pointer;" data-index="{{ $i }}">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            
                            {{-- Detail Transaction Table --}}
                            <div class="table-responsive">
                                <table id="datatable-bom-{{ $i }}" class="table display bom-table" data-index="{{ $i }}">
                                    <thead class="thead-light" style="background-color: #00b7bd4f;">
                                        <tr>
                                            <th>No</th>
                                            <th>Material FG/SFG</th>
                                            <th>Alternative BOM Text</th>
                                            <th>Product QTY</th>
                                            <th>Base UOM Header</th>
                                            <th>Item Number</th>
                                            <th>Type</th>
                                            <th>Comp Material Code (18)</th>
                                            <th>Comp Desc (40)</th>
                                            <th>Comp QTY</th>
                                            <th>UOM</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Baris akan ditambah secara dinamis -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary btn-add-row" data-index="{{ $i }}">
                                    <i class="fas fa-plus"></i> Tambah Baris Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </form>
    </div>

    <div class="container-fluid py-2">
        <div class="row justify-content-end">
            <div class="col-auto">
                <button type="button" class="btn btn-success" id="btnTambahHalaman">
                    <i class="fas fa-plus me-1"></i> Tambah Halaman
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Resource Selection - Framework Style seperti trordr --}}
    <div class="modal fade" id="resourceModal" tabindex="-1" role="dialog" aria-labelledby="resourceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resourceModalLabel">Pilih Resource</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table display" id="resourceTable">
                            <thead style="background-color: #b0e9eb;">
                                <tr>
                                    <th width="80px">Action</th>
                                    <th>Resource</th>
                                    <th>Mat Type</th>
                                    <th>Width</th>
                                    <th>Length</th>
                                    <th>Capacity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resources as $resource)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm"
                                                onclick="selectResource('{{ $resource->resource }}', '{{ $resource->mat_type }}', '{{ $resource->width }}', '{{ $resource->length }}', '{{ $resource->capacity }}')">
                                            <i class="fas fa-check"></i> Select
                                        </button>
                                    </td>
                                    <td>{{ $resource->resource }}</td>
                                    <td>{{ $resource->mat_type }}</td>
                                    <td>{{ $resource->width }}</td>
                                    <td>{{ $resource->length }}</td>
                                    <td>{{ $resource->capacity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Component Material Selection - Framework Style seperti trordr --}}
    <div class="modal fade" id="componentModal" tabindex="-1" role="dialog" aria-labelledby="componentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="componentModalLabel">Pilih Component Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table display" id="componentTable">
                            <thead style="background-color: #b0e9eb;">
                                <tr>
                                    <th width="80px">Action</th>
                                    <th>Material Code</th>
                                    <th>Description</th>
                                    <th>UOM</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($components as $component)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm"
                                                onclick="selectComponent('{{ $component->material_code }}', '{{ $component->description }}', '{{ $component->uom }}')">
                                            <i class="fas fa-check"></i> Select
                                        </button>
                                    </td>
                                    <td>{{ $component->material_code }}</td>
                                    <td>{{ $component->description }}</td>
                                    <td>{{ $component->uom }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary" id="create-new-material">
                            <i class="fas fa-plus"></i> Buat Material Baru
                        </button>
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
$(document).ready(function() {
    let currentTargetIndex = 0;
    let currentRowIndex = 0;

    // Initialize DataTables untuk modal resource - sama seperti trordr
    $('#resourceTable').DataTable({
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Maaf - Data tidak ada",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        responsive: true
    });

    // Initialize DataTables untuk modal component - sama seperti trordr
    $('#componentTable').DataTable({
        "language": {
            "search": "Search:",
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Maaf - Data tidak ada",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        },
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
        responsive: true
    });

    // Initialize DataTable untuk setiap card dengan framework style - UBAH BAGIAN INI
    $('.bom-table').each(function() {
        $(this).DataTable({
            "language": {
                "lengthMenu": "Tampilkan _MENU_ baris",
                "zeroRecords": "Belum ada data - klik tombol 'Tambah Baris Data' untuk menambah data",
                "info": "Data _START_ - _END_ dari _TOTAL_",
                "infoEmpty": "Belum ada data",
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
            dom: 'lrtip', // Layout framework tanpa buttons dan search (hilangkan 'f')
            "order": [[ 0, "asc" ]], // Sort by No column
            "paging": true,
            "searching": false, // Disable search functionality
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
                    "targets": [1, 2], // Material FG/SFG, Alt BOM Text
                    "width": "15%"
                },
                {
                    "targets": [3, 4, 5], // Product QTY, Base UOM, Item Number
                    "width": "8%",
                    "className": "text-center"
                },
                {
                    "targets": [6], // Type
                    "width": "5%",
                    "className": "text-center"
                },
                {
                    "targets": [7, 8], // Comp Material Code, Comp Desc
                    "width": "15%"
                },
                {
                    "targets": [9], // Comp QTY
                    "width": "8%",
                    "className": "text-end"
                },
                {
                    "targets": [10], // UOM
                    "width": "8%",
                    "className": "text-center"
                },
                {
                    "targets": [11], // Action
                    "width": "8%",
                    "orderable": false,
                    "searchable": false,
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
    });

    // ========== RESOURCE SELECTION - Framework Style ==========
    // Variable global untuk menyimpan index resource yang sedang dipilih
    let currentResourceIndex = 0;

    // Function open resource modal
    function openResourceModal(index) {
        currentResourceIndex = index;
        $('#resourceModal').modal('show');
    }

    // Function select resource - sama seperti trordr
    function selectResource(resource, mat_type, width, length, capacity) {
        const index = currentResourceIndex;
        
        // Fill resource form fields
        $(`#resources-${index}`).val(resource);
        $(`#resource_display_${index}`).val(resource); // Hanya tampilkan resource saja
        $(`#mat_type-${index}`).val(mat_type);
        $(`#width-${index}`).val(width);
        $(`#length-${index}`).val(length);
        $(`#capacity-${index}`).val(capacity);
        
        // Generate machine code (last 2 digits of resource code)
        let machineCode = '';
        if(resource) {
            let resourceCode = resource.toString();
            machineCode = resourceCode.slice(-2) + '-';
        }
        $(`#machine-code-${index}`).text(machineCode);
        
        $('#resourceModal').modal('hide');
    }

    // ========== COMPONENT MATERIAL SELECTION - Framework Style ==========
    // Variable global untuk menyimpan index component yang sedang dipilih
    let currentComponentIndex = 0;

    // Function open component modal
    function openComponentModal(tableIndex, rowIndex) {
        currentTargetIndex = tableIndex;
        currentRowIndex = rowIndex;
        $('#componentModal').modal('show');
    }

    // Function select component - sama seperti trordr
    function selectComponent(code, desc, uom) {
        // Fill the specific row
        let targetRow = $(`input[name="bom_data[${currentTargetIndex}][detail][${currentRowIndex}][comp_material_code]"]`).closest('tr');
        targetRow.find('input[name*="[comp_material_code]"]').val(code);
        targetRow.find('input[name*="[comp_desc]"]').val(desc);
        targetRow.find('input[name*="[type]"]').val('L'); // Default type
        targetRow.find('input[name*="[uom]"]').val(uom);

        $('#componentModal').modal('hide');
    }

    // ========== MATERIAL FG/SFG SELECTION ==========
    // Material search with dropdown
    $(document).on('input', '.material-search', function() {
        let $this = $(this);
        let keyword = $this.val().toLowerCase();
        let index = $this.attr('id').split('-')[1];
        
        if(keyword.length >= 1) {
            searchMaterials(keyword, index);
        } else {
            $(`#material-dropdown-${index}`).hide();
        }
    });

    function searchMaterials(keyword, index) {
        $.ajax({
            url: "{{ url($url_menu . '/add') }}",
            type: 'GET',
            data: { 
                action: 'search_material',
                q: keyword 
            },
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(data) {
                renderMaterialDropdown(data, index);
            },
            error: function() {
                $(`#material-dropdown-${index}`).hide();
            }
        });
    }

    function renderMaterialDropdown(data, index) {
        let dropdown = $(`#material-dropdown-${index}`);
        let html = '';
        
        if(data.length > 0) {
            data.forEach(function(material) {
                html += `<a class="dropdown-item material-option" href="#" 
                    data-index="${index}"
                    data-material="${material.material_fg_sfg}"
                    data-desc="${material.product}"
                    data-base_uom="${material.base_uom_header}">${material.material_fg_sfg} - ${material.product}</a>`;
            });
            dropdown.html(html).show();
        } else {
            dropdown.hide();
        }
    }

    // Select material from dropdown
    $(document).on('click', '.material-option', function(e) {
        e.preventDefault();
        let index = $(this).data('index');
        let material = $(this).data('material');
        
        $(`#material-${index}`).val(material);
        $(`#material-dropdown-${index}`).hide();
    });

    // Apply Material FG/SFG to all rows
    $(document).on('click', '.material-apply-btn', function() {
        let index = $(this).data('index');
        let material = $(`#material-${index}`).val();
        
        if(!material) {
            Swal.fire('Warning', 'Pilih material terlebih dahulu!', 'warning');
            return;
        }
        
        // Load material components and create table rows
        loadMaterialComponents(material, index);
    });

    // ========== TABLE ROW MANAGEMENT - UBAH FUNCTION INI ==========
    function addTableRow(tableIndex, rowNumber, data = {}) {
        let itemNumber = (rowNumber * 10).toString().padStart(4, '0');
        let productQty = data.product_qty || '';
        let baseUomHeader = data.base_uom_header || '';

        // Create row data untuk DataTables - UBAH BAGIAN INI
        let rowData = [
            rowNumber, // No
            `<input type="text" class="form-control form-control-sm fg-input" name="bom_data[${tableIndex}][detail][${rowNumber}][material_fg_sfg]" value="${data.material_fg_sfg || ''}" readonly />`, // Material FG/SFG
            `<input type="text" class="form-control form-control-sm alt-bom-row" name="bom_data[${tableIndex}][detail][${rowNumber}][alt_bom_text]" value="${data.alt_bom_text || ''}" readonly />`, // Alternative BOM Text
            `<input type="number" class="form-control form-control-sm" name="bom_data[${tableIndex}][detail][${rowNumber}][product_qty]" value="${productQty}" readonly />`, // Product QTY
            `<input type="text" class="form-control form-control-sm" name="bom_data[${tableIndex}][detail][${rowNumber}][base_uom_header]" value="${baseUomHeader}" readonly />`, // Base UOM Header
            `<input type="text" class="form-control form-control-sm" name="bom_data[${tableIndex}][detail][${rowNumber}][item_number]" value="${itemNumber}" readonly />`, // Item Number
            `<input type="text" class="form-control form-control-sm" name="bom_data[${tableIndex}][detail][${rowNumber}][type]" value="${typeof data.type !== 'undefined' && data.type !== '' ? data.type : 'L'}" readonly />`, // Type
            `<div class="input-group input-group-sm">
                <input type="text" class="form-control comp-material-search" name="bom_data[${tableIndex}][detail][${rowNumber}][comp_material_code]" value="${data.comp_material_code || ''}" placeholder="Pilih Component..." readonly />
                <span class="input-group-text bg-primary text-light" style="cursor: pointer;" onclick="openComponentModal(${tableIndex}, ${rowNumber})">
                    <i class="fas fa-search"></i>
                </span>
            </div>`, // Comp Material Code
            `<input type="text" class="form-control form-control-sm comp-desc" name="bom_data[${tableIndex}][detail][${rowNumber}][comp_desc]" value="${data.comp_desc || ''}" readonly />`, // Comp Desc
            `<input type="number" class="form-control form-control-sm" name="bom_data[${tableIndex}][detail][${rowNumber}][comp_qty]" value="${data.comp_qty || ''}" />`, // Comp QTY
            `<input type="text" class="form-control form-control-sm uom" name="bom_data[${tableIndex}][detail][${rowNumber}][uom]" value="${data.uom || ''}" readonly />`, // UOM
            `<button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="fas fa-trash"></i></button>` // Action
        ];

        let table = $(`#datatable-bom-${tableIndex}`).DataTable();
        table.row.add(rowData).draw();
    }

    // Add new row button - UBAH FUNCTION INI
    $(document).on('click', '.btn-add-row', function() {
        let index = $(this).data('index');
        let table = $(`#datatable-bom-${index}`).DataTable();
        let newRowNumber = table.rows().count() + 1;
        
        // Get data from last row if exists
        let lastRowData = {};
        if (table.rows().count() > 0) {
            let lastRowNode = table.row(':last').node();
            if (lastRowNode) {
                $(lastRowNode).find('input').each(function() {
                    let name = $(this).attr('name');
                    let value = $(this).val();
                    if (name) {
                        let key = name.split('[').pop().split(']')[0];
                        lastRowData[key] = value;
                    }
                });
            }
        }
        
        addTableRow(index, newRowNumber, lastRowData);
    });

    // Delete row - UBAH FUNCTION INI
    $(document).on('click', '.btn-delete-row', function() {
        let row = $(this).closest('tr');
        let table = row.closest('table').DataTable();
        
        // Remove row
        table.row(row).remove().draw();
        
        // Renumber rows
        table.rows().every(function(rowIdx) {
            let rowNode = this.node();
            let newRowNumber = rowIdx + 1;
            
            // Update row number di kolom pertama
            $(rowNode).find('td:first').text(newRowNumber);
            
            // Update semua input name dengan row number baru
            $(rowNode).find('input').each(function() {
                let oldName = $(this).attr('name');
                if (oldName) {
                    let newName = oldName.replace(/\[detail\]\[\d+\]/, `[detail][${newRowNumber}]`);
                    $(this).attr('name', newName);
                }
            });
            
            // Update onclick handler untuk component modal
            $(rowNode).find('.input-group-text[onclick]').each(function() {
                let oldOnclick = $(this).attr('onclick');
                if (oldOnclick) {
                    let tableIndex = oldOnclick.match(/openComponentModal\((\d+),/)[1];
                    $(this).attr('onclick', `openComponentModal(${tableIndex}, ${newRowNumber})`);
                }
            });
        });
    });

    // Load material components - UBAH FUNCTION INI
    function loadMaterialComponents(material, index) {
        $.ajax({
            url: "{{ url($url_menu . '/add') }}",
            type: 'GET',
            data: { 
                action: 'get_material_components',
                material: material 
            },
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(data) {
                let table = $(`#datatable-bom-${index}`).DataTable();
                table.clear();
                
                // Create initial rows based on material components
                if(data.components && data.components.length > 0) {
                    data.components.forEach(function(comp, idx) {
                        addTableRow(index, idx + 1, {
                            material_fg_sfg: material,
                            product_qty: data.product_qty || '',
                            base_uom_header: data.base_uom_header || '',
                            comp_material_code: comp.comp_material_code || '',
                            comp_desc: comp.comp_desc || '',
                            comp_qty: comp.comp_qty || '',
                            uom: comp.uom || '',
                            type: comp.type || 'L'
                        });
                    });
                } else {
                    // Create one empty row if no components found
                    addTableRow(index, 1, {
                        material_fg_sfg: material,
                        product_qty: data.product_qty || '',
                        base_uom_header: data.base_uom_header || '',
                        type: 'L'
                    });
                }
                
                table.draw();
            },
            error: function() {
                Swal.fire('Error', 'Gagal mengambil data komponen material', 'error');
            }
        });
    }

    // Alternative BOM Text apply - UBAH FUNCTION INI
    $(document).on('click', '.alt-bom-apply-btn', function() {
        let index = $(this).data('index');
        let customText = $(`#alt_bom_text-${index}`).val();
        let machineCode = $(`#machine-code-${index}`).text();
        
        if(!customText) {
            Swal.fire('Warning', 'Input teks custom terlebih dahulu!', 'warning');
            return;
        }
        
        let altBomText = machineCode + customText;
        
        // Apply to all rows in the DataTable
        let table = $(`#datatable-bom-${index}`).DataTable();
        table.rows().every(function() {
            let rowNode = this.node();
            $(rowNode).find('.alt-bom-row').val(altBomText);
        });
    });

    // ========== VALIDATION AND SUBMIT ==========
    function validateAndSubmit() {
        let isValid = true;
        let errorMessages = [];

        // Validate each BOM form
        @for ($i = 1; $i <= $rows; $i++)
        let resource{{ $i }} = $('#resources-{{ $i }}').val();
        let material{{ $i }} = $('#material-{{ $i }}').val();
        let altBomText{{ $i }} = $('#alt_bom_text-{{ $i }}').val();

        if (!resource{{ $i }}) {
            errorMessages.push('Form #{{ $i }}: Resource belum dipilih');
            isValid = false;
        }

        if (!material{{ $i }}) {
            errorMessages.push('Form #{{ $i }}: Material FG/SFG belum dipilih');
            isValid = false;
        }

        if (!altBomText{{ $i }}) {
            errorMessages.push('Form #{{ $i }}: Alternative BOM Text belum diisi');
            isValid = false;
        }

        // Validate table rows
        let table{{ $i }} = $('#datatable-bom-{{ $i }}').DataTable();
        let hasRows{{ $i }} = table{{ $i }}.rows().count() > 0;
        
        if (!hasRows{{ $i }}) {
            errorMessages.push('Form #{{ $i }}: Belum ada data detail transaksi');
            isValid = false;
        } else {
            // Validate each row has required data
            table{{ $i }}.rows().every(function() {
                let row = this.node();
                let compCode = $(row).find('input[name*="[comp_material_code]"]').val();
                let compQty = $(row).find('input[name*="[comp_qty]"]').val();
                
                if (!compCode) {
                    errorMessages.push('Form #{{ $i }}: Ada baris yang belum memiliki Comp Material Code');
                    isValid = false;
                }
                
                if (!compQty || compQty <= 0) {
                    errorMessages.push('Form #{{ $i }}: Ada baris yang belum memiliki Comp QTY yang valid');
                    isValid = false;
                }
            });
        }
        @endfor

        if (!isValid) {
            Swal.fire({
                title: 'Validasi Error',
                html: errorMessages.join('<br>'),
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            // SERIALIZE DATATABLES TO FORM
            // Hapus input hidden lama
            $('.datatable-hidden-inputs').remove();

            @for ($i = 1; $i <= $rows; $i++)
            let table{{ $i }} = $('#datatable-bom-{{ $i }}').DataTable();
            table{{ $i }}.rows().every(function(rowIdx) {
                let row = this.node();
                let inputs = $(row).find('input,select,textarea');
                inputs.each(function() {
                    let $input = $(this);
                    let name = $input.attr('name');
                    let value = $input.val();
                    if (name) {
                        // Buat input hidden dan append ke form
                        let hidden = $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', name)
                            .attr('class', 'datatable-hidden-inputs')
                            .val(value);
                        $('#{{ $dmenu }}-form').append(hidden);
                    }
                });
            });
            @endfor

            document.getElementById('{{ $dmenu }}-form').submit();
        }
    }

    // Event untuk tombol konfirmasi modal - TAMBAHKAN INI
    $('#confirmAddRows').on('click', function() {
        var jumlahBaris = $('#jumlahBaris').val();
        if (jumlahBaris && jumlahBaris > 0) {
            // Redirect ke halaman add dengan parameter rows
            window.location = "{{ URL::to($url_menu . '/add') }}?rows=" + jumlahBaris;
        } else {
            Swal.fire('Warning', 'Masukkan jumlah baris yang valid!', 'warning');
        }
    });

    // Event untuk tombol tambah halaman di bawah
    $('#btnTambahHalaman').on('click', function() {
        var currentRows = parseInt('{{ $rows }}');
        var nextRows = currentRows + 1;
        window.location = "{{ URL::to($url_menu . '/add') }}?rows=" + nextRows;
    });

    // Event untuk tombol hapus halaman (silang)
    $(document).on('click', '.btn-hapus-halaman', function() {
        var currentRows = parseInt('{{ $rows }}');
        if (currentRows > 1) {
            var nextRows = currentRows - 1;
            window.location = "{{ URL::to($url_menu . '/add') }}?rows=" + nextRows;
        }
    });

    // Expose functions to global scope
    window.openResourceModal = openResourceModal;
    window.selectResource = selectResource;
    window.openComponentModal = openComponentModal;
    window.selectComponent = selectComponent;
    window.validateAndSubmit = validateAndSubmit;

    // Initialize Value Recommendation Components - TAMBAHKAN DI SINI
    
    // Material FG/SFG Recommendations
    new ValueRecommendation({
        inputSelector: '.material-search-recommendation',
        apiUrl: "{{ url($url_menu . '/add') }}", // Menggunakan endpoint controller yang sudah ada
        type: 'material',
        onSelect: function(value, input) {
            console.log('Material selected:', value);
            // Trigger existing material selection logic if needed
            $(input).trigger('material-selected', [value]);
        }
    });
    
    // Alternative BOM Text Recommendations
    new ValueRecommendation({
        inputSelector: '.alt-bom-input-recommendation',
        apiUrl: "{{ url($url_menu . '/add') }}", // Menggunakan endpoint controller yang sudah ada
        type: 'altbom',
        onSelect: function(value, input) {
            console.log('Alt BOM Text selected:', value);
            // Auto-apply the selected text with machine code
            const index = $(input).attr('id').split('-')[3];
            const machineCode = $(`#machine-code-${index}`).text();
            const fullText = machineCode + value;
            
            // Update the input value
            $(input).val(value);
            
            // You can trigger auto-apply if needed
            // $(`#alt_bom_text-${index}`).val(value);
        }
    });
});
</script>
@endpush