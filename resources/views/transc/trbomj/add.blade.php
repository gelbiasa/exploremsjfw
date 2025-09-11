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
                            <button class="btn btn-primary mb-0"
                                onclick="validateAndSubmit()"><i
                                    class="fas fa-floppy-disk me-1"> </i><span class="font-weight-bold">Simpan</button>
                        @endif
                    </div>
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
                            <h5 class="mb-3">Form Transaksi BOM #{{ $i }}</h5>
                            <div class="row">
                                {{-- Resource Search --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Resources <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="hidden" name="bom_data[{{ $i }}][resources]" id="resources-{{ $i }}" required>
                                        <input type="text" class="form-control" id="resource_display_{{ $i }}" placeholder="Pilih Resource..." readonly>
                                        <span class="input-group-text bg-primary text-light" onclick="openResourceModal({{ $i }})" style="cursor: pointer;">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>

                                {{-- Material FG/SFG Search --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Material FG/SFG <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control material-search" name="bom_data[{{ $i }}][material]" id="material-{{ $i }}" autocomplete="off" placeholder="Cari Material...">
                                        <span class="input-group-text bg-primary text-light material-apply-btn" style="cursor: pointer;" data-index="{{ $i }}">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>
                                    {{-- Material dropdown --}}
                                    <div class="dropdown-menu material-dropdown" id="material-dropdown-{{ $i }}" style="width: 100%; max-height: 200px; overflow-y: auto;"></div>
                                </div>

                                {{-- Auto-filled fields from Resource --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Mat Type</label>
                                    <input type="text" class="form-control mat-type" name="bom_data[{{ $i }}][mat_type]" id="mat_type-{{ $i }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-control-label">Width</label>
                                    <input type="text" class="form-control width" name="bom_data[{{ $i }}][width]" id="width-{{ $i }}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-control-label">Length</label>
                                    <input type="text" class="form-control length" name="bom_data[{{ $i }}][length]" id="length-{{ $i }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Capacity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control capacity" name="bom_data[{{ $i }}][capacity]" id="capacity-{{ $i }}">
                                </div>

                                {{-- Alternative BOM Text Custom --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Alternative BOM Text Custom <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text machine-code" id="machine-code-{{ $i }}"></span>
                                        <input type="text" class="form-control alt-bom-input" name="bom_data[{{ $i }}][alt_bom_text]" id="alt_bom_text-{{ $i }}" placeholder="Input Custom...">
                                        <span class="input-group-text bg-primary text-light alt-bom-apply-btn" style="cursor: pointer;" data-index="{{ $i }}">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            
                            {{-- Detail Transaction Table --}}
                            <div class="table-responsive">
                                <table id="datatable-bom-{{ $i }}" class="table table-bordered table-striped bom-table" data-index="{{ $i }}">
                                    <thead class="bg-light">
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
            <div class="row">
                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk me-1"></i> Simpan</button>
                </div>
            </div>
        </form>
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

    // Inisialisasi DataTable untuk setiap card
    $('.bom-table').each(function() {
        $(this).DataTable({
            paging: false,
            searching: false,
            info: false,
            ordering: false,
            columnDefs: [
                { targets: [0], width: "5%" },
                { targets: [11], width: "8%" }
            ]
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
        
        if(keyword.length >= 2) {
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
                            type: comp.type || ''
                        });
                    });
                } else {
                    // Create one empty row if no components found
                    addTableRow(index, 1, {
                        material_fg_sfg: material,
                        product_qty: data.product_qty || '',
                        base_uom_header: data.base_uom_header || ''
                    });
                }
                
                table.draw();
            },
            error: function() {
                Swal.fire('Error', 'Gagal mengambil data komponen material', 'error');
            }
        });
    }

    // ========== ALTERNATIVE BOM TEXT ==========
    $(document).on('click', '.alt-bom-apply-btn', function() {
        let index = $(this).data('index');
        let customText = $(`#alt_bom_text-${index}`).val();
        let machineCode = $(`#machine-code-${index}`).text();
        
        if(!customText) {
            Swal.fire('Warning', 'Input teks custom terlebih dahulu!', 'warning');
            return;
        }
        
        let altBomText = machineCode + customText;
        
        // Apply to all rows in the table
        $(`#datatable-bom-${index} tbody tr`).each(function() {
            $(this).find('.alt-bom-row').val(altBomText);
        });
    });

    // ========== TABLE ROW MANAGEMENT ==========
    function addTableRow(tableIndex, rowNumber, data = {}) {
        let itemNumber = (rowNumber * 10).toString().padStart(4, '0');
        let productQty = data.product_qty || '';
        let baseUomHeader = data.base_uom_header || '';

        let rowHtml = `<tr>
            <td>${rowNumber}</td>
            <td><input type="text" class="form-control fg-input" name="bom_data[${tableIndex}][detail][${rowNumber}][material_fg_sfg]" value="${data.material_fg_sfg || ''}" readonly /></td>
            <td><input type="text" class="form-control alt-bom-row" name="bom_data[${tableIndex}][detail][${rowNumber}][alt_bom_text]" value="${data.alt_bom_text || ''}" readonly /></td>
            <td><input type="number" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][product_qty]" value="${productQty}" readonly /></td>
            <td><input type="text" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][base_uom_header]" value="${baseUomHeader}" readonly /></td>
            <td><input type="text" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][item_number]" value="${itemNumber}" readonly /></td>
            <td><input type="text" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][type]" value="${typeof data.type !== 'undefined' && data.type !== '' ? data.type : 'L'}" readonly /></td>
            <td><div class="input-group">
                <input type="text" class="form-control comp-material-search" name="bom_data[${tableIndex}][detail][${rowNumber}][comp_material_code]" value="${data.comp_material_code || ''}" placeholder="Pilih Component..." readonly />
                <span class="input-group-text bg-primary text-light" style="cursor: pointer;" onclick="openComponentModal(${tableIndex}, ${rowNumber})">
                    <i class="fas fa-search"></i>
                </span>
            </div></td>
            <td><input type="text" class="form-control comp-desc" name="bom_data[${tableIndex}][detail][${rowNumber}][comp_desc]" value="${data.comp_desc || ''}" readonly /></td>
            <td><input type="number" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][comp_qty]" value="${data.comp_qty || ''}" /></td>
            <td><input type="text" class="form-control uom" name="bom_data[${tableIndex}][detail][${rowNumber}][uom]" value="${data.uom || ''}" readonly /></td>
            <td><button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="fas fa-trash"></i></button></td>
        </tr>`;

        let table = $(`#datatable-bom-${tableIndex}`).DataTable();
        table.row.add($(rowHtml));
    }

    // Add new row button
    $(document).on('click', '.btn-add-row', function() {
        let index = $(this).data('index');
        let table = $(`#datatable-bom-${index}`).DataTable();
        let lastRow = table.row(':last').node();
        let newRowNumber = table.rows().count() + 1;
        
        if(lastRow) {
            // Copy ALL input values from last row
            let lastRowData = {};
            $(lastRow).find('input').each(function() {
                let name = $(this).attr('name');
                let value = $(this).val();
                // Ambil key field terakhir dari name
                let key = name.split('[').pop().split(']')[0];
                lastRowData[key] = value;
            });
            addTableRow(index, newRowNumber, lastRowData);
            table.draw();
        } else {
            addTableRow(index, 1);
            table.draw();
        }
    });

    // Delete row
    $(document).on('click', '.btn-delete-row', function() {
        let row = $(this).closest('tr');
        let table = row.closest('table').DataTable();
        table.row(row).remove().draw();
        
        // Renumber rows
        table.rows().every(function(rowIdx) {
            let row = this.node();
            $(row).find('td:first').text(rowIdx + 1);
        });
    });

    // Create new material functionality
    $(document).on('click', '#create-new-material', function() {
        Swal.fire({
            title: 'Buat Material Baru',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Kode Material:</label>
                        <input type="text" id="new-material-code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi:</label>
                        <input type="text" id="new-material-desc" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">UOM:</label>
                        <input type="text" id="new-material-uom" class="form-control">
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            preConfirm: () => {
                let code = $('#new-material-code').val();
                let desc = $('#new-material-desc').val();
                let uom = $('#new-material-uom').val();
                
                if(!code) {
                    Swal.showValidationMessage('Kode material harus diisi!');
                    return false;
                }
                
                return { code, desc, uom };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Create new material via AJAX
                $.ajax({
                    url: "{{ url($url_menu . '/add') }}",
                    type: 'POST',
                    data: {
                        action: 'create_material',
                        material_code: result.value.code,
                        description: result.value.desc,
                        uom: result.value.uom,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        // Fill the specific row with new material data
                        let targetRow = $(`input[name="bom_data[${currentTargetIndex}][detail][${currentRowIndex}][comp_material_code]"]`).closest('tr');
                        targetRow.find('input[name*="[comp_material_code]"]').val(result.value.code);
                        targetRow.find('input[name*="[comp_desc]"]').val(result.value.desc);
                        targetRow.find('input[name*="[type]"]').val('L');
                        targetRow.find('input[name*="[uom]"]').val(result.value.uom);
                        
                        $('#componentModal').modal('hide');
                        Swal.fire('Berhasil', 'Material baru telah dibuat dan dipilih!', 'success');
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal membuat material baru!', 'error');
                    }
                });
            }
        });
    });

    // Hide dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.material-search, .material-dropdown').length) {
            $('.material-dropdown').hide();
        }
    });

    // Function validate and submit - sama seperti trordr
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
            document.getElementById('{{ $dmenu }}-form').submit();
        }
    }

    // Expose functions to global scope
    window.openResourceModal = openResourceModal;
    window.selectResource = selectResource;
    window.openComponentModal = openComponentModal;
    window.selectComponent = selectComponent;
    window.validateAndSubmit = validateAndSubmit;
});
</script>
@endpush