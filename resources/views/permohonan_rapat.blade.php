@extends('layouts.app')
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">

                    </div>
                    <h4 class="page-title">Permohonan Rapat</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4 col-lg-5">
                <div class="card text-center">
                    <div class="card-body">
                        <form class="d-flex">
                            <div class="input-group">
                                <select name="selectRuang" id="selectRuang" class="form-control shadow border-3">
                                    <option value=""><b>- Pilih Ruangan</b> </option>
                                    @foreach ($ruangRapat as $r)
                                        <option value="{{ $r->id }}">{{ $r->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="input-group-text bg-danger border-danger text-white">
                                    <i class="ri-home-2-fill fs-13"></i>
                                </span>
                            </div>
                            <!-- <a href="javascript: void(0);" class="btn btn-danger ms-2 flex-shrink-0">
                                <i class="ri-refresh-line"></i> Pilih
                            </a> -->
                        </form>
                        </br>
                        <img src="{{ asset('images/users/avatar-11.webp') }}" class="rounded-circle avatar-lg img-thumbnail"
                            alt="profile-image">
                        <h4 id="detailNamaRuang" class="mb-1 mt-2 text-primary"></h4>
                        <div class="text-start mt-3">
                            <p class="text-muted mb-2"><strong>PIC :</strong> <span id="detailPICRuang"
                                    class="ms-2"></span>
                            </p>

                            <p class="text-muted mb-2"><strong>Kapasitas :</strong><span id="detailKapasitasRuang"
                                    class="ms-2"></span>
                            </p>

                            <p class="text-muted mb-2"><strong>Lokasi :</strong> <span id="detailLokasiRuang"
                                    class="ms-2"></span>
                            </p>
                            {{-- <p class="text-muted mb-1"><strong> Fasiltas :</strong>
                            </span><span id="detailFasilitas" class="text-muted"></span>
                        </p> --}}
                            {{-- <p class="text-muted mb-1"><strong>Status Hari ini :</strong>
                            </span><span id="detailStatusRuang" class="text-muted"></span>
                        </p> --}}


                        </div>
                    </div>
                </div>

                <!-- Messages-->
                <div class="card">
                    <div class="card-body">
                        <div class="badge bg-info-subtle text-info" style="padding: 5px 10px;">
                            <h5 class="">Jadwal Kegiatan Hari ini</h4>
                        </div>
                        <div class="inbox-widget" id="targetContainer">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="badge bg-warning-subtle text-warning" style="padding: 5px 10px;">
                            <h5 class="">Jadwal Kegiatan Lusa</h4>
                        </div>
                        <div class="inbox-widget" id="targetContainer2">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="badge bg-primary-subtle text-primary" style="padding: 5px 10px;">
                            <h5 class="">Jadwal Kegiatan Lainnya</h4>
                        </div>
                        <div class="inbox-widget" id="targetContainer3">
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-8 col-lg-7">
                <!-- Chart-->
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-uppercase mb-3"><i class="ri-briefcase-line me-1"></i>
                            Formulir Peminjaman Ruang</h5>
                        <form method="post" id="formSimpanPermohonan" onkeydown="return event.key != 'Enter';">

                            @csrf

                            <div class="row">
                                <div class="col-xl-6 col-lg-5">
                                    <div class="form-group mb-2">
                                        <label>Nama Pemohon</label>
                                        <select class="form-control select2" data-toggle="select2" id="tambahNamaPemohon"
                                            required>
                                            <option value="">- Pilih Pemohon</option>
                                            @foreach ($pegawai as $p)
                                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Divisi</label>
                                        <input type="hidden" class="form-control" id="tambahDivisiId" readonly required>
                                        <input type="text" class="form-control" id="tambahDivisi" readonly required>
                                    </div>

                                    <div class="form-group mb-2">
                                        <label>Waktu pinjam</label>
                                        <select name="jumlah_hari" id="jumlah_hari" class="form-control" required>
                                            <option value=""> - Pilih Jumlah Hari</option>
                                            <?php
                                        for($i = 1; $i <= 14; $i++)
                                        { ?>
                                            <option value="{{ $i }}">{{ $i }} Hari </option>
                                            <?php } ?>

                                        </select>
                                        <br>
                                        <div class="row" id="tanggalDurasi">
                                        </div>

                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Nama Kegiatan</label>
                                        <textarea name="" id="namaKegiatan" cols="30" rows="5" class="form-control" required></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-5">
                                    <label>Pilih Nama Peserta</label>
                                    <input type="text" id="search" class="form-control mb-2"
                                        placeholder="Cari nama peserta...">
                                    <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                        <table id="myTable" class="table table-striped dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Divisi</th>
                                                    <th>Id</th>
                                                    <th>Opsi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $no = 1;
                                                @endphp
                                                @foreach ($pegawai as $p)
                                                    <tr>
                                                        <td>{{ $p->nama }}</td>
                                                        <td>{{ $p->divisiPegawai->nama }}</td>
                                                        <td>{{ $p->id }}</td>
                                                        <td>
                                                            <a href="#"
                                                                class="btn btn-sm btn-warning add-participant">
                                                                <i class="ri-add-circle-fill"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="notification" class="text-danger"></div>
                                    </br>
                                    <div class="form-group mb-2">
                                        <div class="form-group mb-2" id="pesertaTerpilih">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- SIMPAN KE DB JANGAN KELEWAT !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                            <input type="hidden" id="idRuangan" name="idRuangan">
                            <!-- SIMPAN KE DB JANGAN KELEWAT !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                            <div class="notifBerhasil"></div>
                            <div class="modal-footer">
                                <!-- <button type="button" class="btn btn-default btn-sm waves-effect waves-light"
                                    data-dismiss="modal">Close</button> -->
                                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light"
                                    id="btnSimpan">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End Chart-->

                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="aboutme">
                                <h5 class="text-uppercase mb-3"><i class="ri-briefcase-line me-1"></i>
                                    PENGAJUAN </h5>
                                <div class="table-responsive tampildata" data-pattern="priority-columns">
                                </div>
                                <br>
                                <h6 class="text-danger">* Apabila ada perubahan data, silahkan hapus dan lakukan
                                    pengajuan
                                    ulang </h6>
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
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="detailAjuanAtas">
                                </div>
                                <h4 class="fs-13 text-uppercase text-warning">Daftar Nama Peserta</h4>
                                <div class="table-responsive tampildata2" data-pattern="priority-columns">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script>
            $(document).ready(function() {
                var selectedParticipants = {};
                $('#btnSimpan').click(function(event) {
                    event.preventDefault();

                    if ($('#tambahNamaPemohon').val() === '' || $('#tambahDivisiId').val() === '' || $(
                            '#jumlah_hari').val() === '' || $('#namaKegiatan').val() === '' || $('#idRuangan')
                        .val() === '' || Object.keys(selectedParticipants).length === 0) {
                        $('.notifBerhasil').html(
                            '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Error - </strong> Isi Data dengan Lengkap.</div>'
                            );
                        return;
                    }



                    var tambahNamaPemohonValue = $('#tambahNamaPemohon').val();
                    var tambahDivisiValue = $('#tambahDivisiId').val();
                    var jumlahHariValue = $('#jumlah_hari').val();

                    for (var i = 1; i <= jumlahHariValue; i++) {
                        var durasiPinjam = $('#durasiPinjam_' + i).val();
                        var waktuPinjam = $('#waktuPinjam_' + i).val();
                        var today = new Date();
                        today.setHours(0, 0, 0, 0);
                        var waktuPinjamDate = new Date(waktuPinjam);

                        if (durasiPinjam === '' || waktuPinjam === '' || waktuPinjamDate < today) {
                            $('.notifBerhasil').html(
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Error - </strong> Tanggal dan Durasi Pada hari ke ' +
                                i + ' harus diisi dan tidak boleh kurang dari hari ini.</div>');
                            return false;
                        }
                    }

                    var namaKegiatanValue = $('#namaKegiatan').val();
                    var idRuanganValue = $('#idRuangan').val();
                    var tanggalDanDurasi = [];

                    for (var i = 1; i <= jumlahHariValue; i++) {
                        var waktuPinjam = $('#waktuPinjam_' + i).val();
                        var durasiPinjam = $('#durasiPinjam_' + i).val();

                        tanggalDanDurasi.push({
                            waktu_pinjam: waktuPinjam,
                            durasi_pinjam: durasiPinjam
                        });
                    }
                    console.log(tanggalDanDurasi);

                    var $submitButton = $(this);

                    $submitButton.prop('disabled', true);
                    $submitButton.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...'
                        );

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('simpanAjuan') }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            tambahNamaPemohon: tambahNamaPemohonValue,
                            tambahDivisi: tambahDivisiValue,
                            jumlahHari: jumlahHariValue,
                            namaKegiatan: namaKegiatanValue,
                            idRuangan: idRuanganValue,
                            tanggalDanDurasi: tanggalDanDurasi,
                            selectedParticipants: selectedParticipants
                        },

                        success: function(response) {
                            // $('#tambahNamaPemohon').val('');
                            // $('#tambahDivisiId').val('');
                            // $('#jumlah_hari').val('');
                            // $('#namaKegiatan').val('');
                            // $('#idRuangan').val('');

                            // for (var i = 1; i <= jumlahHariValue; i++) {
                            //     $('#waktuPinjam_' + i).val('');
                            //     $('#durasiPinjam_' + i).val('');
                            // }

                            if (response.status === 'error') {
                                $('.notifBerhasil').html(
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Error - </strong> ' +
                                    response.message + '</div>');
                            } else {
                                $('.notifBerhasil').html(
                                    '<div class="alert alert-info alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Info - </strong> ' +
                                    response.message + '</div>');
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
                        },
                        error: function(error) {
                            console.error('Error:', error);
                            $('.notifBerhasil').html(
                                '<div class="alert alert-danger alert-dismissible fade show" role="alert"><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button><strong>Error - </strong> Terjadi kesalahan saat menyimpan data.</div>'
                                );
                        },
                        complete: function() {
                            $submitButton.prop('disabled', false);
                            $submitButton.html('Simpan');
                        }
                    });
                });

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

                function buildTable(data) {
                    var table = '<table id="example" class="table table-bordered display" style="width:100%">' +
                        '<thead>' +
                        '<tr>' +
                        '<th width="3%" >No.</th>' +
                        '<th width="20%">No Pengajuan</th>' +
                        '<th>Status</th>' +
                        '<th>Tanggal Input</th>' +
                        '<th width="20%">Opsi</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>';

                    for (var i = 0; i < data.length; i++) {
                        var statusText = (data[i].status == 1) ? 'Menunggu' : 'Status Lain';
                        var formattedDate2 = moment(data[i].created_at).format('DD MMMM HH:mm');

                        table += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td>' + data[i].id + '</td>' +
                            '<td>' + '<span class="badge bg-info-subtle text-info">' + data[i].status + '</span>' +
                            '</td>' +
                            '<td>' + formattedDate2 + '</td>' +
                            '<td>  <a class="btn btn-sm btn-danger hapusAjuan" href="#" data-id="' + data[i].id +
                            '"><i class="ri-delete-bin-5-line"></i></a> <a class="btn btn-sm btn-primary detailAjuan" href="#" data-id="' +
                            data[i].id + '"><i class="ri-eye-line"></i></a> </td>' +
                            '</tr>';
                    }

                    table += '</tbody></table>';
                    $('.tampildata').html(table);
                    $('#example').DataTable({
                        "paging": true
                    });
                }

                $('body').on('click', '.hapusAjuan', function(e) {
                    e.preventDefault();
                    var idHapus = $(this).attr('data-id');
                    Swal.fire({
                        title: "Apakah anda yakin ?",
                        text: "Data yang sudah dihapus tidak dapat di recovery !",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Hapus!",
                        cancelButtonText: "No, cancel!",
                        closeOnConfirm: false,
                        closeOnCancel: false,
                        confirmButtonColor: "#f60e0e"
                    }).then((isConfirm) => {
                        if (isConfirm.value) {

                            Swal.fire({
                                title: "Deleted!",
                                text: "Data Berhasil dihapus",
                                icon: "success",
                                confirmButtonColor: "#304ffe"
                            });
                            $.ajax({
                                type: 'GET',
                                url: "hapusAjuan/" + idHapus,
                                success: function(response) {
                                    $('.notifBerhasil').html(
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

                    $.ajax({
                        url: "{{ route('getDetailAjuan') }}?idAjuan=" + idDetail,
                        type: "GET",
                        dataType: "JSON",
                        success: function(response) {
                            $('.detailAjuanAtas').empty();
                            for (var i = 0; i < response.ajuan.length; i++) {
                                console.log(response.ajuan[i].tanggal_pinjam);
                                console.log(response.ajuan[i].id);
                                var harike = i + 1;
                                var formattedDatetglPinjam = moment(response.ajuan[i]
                                    .tanggal_pinjam).format('DD MMMM YYYY');
                                var formattedDateWaktuPinjam = moment(response.ajuan[i]
                                    .tanggal_pinjam).format('HH:mm');
                                var formattedDateWaktuSelesai = moment(response.ajuan[i]
                                    .tanggal_selesai).format('HH:mm');

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

                $('#jumlah_hari').change(function() {
                    updateDurasiFields();
                });

                $('#search').on('keyup', function() {
                    var searchTerm = $(this).val().toLowerCase();
                    $('#myTable tbody tr').each(function() {
                        var name = $(this).find('td:first').text().toLowerCase();
                        var division = $(this).find('td:eq(1)').text().toLowerCase();
                        if (name.includes(searchTerm) || division.includes(searchTerm)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });



                $('#myTable tbody').on('click', '.add-participant', function() {
                    var row = $(this).closest('tr');
                    var id = row.find('td:eq(2)').text();

                    selectedParticipants[id] = {
                        id: id,
                        nama: row.find('td:eq(0)').text(),
                        divisi: row.find('td:eq(1)').text(),
                    };
                    console.log(selectedParticipants);

                    updateSelectedParticipantsDisplay();
                });

                $('#pesertaTerpilih').on('click', '.remove-participant', function() {
                    var id = $(this).data('id');
                    delete selectedParticipants[id];
                    updateSelectedParticipantsDisplay();
                });

                function updateSelectedParticipantsDisplay() {
                    $('#pesertaTerpilih').empty();

                    for (var id in selectedParticipants) {
                        var participant = selectedParticipants[id];
                        var selectedParticipant = '<div class="mb-2">' +
                            '<span><strong>' + participant.nama + '</strong> - ' + participant.divisi + '</span>' +
                            '  ' +
                            '<button class="btn btn-sm btn-danger remove-participant" data-id="' + participant.id +
                            '"><i class="ri-delete-bin-2-line"></i></button>' +
                            '</div>';
                        $('#pesertaTerpilih').append(selectedParticipant);
                    }
                }

                $('#tambahNamaPemohon').on('change', function() {
                    var selectedPemohonId = $(this).val();
                    console.log(selectedPemohonId);
                    $.ajax({
                        url: '/getDivisi',
                        method: 'GET',
                        data: {
                            pemohonId: selectedPemohonId
                        },
                        success: function(response) {

                            $('#tambahDivisi').val(response.divisi.nama);
                            $('#tambahDivisiId').val(response.divisi.id);
                        },
                        error: function(error) {
                            console.error('Error fetching divisi data:', error);
                        }
                    });
                });

                $('#selectRuang').on('change', function() {
                    var selectedRuang = $(this).val();
                    $.ajax({
                        url: '/getRuang',
                        method: 'GET',
                        data: {
                            ruangId: selectedRuang
                        },
                        success: function(response) {
                            $('#idRuangan').val(response.ruang.id);
                            $('#detailNamaRuang').text(response.ruang.nama);
                            $('#detailPICRuang').text("Rumga");
                            $('#detailKapasitasRuang').text(response.ruang.kapasitas);
                            $('#detailLokasiRuang').text(response.ruang.lokasi);
                            if (response.ruang.status == 1) {
                                $('#detailStatusRuang').text("TERSEDIA");
                            } else {
                                $('#detailStatusRuang').text("TIDAK TERSEDIA");
                            }
                            var inboxItems = '';
                            var inboxItems2 = '';
                            var inboxItems3 = '';

                            response.permohonan.forEach(function(permohonan) {

                                var formattedDate = moment(permohonan.tanggal_pinjam)
                                    .format('DD MMMM HH:mm');
                                var formattedDate2 = moment(permohonan.tanggal_selesai)
                                    .format('HH:mm');

                                inboxItems += '<div class="inbox-widget">' +
                                    '<div class="inbox-item">' +
                                    '<div class="inbox-item-img"><img src="{{ asset('images/users/kalender.jpg') }}" class="rounded-circle" alt=""></div>' +
                                    '<p class="inbox-item-author">' + permohonan.divisi
                                    .nama + '</p>' +
                                    '<p class="inbox-item-text">' + permohonan.nama_rapat +
                                    '</p>' +
                                    '<p class="inbox-item-date">' +
                                    '<span class="badge bg-info-subtle text-info">' +
                                    formattedDate + ' s/d ' + formattedDate2 + '</span>' +
                                    '</p>' +
                                    '</div>' +
                                    '</div>';
                            });

                            response.permohonanTomorrow.forEach(function(permohonan) {
                                var formattedDate = moment(permohonan.tanggal_pinjam)
                                    .format('DD MMMM HH:mm');
                                var formattedDate2 = moment(permohonan.tanggal_selesai)
                                    .format('HH:mm');

                                inboxItems2 += '<div class="inbox-widget">' +
                                    '<div class="inbox-item">' +
                                    '<div class="inbox-item-img"><img src="{{ asset('images/users/kalender.jpg') }}" class="rounded-circle" alt=""></div>' +
                                    '<p class="inbox-item-author">' + permohonan.divisi
                                    .nama + '</p>' +
                                    '<p class="inbox-item-text">' + permohonan.nama_rapat +
                                    '</p>' +
                                    '<p class="inbox-item-date">' +
                                    '<span class="badge bg-warning-subtle text-warning">' +
                                    formattedDate + ' s/d ' + formattedDate2 + '</span>' +
                                    '</p>' +
                                    '</div>' +
                                    '</div>';
                            });

                            response.permohonanOther.forEach(function(permohonan) {
                                var formattedDate = moment(permohonan.tanggal_pinjam)
                                    .format('DD MMMM HH:mm');
                                var formattedDate2 = moment(permohonan.tanggal_selesai)
                                    .format('HH:mm');

                                inboxItems3 += '<div class="inbox-widget">' +
                                    '<div class="inbox-item">' +
                                    '<div class="inbox-item-img"><img src="{{ asset('images/users/kalender.jpg') }}" class="rounded-circle" alt=""></div>' +
                                    '<p class="inbox-item-author">' + permohonan.divisi
                                    .nama + '</p>' +
                                    '<p class="inbox-item-text">' + permohonan.nama_rapat +
                                    '</p>' +
                                    '<p class="inbox-item-date">' +
                                    '<span class="badge bg-primary-subtle text-primary">' +
                                    formattedDate + ' s/d ' + formattedDate2 + '</span>' +
                                    '</p>' +
                                    '</div>' +
                                    '</div>';
                            });

                            $('#targetContainer').html(inboxItems);
                            $('#targetContainer2').html(inboxItems2);
                            $('#targetContainer3').html(inboxItems3);
                        },
                        error: function(error) {
                            console.error('Error fetching ruang data:', error);
                        }
                    });
                });
            });

            function updateDurasiFields() {
                var jumlahHari = $('#jumlah_hari').val();

                $('#tanggalDurasi').empty();
                for (var i = 1; i <= jumlahHari; i++) {
                    var dateInput = '<div class="col-xl-6 col-lg-5">' +
                        '<div class="form-group mb-2">' +
                        '<label>Tanggal & Jam - Hari ' + i + '</label>' +
                        '<input type="datetime-local" class="form-control" id="waktuPinjam_' + i + '">' +
                        '</div>' +
                        '</div>';

                    var durationInput = '<div class="col-xl-6 col-lg-5">' +
                        '<div class="form-group mb-2">' +
                        '<label>Durasi (JAM) - Hari ' + i + '</label>' +
                        '<input id="durasiPinjam_' + i + '" type="number" class="form-control" name="durasi_hari_' + i +
                        '" min="1" value="" required>' +
                        '</div>' +
                        '</div>';

                    $('#tanggalDurasi').append(dateInput + durationInput);
                }
            }
        </script>

        <script src="{{ asset('vendor/chart.js/chart.min.js') }}"></script>
        <!-- Profile Demo App js -->
        <script src="{{ asset('js/pages/demo.profile.js') }}"></script>
    @endsection
