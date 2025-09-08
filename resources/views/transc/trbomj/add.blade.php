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
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Resources <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="bom_data[{{ $i }}][resources]" value="{{ old('resources','1F5151') }}" readonly>
                                        <span class="input-group-text bg-primary text-light" style="cursor: pointer;">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Material FG/SFG <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="bom_data[{{ $i }}][material]" value="{{ old('material','TE0RL0-H00W10-00024') }}">
                                        <span class="input-group-text bg-success text-light" style="cursor: pointer;">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Mat Type</label>
                                    <input type="text" class="form-control" name="bom_data[{{ $i }}][mat_type]" value="ZSFG" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-control-label">Width</label>
                                    <input type="text" class="form-control" name="bom_data[{{ $i }}][width]" value="2.600">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-control-label">Length</label>
                                    <input type="text" class="form-control" name="bom_data[{{ $i }}][length]" value="2000">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Capacity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="bom_data[{{ $i }}][capacity]" value="220">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-control-label">Alternative BOM Text Custom <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="bom_data[{{ $i }}][alt_bom_text]" value="51-TANGGUH">
                                        <span class="input-group-text bg-success text-light" style="cursor: pointer;">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
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
        // Inisialisasi DataTable untuk setiap card
        $('.bom-table').each(function() {
            $(this).DataTable({
                paging: false,
                searching: false,
                info: false,
                ordering: false
            });
        });

        // Event tambah baris data
        $('.btn-add-row').on('click', function() {
            var idx = $(this).data('index');
            var table = $('#datatable-bom-' + idx).DataTable();
            var rowCount = table.rows().count() + 1;
            var rowHtml = `<tr>
                <td>${rowCount}</td>
                <td><input type="text" class="form-control" name="bom_data[${idx}][detail][${rowCount}][material_fg_sfg]" /></td>
                <td><input type="text" class="form-control" name="bom_data[${idx}][detail][${rowCount}][alt_bom_text]" /></td>
                <td><input type="number" class="form-control" name="bom_data[${idx}][detail][${rowCount}][product_qty]" /></td>
                <td><input type="text" class="form-control" name="bom_data[${idx}][detail][${rowCount}][base_uom_header]" /></td>
                <td><input type="text" class="form-control" name="bom_data[${idx}][detail][${rowCount}][item_number]" /></td>
                <td><input type="text" class="form-control" name="bom_data[${idx}][detail][${rowCount}][type]" /></td>
                <td><input type="text" class="form-control" name="bom_data[${idx}][detail][${rowCount}][comp_material_code]" /></td>
                <td><input type="text" class="form-control" name="bom_data[${idx}][detail][${rowCount}][comp_desc]" /></td>
                <td><input type="number" class="form-control" name="bom_data[${idx}][detail][${rowCount}][comp_qty]" /></td>
                <td><input type="text" class="form-control" name="bom_data[${idx}][detail][${rowCount}][uom]" /></td>
                <td><button type="button" class="btn btn-sm btn-danger btn-delete-row"><i class="fas fa-trash"></i></button></td>
            </tr>`;
            table.row.add($(rowHtml)).draw();
        });

        // Event hapus baris data
        $(document).on('click', '.btn-delete-row', function() {
            var table = $(this).closest('table').DataTable();
            table.row($(this).parents('tr')).remove().draw();
        });
    });
    </script>
@endpush
