@extends('layouts.app')
@section('content')
    <?php
    use Carbon\Carbon;
    Carbon::setlocale('id');
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-6">

                <div class="page-title-box">
                    <h4 class="page-title"><i class="ri-calendar-todo-line me-1"></i> Pengajuan Diterima </h4>
                    <div id="notifBerhasilAgenda"></div>
                    <a href="#" class="testing"> TES</a>
                </div>


                <div class="mt-2">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#todayTasks" role="button"
                            aria-expanded="false" aria-controls="todayTasks">
                            <i class='ri-arrow-down-s-line fs-18'></i>Agenda Hari ini <span class="text-muted">(
                                {{ $countRapatToday }} )</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="todayTasks">
                        <div class="card mb-0">

                            <div class="card-body" id="cardToday">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">

                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#upcomingTasks" role="button"
                            aria-expanded="false" aria-controls="upcomingTasks">
                            <i class='ri-arrow-down-s-line fs-18'></i>Agenda Lusa H + 1 <span class="text-muted">(
                                {{ $countUpcoming }} )</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="upcomingTasks">
                        <div class="card mb-0">
                            <div class="card-body" id="cardUpcoming">

                            </div>
                        </div>
                    </div>
                </div>

                <!-- start other tasks -->
                <div class="mt-4 mb-4">
                    <h5 class="m-0 pb-2">
                        <a class="text-dark" data-bs-toggle="collapse" href="#otherTasks" role="button"
                            aria-expanded="false" aria-controls="otherTasks">
                            <i class='ri-arrow-down-s-line fs-18'></i>Agenda Lainnya <span class="text-muted">(
                                {{ $countrapatOther }} )</span>
                        </a>
                    </h5>

                    <div class="collapse show" id="otherTasks">
                        <div class="card mb-0">
                            <div class="card-body" id="cardOther">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- task details -->

            <div class="col-xxl-6">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title"><i class="ri-briefcase-line me-1"></i>
                        Pengajuan </h4>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col">

                                <div class="row">
                                    <div id="notifBerhasil"></div>
                                    <div class="col-12">
                                        <div class="table-responsive tampildata" data-pattern="priority-columns">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalDetailAjuan" tabindex="-1" role="dialog"
                aria-labelledby="scrollableModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="scrollableModalTitle">Detail Ajuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="detailAjuanAtas">
                            </div>
                            <h4 class="fs-13 text-uppercase text-warning">Daftar Nama Peserta</h4>
                            <div class="table-responsive tampildata2" data-pattern="priority-columns">
                            </div>
                        </div>
                        <form method="post" id="formKonfirmasi" onkeydown="return event.key != 'Enter';">

                            @csrf
                            <input type="hidden" name="idAjuanKonfirmasi" id="idAjuanKonfirmasi">
                            <div class="modal-footer">
                                <button id="konfirmasiTerima" class="btn btn-primary btn-sm waves-effect waves-light"
                                    value="Simpan">Terima</button>
                                <button id="konfirmasiTolak"
                                    class="btn btn-danger btn-sm waves-effect waves-light">Tolak</button>
                                <button type="button" class="btn btn-warning btn-sm waves-effect waves-light"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalDetailPeserta" tabindex="-1" role="dialog"
                aria-labelledby="scrollableModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="scrollableModalTitle">Detail Peserta </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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

            <div class="modal fade" id="modalKonfirmasiAjuan" tabindex="-1" role="dialog"
                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-m">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myLargeModalLabel">Konfirmasi Pengajuan</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="formKonfirmasi" onkeydown="return event.key != 'Enter';">

                                @csrf

                                <div class="form-group">

                                    <label>Nama Kegiatan</label>
                                    <p id="namakegiatankonfirmasi"></p>

                                    <label>Divisi</label>
                                    <p id="divisikonfirmasi"></p>

                                    <label>Ruang</label>
                                    <select name="ruangkonfirmasi" id="ruangkonfirmasi" class="form-control">
                                        <option value=""><b>- Pilih Ruangan</b> </option>
                                        @foreach ($ruangRapat as $r)
                                            <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <input type="hidden" name="idAjuanKonfirmasi" id="idAjuanKonfirmasi"> --}}
                                <div class="modal-footer">
                                    <button id="konfirmasiTerima" class="btn btn-primary btn-sm waves-effect waves-light"
                                        value="Simpan">Terima</button>
                                    <button id="konfirmasiTolak"
                                        class="btn btn-danger btn-sm waves-effect waves-light">Tolak</button>
                                    <button type="button" class="btn btn-warning btn-sm waves-effect waves-light"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script>
            $(document).ready(function() {

                $('body').on('click', '#konfirmasiTolak', function(e) {
                    e.preventDefault();
                    var idAjuan = $('#idAjuanKonfirmasi').val();
                    Swal.fire({
                        title: "Apakah anda yakin ?",
                        text: "Data yang sudah disimpan tidak dapat di ubah !",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Tolak!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        confirmButtonColor: "#f60e0e"
                    }).then((isConfirm) => {
                        if (isConfirm.value) {

                            Swal.fire({
                                title: "Submited!",
                                text: "Data Berhasil disimpan",
                                icon: "success",
                                confirmButtonColor: "#304ffe"
                            });
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('konfirmasiTolakAksi') }}',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    tambahIdAjuan: idAjuan,
                                },
                                success: function(response) {
                                    $('#modalDetailAjuan').modal('hide');
                                    $('#notifBerhasil').html(
                                        '<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Info - </strong> Berhasil disimpan !</div>'
                                    );
                                    $.ajax({
                                        type: 'GET',
                                        url: "getPengajuanJson",
                                        success: function(response) {
                                            buildTable(response.data);
                                        },
                                        error: function(error) {
                                            console.error('Error:', error);
                                        }
                                    });
                                    $.ajax({
                                        type: 'GET',
                                        url: "getAgendaJson",
                                        success: function(response) {
                                            buildToday(response.today);
                                        },
                                        error: function(error) {
                                            console.error('Error:', error);
                                        }
                                    });
                                },
                            });
                        } else {
                            Swal.fire({
                                title: "Cancelled",
                                text: "Your imaginary file is safe :)",
                                icon: "error",
                                confirmButtonColor: "#f60e0e"
                            });
                        }
                    });

                });

                $('body').on('click', '#konfirmasiTerima', function(e) {
                    e.preventDefault();
                    // var ruangKonfirmasiValue = $('#ruangkonfirmasi').val();
                    var idAjuan = $('#idAjuanKonfirmasi').val();
                    Swal.fire({
                        title: "Apakah anda yakin ?",
                        text: "Data yang sudah disimpan tidak dapat di ubah !",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Simpan!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        confirmButtonColor: "#f60e0e"
                    }).then((isConfirm) => {
                        if (isConfirm.value) {

                            Swal.fire({
                                title: "Submited!",
                                text: "Data Berhasil disimpan",
                                icon: "success",
                                confirmButtonColor: "#304ffe"
                            });
                            $.ajax({
                                type: 'POST',
                                url: '{{ route('konfirmasiTerimaAksi') }}',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    // tambahRuangKonfirmasi: ruangKonfirmasiValue,
                                    tambahIdAjuan: idAjuan,
                                },
                                success: function(response) {
                                    $('#modalDetailAjuan').modal('hide');
                                    $('#notifBerhasil').html(
                                        '<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Info - </strong> Berhasil disimpan !</div>'
                                    );
                                    $.ajax({
                                        type: 'GET',
                                        url: "getPengajuanJson",
                                        success: function(response) {
                                            buildTable(response.data);
                                        },
                                        error: function(error) {
                                            console.error('Error:', error);
                                        }
                                    });
                                    $.ajax({
                                        type: 'GET',
                                        url: "getAgendaJson",
                                        success: function(response) {
                                            console.log(response.today);
                                            buildToday(response.today);
                                            buildUpcoming(response.upcoming);
                                            buildOther(response.other);
                                        },
                                        error: function(error) {
                                            console.error('Error:', error);
                                        }
                                    });
                                },
                            });
                        } else {
                            Swal.fire({
                                title: "Cancelled",
                                text: "Your imaginary file is safe :)",
                                icon: "error",
                                confirmButtonColor: "#f60e0e"
                            });
                        }
                    });
                });

                $('body').on('click', '.detailAjuan', function(e) {

                    e.preventDefault();
                    var idDetail = $(this).attr('data-id');
                    console.log(idDetail);

                    $.ajax({
                        url: "{{ route('getDetailAjuan') }}?idAjuan=" + idDetail,
                        type: "GET",
                        dataType: "JSON",
                        success: function(response) {
                            $('.detailAjuanAtas').empty();
                            $('#idAjuanKonfirmasi').val(response.idPermohonanRapat.id_ajuan);

                            for (var i = 0; i < response.ajuan.length; i++) {
                                console.log(response.ajuan[i].tanggal_pinjam);
                                console.log(response.ajuan[i].id);
                                var harike = i + 1;
                                var formattedDatetglPinjam = moment(response.ajuan[i]
                                    .tanggal_pinjam).format(
                                    'DD MMMM YYYY');
                                var formattedDateWaktuPinjam = moment(response.ajuan[i]
                                    .tanggal_pinjam).format(
                                    'HH:mm');
                                var formattedDateWaktuSelesai = moment(response.ajuan[i]
                                        .tanggal_selesai)
                                    .format('HH:mm');

                                var detailPesertaHTML =
                                    '<div class="text-start mt-1"><h4 class="fs-13 text-uppercase text-warning">Nama Kegiatan :</h4><p class="text-muted mb-3"><b id="detNamaKegiatan">' +
                                    response.ajuan[i].nama_rapat +
                                    '</b> <b id="detHariKe" class="text-danger"> (Hari ke ' +
                                    harike +
                                    ')</b></p><h4 class="fs-13 text-uppercase text-warning">Ruangan :</h4><p class="text-muted mb-3"><b id="detRuang">' +
                                    response.ajuan[i].ruangrapat.nama +
                                    '</b></p><p class="text-muted mb-2"><strong>Nama Pemohon :</strong> <span id="detNamaPemohon" class="ms-2">' +
                                    response.ajuan[i].pegawai_absen.nama +
                                    '</span></p><p class="text-muted mb-2"><strong id="detDivisi">Divisi :</strong><span class="ms-2">' +
                                    response.ajuan[i].divisi.nama +
                                    '</span></p><p class="text-muted mb-2"><strong id="detTanggal">Tanggal :</strong> <span class="ms-2">' +
                                    formattedDatetglPinjam +
                                    '</span></p><p class="text-muted mb-2"><strong id="detWaktu">Waktu :</strong> <span class="ms-2">' +
                                    formattedDateWaktuPinjam + ' s.d ' + formattedDateWaktuSelesai +
                                    '</span></p><p class="text-muted mb-1"><strong id="detJmlPeserta">Jumlah Peserta :</strong> <span class="ms-2">' +
                                    response.ajuan[i].jumlah_peserta +
                                    ' Orang</span></p><br></div>';
                                $('.detailAjuanAtas').append(detailPesertaHTML);
                            }

                            var table =
                                '<table id="example2" class="table table-bordered display" style="width:100%">' +
                                '<thead>' +
                                '<tr>' +
                                '<th width="1%">No.</th>' +
                                '<th width="20%">Nama Pegawai</th>' +
                                '<th>Divisi</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>';

                            for (var i = 0; i < response.peserta.length; i++) {
                                console.log(response.peserta[i].id_pegawai_absen);
                                table += '<tr>' +
                                    '<td>' + (i + 1) + '</td>' +
                                    '<td>' + response.peserta[i].pegawai_absen.nama + '</td>' +
                                    '<td>' + response.peserta[i].pegawai_absen.divisipegawai.nama +
                                    '</td>' +
                                    '</tr>';

                            }
                            table += '</tbody></table>';
                            $('.tampildata2').html(table);
                            $('#example2').DataTable({
                                "paging": true
                            });


                            $('#modalDetailAjuan').modal('show');
                        },
                        error: function(error) {
                            console.error('Error fetching detail ajuan data:', error);
                        }
                    });
                });
            });

            $.ajax({
                type: 'GET',
                url: "getAgendaJson",
                success: function(response) {
                    // console.log(response.today);
                    buildToday(response.today);
                    buildUpcoming(response.upcoming);
                    buildOther(response.other);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });

            function buildToday(today) {
                var todayContainer = $("#cardToday");
                todayContainer.empty();
                $.each(today, function(index, rapat) {
                    console.log(rapat);
                    var colorClass = "";
                    var colors = {
                        1: 'text-danger',
                        2: 'text-warning',
                        3: 'text-primary',
                        4: 'text-success',
                        5: 'text-warning',
                        16: 'text-muted'
                    };
                    var defaultColor = 'text-default';

                    var row = $("<div>").addClass("row justify-content-sm-between");
                    var col1 = $("<div>").addClass("col-sm-4 mb-0 mb-sm-0");
                    var col2 = $("<div>").addClass("col-sm-4 mb-0 mb-sm-0");
                    var col3 = $("<div>").addClass("col-sm-4");

                    var formCheck1 = $("<div>").addClass("form-check");
                    var formCheck2 = $("<div>").addClass("form-check");
                    var label1 = $("<label>").addClass("form-check-label " + (colors[rapat.id_ruangrapat] ||
                        defaultColor));
                    var label2 = $("<label>").addClass("form-check-label");

                    label1.attr("for", "task1").text(rapat.ruangrapat.nama);
                    label2.attr("for", "task1").text(rapat.nama_rapat);

                    var divFlex = $("<div>").addClass("d-flex justify-content-between");
                    var ul = $("<ul>").addClass("list-inline fs-13 text-end");
                    var li1 = $("<li>").addClass("list-inline-item").html(
                        "<i class='ri-time-line fs-16 me-1 text-primary'></i> Hari ini " + moment(rapat
                            .tanggal_pinjam).format('DD MMMM HH:mm') + " s.d " + moment(rapat.tanggal_selesai)
                        .format('HH:mm'));
                    var li2 = $("<li>").addClass("list-inline-item ms-1").html(
                        "<span class='badge bg-warning'><a href='#' class='detailPeserta' data-id='" + rapat.id +
                        "'><i class='ri-user-fill text-white'> Peserta " + rapat.jumlah_peserta + "</i> </a></span>"
                    );
                    var li3 = $("<li>").addClass("list-inline-item ms-1").html(
                        "<i class='ri-organization-chart'></i> " + rapat.divisi.nama);
                    var li4 = $("<li>").html("<a href='#'><span class='badge bg-success selesaikan' data-id='" + rapat
                        .id + "'><i class='ri-checkbox-line text-white'> Selesaikan</i></span></a>");

                    ul.append(li1, li2, li3, li4);
                    divFlex.append(ul);
                    col1.append(formCheck1.append(label1));
                    col2.append(formCheck2.append(label2));
                    col3.append(divFlex);

                    row.append(col1, col2, col3);
                    todayContainer.append($("<hr>").addClass("my-2"), row);
                });
            }

            function buildUpcoming(upcoming) {
                var upcomingContainer = $("#cardUpcoming");
                upcomingContainer.empty();
                $.each(upcoming, function(index, rapat) {
                    console.log(rapat);
                    var colorClass = "";
                    var colors = {
                        1: 'text-danger',
                        2: 'text-warning',
                        3: 'text-primary',
                        4: 'text-success',
                        5: 'text-warning',
                        16: 'text-muted'
                    };
                    var defaultColor = 'text-default';

                    var row = $("<div>").addClass("row justify-content-sm-between");
                    var col1 = $("<div>").addClass("col-sm-4 mb-0 mb-sm-0");
                    var col2 = $("<div>").addClass("col-sm-4 mb-0 mb-sm-0");
                    var col3 = $("<div>").addClass("col-sm-4");

                    var formCheck1 = $("<div>").addClass("form-check");
                    var formCheck2 = $("<div>").addClass("form-check");
                    var label1 = $("<label>").addClass("form-check-label " + (colors[rapat.id_ruangrapat] ||
                        defaultColor));
                    var label2 = $("<label>").addClass("form-check-label");

                    label1.attr("for", "task1").text(rapat.ruangrapat.nama);
                    label2.attr("for", "task1").text(rapat.nama_rapat);

                    var divFlex = $("<div>").addClass("d-flex justify-content-between");
                    var ul = $("<ul>").addClass("list-inline fs-13 text-end");
                    var li1 = $("<li>").addClass("list-inline-item").html(
                        "<i class='ri-time-line fs-16 me-1 text-primary'></i> Akan datang " + moment(rapat
                            .tanggal_pinjam).format('DD MMMM HH:mm') + " s.d " + moment(rapat.tanggal_selesai)
                        .format('HH:mm'));
                    var li2 = $("<li>").addClass("list-inline-item ms-1").html(
                        "<span class='badge bg-warning'><a href='#' class='detailPeserta' data-id='" + rapat.id +
                        "'><i class='ri-user-fill text-white'> Peserta " + rapat.jumlah_peserta + "</i> </a></span>"
                    );
                    var li3 = $("<li>").addClass("list-inline-item ms-1").html(
                        "<i class='ri-organization-chart'></i> " + rapat.divisi.nama);
                    var li4 = $("<li>").html("<a href='#'><span class='badge bg-success selesaikan' data-id='" + rapat
                        .id + "'><i class='ri-checkbox-line text-white'> Selesaikan</i></span></a>");

                    ul.append(li1, li2, li3, li4);
                    divFlex.append(ul);
                    col1.append(formCheck1.append(label1));
                    col2.append(formCheck2.append(label2));
                    col3.append(divFlex);

                    row.append(col1, col2, col3);
                    upcomingContainer.append($("<hr>").addClass("my-2"), row);
                });
            }

            function buildOther(other) {
                var otherContainer = $("#cardOther");
                otherContainer.empty();
                $.each(other, function(index, rapat) {
                    console.log(rapat);
                    var colorClass = "";
                    var colors = {
                        1: 'text-danger',
                        2: 'text-warning',
                        3: 'text-primary',
                        4: 'text-success',
                        5: 'text-warning',
                        16: 'text-muted'
                    };
                    var defaultColor = 'text-default';

                    var row = $("<div>").addClass("row justify-content-sm-between");
                    var col1 = $("<div>").addClass("col-sm-4 mb-0 mb-sm-0");
                    var col2 = $("<div>").addClass("col-sm-4 mb-0 mb-sm-0");
                    var col3 = $("<div>").addClass("col-sm-4");

                    var formCheck1 = $("<div>").addClass("form-check");
                    var formCheck2 = $("<div>").addClass("form-check");
                    var label1 = $("<label>").addClass("form-check-label " + (colors[rapat.id_ruangrapat] ||
                        defaultColor));
                    var label2 = $("<label>").addClass("form-check-label");

                    label1.attr("for", "task1").text(rapat.ruangrapat.nama);
                    label2.attr("for", "task1").text(rapat.nama_rapat);

                    var divFlex = $("<div>").addClass("d-flex justify-content-between");
                    var ul = $("<ul>").addClass("list-inline fs-13 text-end");
                    var li1 = $("<li>").addClass("list-inline-item").html(
                        "<i class='ri-time-line fs-16 me-1 text-primary'></i> Lainnya " + moment(rapat
                            .tanggal_pinjam).format('DD MMMM HH:mm') + " s.d " + moment(rapat.tanggal_selesai)
                        .format('HH:mm'));
                    var li2 = $("<li>").addClass("list-inline-item ms-1").html(
                        "<span class='badge bg-warning'><a href='#' class='detailPeserta' data-id='" + rapat.id +
                        "'><i class='ri-user-fill text-white'> Peserta " + rapat.jumlah_peserta + "</i> </a></span>"
                    );
                    var li3 = $("<li>").addClass("list-inline-item ms-1").html(
                        "<i class='ri-organization-chart'></i> " + rapat.divisi.nama);
                    var li4 = $("<li>").html("<a href='#'><span class='badge bg-success selesaikan' data-id='" + rapat
                        .id + "'><i class='ri-checkbox-line text-white'> Selesaikan</i></span></a>");

                    ul.append(li1, li2, li3, li4);
                    divFlex.append(ul);
                    col1.append(formCheck1.append(label1));
                    col2.append(formCheck2.append(label2));
                    col3.append(divFlex);

                    row.append(col1, col2, col3);
                    otherContainer.append($("<hr>").addClass("my-2"), row);
                });
            }

            $.ajax({
                type: 'GET',
                url: "getPengajuanJson",
                success: function(response) {
                    buildTable(response.data);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
            console.log(getPengajuanJson);

            function buildTable(data) {
                var table = '<table id="example" class="table table-bordered display" style="width:100%">' +
                    '<thead>' +
                    '<tr>' +
                    '<th width="3%" >No.</th>' +
                    '<th width="20%">No Pengajuan</th>' +
                    '<th>Status</th>' +
                    '<th>Tanggal</th>' +
                    '<th width="20%">Aksi</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

                for (var i = 0; i < data.length; i++) {
                    var statusText = data[i].status == 1 ? 'Menunggu' : 'Status Lain';
                    var formattedDate2 = moment(data[i].created_at).format('DD MMMM HH:mm');

                    table += '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + data[i].id_ajuan + '</td>' +
                        '<td>' + '<span class="badge bg-danger-subtle text-danger">' + statusText + '</span>' + '</td>' +
                        '<td>' + data[i].tanggal_pinjam + '</td>' +
                        '<td> <center><a class="detailAjuan" href="#" data-id="' + data[i].id_ajuan +
                        '"><span class="badge bg-primary"><i class="ri-checkbox-multiple-fill"></i> Konfirmasi</span></a> </center> </td>' +
                        '</tr>';
                }

                table += '</tbody></table>';
                $('.tampildata').html(table);
                $('#example').DataTable({
                    "paging": true
                });
            }

            $('body').on('click', '.konfirmasiAjuan', function(e) {
                e.preventDefault();
                var idKonfirmasi = $(this).attr('data-id');
                console.log(idKonfirmasi);
                $.ajax({
                    url: "{{ route('konfirmasiAjuan') }}?idAjuan=" + idKonfirmasi,
                    type: "GET",
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response.data.id);
                        var formattedDatetglPinjam = moment(response.data.tanggal_pinjam).format(
                            'DD MMMM YYYY');
                        var formattedDateWaktuPinjam = moment(response.data.tanggal_pinjam).format('HH:mm');
                        var formattedDateWaktuSelesai = moment(response.data.tanggal_selesai).format(
                            'HH:mm');

                        $('#namakegiatankonfirmasi').html(response.data.nama_rapat);
                        $('#idAjuanKonfirmasi').val(response.data.id_ajuan);
                        $('#divisikonfirmasi').html(response.data.divisi.nama);
                        $('#jumlahPesertaKonfirmasi').html(response.data.jumlah_peserta);
                        $('#ruangkonfirmasi option[value="' + response.data.id_ruangrapat + '"]').prop(
                            'selected', true);
                        // $('#waktuKonfirmasi').html(formattedDatetglPinjam + " " + formattedDateWaktuPinjam + " Sampai Dengan " + formattedDateWaktuSelesai);
                        $('#modalKonfirmasiAjuan').modal('show');
                    },
                });
            });

            $('body').on('click', '.selesaikan', function(e) {
                e.preventDefault();
                var idSelesaikan = $(this).attr('data-id');
                console.log(idSelesaikan);
                Swal.fire({
                    title: "Apakah anda yakin ?",
                    text: "Data yang sudah disimpan tidak dapat di ubah !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, Simpan !",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    confirmButtonColor: "#f60e0e"
                }).then((isConfirm) => {
                    if (isConfirm.value) {

                        Swal.fire({
                            title: "Submited!",
                            text: "Data Berhasil disimpan",
                            icon: "success",
                            confirmButtonColor: "#304ffe"
                        });
                        $.ajax({
                            url: "{{ route('selesaikan') }}?idSelesaikan=" + idSelesaikan,
                            type: "GET",
                            dataType: "JSON",
                            success: function(response) {
                                $('#notifBerhasilAgenda').html(
                                    '<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Info - </strong> Berhasil disimpan !</div>'
                                );
                                $.ajax({
                                    type: 'GET',
                                    url: "getAgendaJson",
                                    success: function(response) {
                                        console.log(response.today);
                                        buildToday(response.today);
                                        buildUpcoming(response.upcoming);
                                        buildOther(response.other);
                                    },
                                    error: function(error) {
                                        console.error('Error:', error);
                                    }
                                });
                            },
                        });
                    } else {
                        Swal.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error",
                            confirmButtonColor: "#f60e0e"
                        });
                    }
                });

            });

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
                            '<th>Ttd</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>';

                        for (var i = 0; i < response.peserta.length; i++) {
                            if (response.peserta[i].absen === null) {
                                var absen = 'Belum';
                            } else {
                                var absen = 'Sudah';
                            }
                            table += '<tr>' +
                                '<td>' + (i + 1) + '</td>' +
                                '<td>' + response.peserta[i].pegawai_absen.nama + '</td>' +
                                '<td>' + response.peserta[i].pegawai_absen.divisipegawai.nama + '</td>' +
                                '<td>' + absen + '</td>' +
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
        </script>
    @endsection
