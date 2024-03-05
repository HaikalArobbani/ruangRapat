@extends('layouts.app')
@section('content')
    <?php
    use Carbon\Carbon;
    Carbon::setlocale('id');
    ?>
    <br>
    <div class="container-fluid">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h5 class="text-uppercase mb-3"><i class="ri-briefcase-line me-1"></i>
                        Riwayat Peminjaman Ruang</h5>

                    <div class="col-lg-4 mt-3 mt-lg-0">
                        <div class="mb-3">
                            <div class="input-group">
                                <form action="{{ route('riwayat') }}" method="GET">
                                    <div class="input-group">
                                        <input type="month" class="form-control" id="filterBulan" name="bulan">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100"
                        style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Ruang</th>
                                <th>Kegiatan</th>
                                <th>Divisi</th>
                                <th>Tanggal Pinjam</th>
                                <th>Peserta</th>
                                <th>Status</th>
                                <td>Absen</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($riwayat as $r)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $r->ruangrapat->nama }}</td>
                                    <td>{{ $r->nama_rapat }}</td>
                                    <td>{{ $r->divisiPermohonan->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->tanggal_pinjam)->isoFormat('D MMMM YYYY HH:mm') }}
                                        s.d {{ \Carbon\Carbon::parse($r->tanggal_selesai)->isoFormat('HH:mm') }}
                                    </td>
                                    <td> <a href="#" data-id="{{ $r->id }}"
                                            class="btn btn-sm btn-warning detailPeserta">
                                            {{ $r->peserta_rapat_count }} </a>
                                    </td>

                                    <td>
                                        @if ($r->status == 1)
                                            Menunggu
                                        @else
                                            {{ $r->status }}
                                        @endif
                                    </td>
                                    <td>
                                        <a data-id="{{ $r->id }}" class="btn btn-warning absenRuangan"
                                            href="/daftar_peserta_rapat{{ $r->id }}">Absen</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalDetailPeserta" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollableModalTitle">Detail Peserta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive tampildata3" data-pattern="priority-columns">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script>
        $(document).ready(function() {
            $('body').on('click', '.detailPeserta', function(e) {
                e.preventDefault();
                var idDetail = $(this).attr('data-id');
                console.log(idDetail);
                $.ajax({
                    url: "{{ route('getDetailPeserta') }}?idDetail=" + idDetail,
                    type: "GET",
                    dataType: "JSON",
                    success: function(response) {
                        var table =
                            '<table id="example2" class="table table-bordered display" style="width:100%">' +
                            '<thead>' +
                            '<tr>' +
                            '<th width="1%">No.</th>' +
                            '<th width="20%">Nama Pegawai</th>' +
                            '<th>Divisi</th>' +
                            '<th>Tanda Tangan</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';

                        for (var i = 0; i < response.peserta.length; i++) {

                            table += '<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + response.peserta[i].pegawai_absen.nama + '</td>' +
                                '<td>' + response.peserta[i].pegawai_absen.divisipegawai.nama +
                                '</td>' +
                                '<td>' +
                                '<img src="/images/ttd/' + response.peserta[i].ttd_absen +
                                '" class="me-2 rounded-circle" width="100" alt="">' +
                                '</td>' +


                                '</tr>';

                        }
                        table += '</tbody></table>';
                        $('.tampildata3').html(table);
                        $('#example2').DataTable({
                            "paging": true
                        });
                        $('#modalDetailPeserta').modal('show');
                    }
                });
            });
        });
    </script>
@endsection
