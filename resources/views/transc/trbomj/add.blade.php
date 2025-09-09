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
                                onclick="event.preventDefault(); document.getElementById('{{ $dmenu }}-form').submit();"><i
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
                                        <input type="text" class="form-control resource-input" name="bom_data[{{ $i }}][resources]" id="resource-{{ $i }}" readonly placeholder="Pilih Resource...">
                                        <span class="input-group-text bg-primary text-light resource-search-btn" style="cursor: pointer;" data-index="{{ $i }}">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>

                                {{-- Material FG/SFG Search --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Material FG/SFG <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control material-search" name="bom_data[{{ $i }}][material]" id="material-{{ $i }}" autocomplete="off" placeholder="Cari Material...">
                                        <span class="input-group-text bg-success text-light material-apply-btn" style="cursor: pointer;" data-index="{{ $i }}">
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
                                        <span class="input-group-text bg-success text-light alt-bom-apply-btn" style="cursor: pointer;" data-index="{{ $i }}">
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

    {{-- Modal Resource Selection --}}
    <div class="modal fade" id="resourceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Resource</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" id="resource_keyword" class="form-control" placeholder="Ketik nama resource untuk pencarian...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Resource</th>
                                    <th>Mat Type</th>
                                    <th>Width</th>
                                    <th>Length</th>
                                    <th>Capacity</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="resource_table">
                                <tr><td colspan="6" class="text-center">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Component Material Selection --}}
    <div class="modal fade" id="componentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih Component Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" id="component_keyword" class="form-control" placeholder="Ketik kode material untuk pencarian...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th>Material Code</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>UOM</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="component_table">
                                <tr><td colspan="5" class="text-center">Loading...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-success" id="create-new-material">
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
    let allResources = [];
    let allMaterials = [];
    let allComponents = [];

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

    // ========== RESOURCE SELECTION ==========
    // Open Resource Modal
    $(document).on('click', '.resource-search-btn', function() {
        currentTargetIndex = $(this).data('index');
        $('#resourceModal').modal('show');
        loadResourceData();
        $('#resource_keyword').val('');
    });

    // Load Resource Data from trs_bom_h
    function loadResourceData() {
        $.ajax({
            url: '/api/resource-list', // Adjust endpoint as needed
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                allResources = data;
                renderResourceTable(data);
            },
            error: function() {
                $('#resource_table').html('<tr><td colspan="6" class="text-center text-danger">Gagal mengambil data resource</td></tr>');
            }
        });
    }

    // Resource search in modal
    $(document).on('input', '#resource_keyword', function() {
        let keyword = $(this).val().toLowerCase();
        let filtered = allResources.filter(function(res) {
            return (res.resource || '').toLowerCase().includes(keyword) ||
                   (res.mat_type || '').toLowerCase().includes(keyword);
        });
        renderResourceTable(filtered);
    });

    // Render Resource Table
    function renderResourceTable(data) {
        let tbody = '';
        if(data.length === 0) {
            tbody = '<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>';
        } else {
            data.forEach(function(res) {
                tbody += `<tr>
                    <td>${res.resource || ''}</td>
                    <td>${res.mat_type || ''}</td>
                    <td>${res.width || ''}</td>
                    <td>${res.length || ''}</td>
                    <td>${res.capacity || ''}</td>
                    <td><button type="button" class="btn btn-success btn-sm btn-select-resource" 
                        data-resource="${res.resource || ''}" 
                        data-mat_type="${res.mat_type || ''}" 
                        data-width="${res.width || ''}" 
                        data-length="${res.length || ''}" 
                        data-capacity="${res.capacity || ''}">Pilih</button></td>
                </tr>`;
            });
        }
        $('#resource_table').html(tbody);
    }

    // Select Resource and auto-fill related fields
    $(document).on('click', '.btn-select-resource', function() {
        let resource = $(this).data('resource');
        let mat_type = $(this).data('mat_type');
        let width = $(this).data('width');
        let length = $(this).data('length');
        let capacity = $(this).data('capacity');
        
        // Fill resource form fields
        $(`#resource-${currentTargetIndex}`).val(resource);
        $(`#mat_type-${currentTargetIndex}`).val(mat_type);
        $(`#width-${currentTargetIndex}`).val(width);
        $(`#length-${currentTargetIndex}`).val(length);
        $(`#capacity-${currentTargetIndex}`).val(capacity);
        
        // Generate machine code (last 2 digits of resource code)
        let machineCode = '';
        if(resource) {
            let resourceCode = resource.toString();
            machineCode = resourceCode.slice(-2) + '-';
        }
        $(`#machine-code-${currentTargetIndex}`).text(machineCode);
        
        $('#resourceModal').modal('hide');
    });

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
            url: '/api/material-search', // Adjust endpoint
            type: 'GET',
            data: { q: keyword },
            dataType: 'json',
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
                    data-material="${material.material_code}"
                    data-desc="${material.description}"
                    data-base_uom="${material.base_uom}">${material.material_code} - ${material.description}</a>`;
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
            url: '/api/material-components', // Adjust endpoint
            type: 'GET',
            data: { material: material },
            dataType: 'json',
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
        let productQty = data.product_qty || window.currentProductQty || '';
        let baseUomHeader = data.base_uom_header || window.currentBaseUomHeader || '';

        let rowHtml = `<tr>
            <td>${rowNumber}</td>
            <td><input type="text" class="form-control fg-input" name="bom_data[${tableIndex}][detail][${rowNumber}][material_fg_sfg]" value="${data.material_fg_sfg || ''}" readonly /></td>
            <td><input type="text" class="form-control alt-bom-row" name="bom_data[${tableIndex}][detail][${rowNumber}][alt_bom_text]" value="${data.alt_bom_text || ''}" readonly /></td>
            <td><input type="number" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][product_qty]" value="${productQty}" readonly /></td>
            <td><input type="text" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][base_uom_header]" value="${baseUomHeader}" readonly /></td>
            <td><input type="text" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][item_number]" value="${itemNumber}" readonly /></td>
            <td><input type="text" class="form-control" name="bom_data[${tableIndex}][detail][${rowNumber}][type]" value="${data.type || ''}" readonly /></td>
            <td><div class="input-group">
                <input type="text" class="form-control comp-material-search" name="bom_data[${tableIndex}][detail][${rowNumber}][comp_material_code]" value="${data.comp_material_code || ''}" autocomplete="off" />
                <span class="input-group-text bg-info text-light comp-search-btn" style="cursor: pointer;" data-table-index="${tableIndex}" data-row-index="${rowNumber}">
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
            // Update data-row-index pada semua tombol search di kolom Comp Material Code
            $(`#datatable-bom-${index} tbody tr`).each(function(rowIdx, tr) {
                $(tr).find('.comp-search-btn').attr('data-row-index', rowIdx + 1);
            });
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

    // ========== COMPONENT MATERIAL SELECTION ==========
    $(document).on('click', '.comp-search-btn', function() {
        currentTargetIndex = $(this).data('table-index');
        currentRowIndex = $(this).data('row-index');
        $('#componentModal').modal('show');
        loadComponentData();
        $('#component_keyword').val('');
    });

    function loadComponentData() {
        $.ajax({
            url: '/api/component-materials', // Adjust endpoint
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                allComponents = data;
                renderComponentTable(data);
            },
            error: function() {
                $('#component_table').html('<tr><td colspan="5" class="text-center text-danger">Gagal mengambil data komponen</td></tr>');
            }
        });
    }

    // Component search in modal
    $(document).on('input', '#component_keyword', function() {
        let keyword = $(this).val().toLowerCase();
        let filtered = allComponents.filter(function(comp) {
            return (comp.material_code || '').toLowerCase().includes(keyword) ||
                   (comp.description || '').toLowerCase().includes(keyword);
        });
        renderComponentTable(filtered);
    });

    function renderComponentTable(data) {
        let tbody = '';
        if(data.length === 0) {
            tbody = '<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>';
        } else {
            data.forEach(function(comp) {
                tbody += `<tr>
                    <td>${comp.material_code || ''}</td>
                    <td>${comp.description || ''}</td>
                    <td>${comp.type || ''}</td>
                    <td>${comp.uom || ''}</td>
                    <td><button type="button" class="btn btn-success btn-sm btn-select-component" 
                        data-code="${comp.material_code || ''}" 
                        data-desc="${comp.description || ''}" 
                        data-type="${comp.type || ''}" 
                        data-uom="${comp.uom || ''}">Pilih</button></td>
                </tr>`;
            });
        }
        $('#component_table').html(tbody);
    }

    // Select component material
    $(document).on('click', '.btn-select-component', function() {
        let code = $(this).data('code');
        let desc = $(this).data('desc');
        let type = $(this).data('type');
        let uom = $(this).data('uom');
        
        // Fill the specific row
        let targetRow = $(`input[name="bom_data[${currentTargetIndex}][detail][${currentRowIndex}][comp_material_code]"]`).closest('tr');
        targetRow.find('input[name*="[comp_material_code]"]').val(code);
        targetRow.find('input[name*="[comp_desc]"]').val(desc);
        targetRow.find('input[name*="[type]"]').val(type);
        targetRow.find('input[name*="[uom]"]').val(uom);
        
        $('#componentModal').modal('hide');
    });

    // Create new material functionality
    $(document).on('click', '#create-new-material', function() {
        let keyword = $('#component_keyword').val();
        if(!keyword) {
            Swal.fire('Warning', 'Masukkan kode material terlebih dahulu!', 'warning');
            return;
        }
        
        Swal.fire({
            title: 'Buat Material Baru',
            html: `
                <div class="text-start">
                    <div class="mb-3">
                        <label class="form-label">Kode Material:</label>
                        <input type="text" id="new-material-code" class="form-control" value="${keyword}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi:</label>
                        <input type="text" id="new-material-desc" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type:</label>
                        <input type="text" id="new-material-type" class="form-control">
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
                let type = $('#new-material-type').val();
                let uom = $('#new-material-uom').val();
                
                if(!code) {
                    Swal.showValidationMessage('Kode material harus diisi!');
                    return false;
                }
                
                return { code, desc, type, uom };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Create new material via AJAX
                $.ajax({
                    url: '/api/create-material', // Adjust endpoint
                    type: 'POST',
                    data: {
                        material_code: result.value.code,
                        description: result.value.desc,
                        type: result.value.type,
                        uom: result.value.uom,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Fill the specific row with new material data
                        let targetRow = $(`input[name="bom_data[${currentTargetIndex}][detail][${currentRowIndex}][comp_material_code]"]`).closest('tr');
                        targetRow.find('input[name*="[comp_material_code]"]').val(result.value.code);
                        targetRow.find('input[name*="[comp_desc]"]').val(result.value.desc);
                        targetRow.find('input[name*="[type]"]').val(result.value.type);
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

    // Manual input for component material code
    $(document).on('input', '.comp-material-search', function() {
        let $this = $(this);
        let code = $this.val();
        let row = $this.closest('tr');
        
        if(code.length >= 3) {
            // Search existing material
            $.ajax({
                url: '/api/search-material-by-code',
                type: 'GET',
                data: { code: code },
                success: function(data) {
                    if(data) {
                        row.find('input[name*="[comp_desc]"]').val(data.description || '');
                        row.find('input[name*="[type]"]').val(data.type || '');
                        row.find('input[name*="[uom]"]').val(data.uom || '');
                    } else {
                        // Clear related fields if not found
                        row.find('input[name*="[comp_desc]"]').val('');
                        row.find('input[name*="[type]"]').val('');
                        row.find('input[name*="[uom]"]').val('');
                    }
                }
            });
        }
    });

    // Hide dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.material-search, .material-dropdown').length) {
            $('.material-dropdown').hide();
        }
    });

    // Form validation before submit
    $('form').on('submit', function(e) {
        let isValid = true;
        let errorMessages = [];

        // Validate each BOM form
        $('.card').each(function(index) {
            let cardIndex = index + 1;
            let resource = $(`#resource-${cardIndex}`).val();
            let material = $(`#material-${cardIndex}`).val();
            let altBomText = $(`#alt_bom_text-${cardIndex}`).val();

            if (!resource) {
                errorMessages.push(`Form #${cardIndex}: Resource belum dipilih`);
                isValid = false;
            }

            if (!material) {
                errorMessages.push(`Form #${cardIndex}: Material FG/SFG belum dipilih`);
                isValid = false;
            }

            if (!altBomText) {
                errorMessages.push(`Form #${cardIndex}: Alternative BOM Text belum diisi`);
                isValid = false;
            }

            // Validate table rows
            let table = $(`#datatable-bom-${cardIndex}`).DataTable();
            let hasRows = table.rows().count() > 0;
            
            if (!hasRows) {
                errorMessages.push(`Form #${cardIndex}: Belum ada data detail transaksi`);
                isValid = false;
            } else {
                // Validate each row has required data
                table.rows().every(function() {
                    let row = this.node();
                    let compCode = $(row).find('input[name*="[comp_material_code]"]').val();
                    let compQty = $(row).find('input[name*="[comp_qty]"]').val();
                    
                    if (!compCode) {
                        errorMessages.push(`Form #${cardIndex}: Ada baris yang belum memiliki Comp Material Code`);
                        isValid = false;
                    }
                    
                    if (!compQty || compQty <= 0) {
                        errorMessages.push(`Form #${cardIndex}: Ada baris yang belum memiliki Comp QTY yang valid`);
                        isValid = false;
                    }
                });
            }
        });

        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                title: 'Validasi Error',
                html: errorMessages.join('<br>'),
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    // Auto-resize textareas if any
    $('textarea').each(function() {
        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
});
</script>
@endpush