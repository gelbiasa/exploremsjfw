@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'PPIC'])

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- Ubah margin-bottom pada judul --}}
                <div class="text-center" style="margin-bottom: -35px;">
                    <h4 class="fw-bold">PPIC Dashboard</h4>
                    <p class="text-muted">BOM Upload Transaction Summary</p>
                </div>
            </div>
        </div>

        {{-- Card Ringkasan Transaksi --}}
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm text-uppercase fw-bold mb-0">Total Seluruh Transaksi Upload BOM</p>
                            <h3 class="fw-bold">120</h3>
                        </div>
                        <div class="text-success fs-3">
                            <i class="ni ni-cloud-upload-96"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm text-uppercase fw-bold mb-0">Transaksi Upload BOM Jumbo</p>
                            <h4 class="fw-bold">45</h4>
                        </div>
                        <div class="fs-3 text-primary">
                            <i class="ni ni-archive-2"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm text-uppercase fw-bold mb-0">Transaksi Upload BOM Slitter & NDC</p>
                            <h4 class="fw-bold">50</h4>
                        </div>
                        <div class="fs-3 text-warning">
                            <i class="ni ni-collection"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-sm text-uppercase fw-bold mb-0">Transaksi Upload BOM Meltblown</p>
                            <h4 class="fw-bold">25</h4>
                        </div>
                        <div class="fs-3 text-danger">
                            <i class="ni ni-single-copy-04"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat Transaksi --}}
        <div class="row mt-4">
            <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header pb-0">
                            <h6 class="fw-bold mb-0">Riwayat Transaksi</h6>
                        </div>
                        <div class="row px-4 py-2">
                            <div class="table-responsive">
                                <table class="table display" id="riwayat_transaksi">
                                    <thead class="thead-light" style="background-color: #00b7bd4f;">
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis</th>
                                            <th>Resource</th>
                                            <th>Material</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>BOM Jumbo</td>
                                            <td>Resource A</td>
                                            <td>Material X</td>
                                            <td>2025-09-01</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>BOM Slitter</td>
                                            <td>Resource B</td>
                                            <td>Material Y</td>
                                            <td>2025-09-02</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>BOM Meltblown</td>
                                            <td>Resource C</td>
                                            <td>Material Z</td>
                                            <td>2025-09-03</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>BOM Slitter</td>
                                            <td>Resource D</td>
                                            <td>Material W</td>
                                            <td>2025-09-04</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>BOM Jumbo</td>
                                            <td>Resource E</td>
                                            <td>Material Q</td>
                                            <td>2025-09-05</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    @push('js')
    <script>
        $(document).ready(function() {
            $('#riwayat_transaksi').DataTable({
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
                            "next": "Next",
                            "previous": "Previous"
                        }
                    },
                    "pageLength": 5,
                    "lengthMenu": [5, 10, 25, 50],
                    responsive: true,
                    dom: 'lfrtip', // hilangkan tombol export/copy/print
                    "order": [[ 0, "asc" ]],
                    "paging": true,
                    "searching": true,
                    "info": true,
                    "lengthChange": true,
                    "columnDefs": [
                        {
                            "targets": 0,
                            "render": function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        }
                    ]
                });
                // Tidak perlu styling button DataTables karena tombol export/copy/print sudah dihilangkan
        });
    </script>
    @endpush
    </div>

@endsection
