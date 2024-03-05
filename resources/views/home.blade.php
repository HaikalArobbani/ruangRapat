<?php include 'layouts/session.php'; ?>
<?php include 'layouts/main.php'; ?>

<head>
    <title>Calendar | Attex - Bootstrap 5 Admin & Dashboard Template</title>
    <?php include 'layouts/title-meta.php'; ?>

    <!-- Fullcalendar css -->
    <link href="vendor/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />

    <?php include 'layouts/head-css.php'; ?>
</head>

<body>
    <?php
    
    use App\Models\Permohonan_Rapat;
    use Carbon\Carbon;
    Carbon::setlocale('id');
    
    $agenda_hari_ini = Permohonan_Rapat::whereDate('tanggal_pinjam', Carbon::now())->get();
    
    ?>
    <!-- Begin page -->
    <div class="wrapper">

        <?php include 'layouts/menu.php'; ?>

        <div class="content-page">
            <div class="content">
                <br>
                <!-- Start Content-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <!-- <div class="d-grid">
                                                <button class="btn btn-lg fs-16 btn-danger" id="btn-new-event">
                                                    <i class="ri-add-circle-fill"></i> Create New Event
                                                </button>
                                            </div> -->
                                            <div class="external-events">
                                                @foreach ($ruangan as $r)
                                                    <a class="btn  btn-md mb-2 w-100 editRuangan"
                                                        style="background-color: {{ $r->id == 1
                                                            ? '#ffa952'
                                                            : ($r->id == 2
                                                                ? '#005792'
                                                                : ($r->id == 3
                                                                    ? '#153b44' // Ini untuk ID 3 dengan warna hitam
                                                                    : ($r->id == 4
                                                                        ? '#685454' // Ini untuk ID 4 dengan warna hijau
                                                                        : '#42b883'))) }}; color: #ffffff;"
                                                        data-id="{{ $r->id }}">
                                                        {{ $r->nama }}
                                                    </a>
                                                @endforeach
                                            </div>
                                            <div class="mt-2">
                                                <h5 class="m-0 pb-2">
                                                    <a class="text-dark" data-bs-toggle="collapse" href="#todayTasks"
                                                        role="button" aria-expanded="false" aria-controls="todayTasks">
                                                        <i class="ri-arrow-down-s-line fs-18"></i>Kegiatan Hari ini -
                                                        {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                                                    </a>
                                                </h5>

                                                <div class="collapse show" id="todayTasks">
                                                    <div class="card mb-0">

                                                        <table class="table table-striped table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Waktu Kegiatan</th>
                                                                    <th>Divisi</th>
                                                                    <th>Peserta</th>
                                                                    <th>Ruangan</th>
                                                                    <!-- Tambahkan lebih banyak header tabel jika diperlukan -->
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($agenda_hari_ini as $a)
                                                                    <tr>
                                                                        <td>{{ \Carbon\Carbon::parse($a->tanggal_pinjam)->translatedFormat('H:i') }}
                                                                        </td>
                                                                        <td>{{ $a->divisiPermohonan->nama }}</td>
                                                                        <td>{{ $a->jumlah_peserta }}</td>
                                                                        <td>{{ $a->ruangRapat->nama }}</td>
                                                                        <!-- Tambahkan lebih banyak data sel tabel jika diperlukan -->
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div> <!-- end col-->

                                        <div class="col-lg-9">
                                            <div class="mt-4 mt-lg-0">
                                                <div id="calendar"></div>
                                            </div>
                                        </div> <!-- end col -->

                                    </div> <!-- end row -->
                                </div> <!-- end card body-->
                            </div> <!-- end card -->
                            <!-- Bootstrap Modal -->

                            <!-- Large -->
                            <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="calendarModalLabel">Event modal</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table id="alternative-page-datatable"
                                                class="table table-striped dt-responsive nowrap w-100"
                                                style="margin-top: 20px;"> <!-- Margin top untuk table -->

                                            </table>
                                            <!--  -->
                                        </div>
                                        <div class="modal-footer">
                                            <div class="col-6 text-end">
                                                <button type="button" class="btn btn-light me-1"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <!-- Add New Event MODAL -->
                        </div>
                        <!-- end col-12 -->
                    </div> <!-- end row -->

                </div> <!-- container -->

            </div> <!-- content -->

            <?php include 'layouts/footer.php'; ?>

        </div>
        {{-- Detail Ruangan --}}
        <div class="modal fade" id="modal_editruangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true" data-backdrop="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="">Detail Ruangan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th>Nama Ruangan</th>
                                    <td id="modal_nama_ruangan"></td>
                                </tr>
                                <tr>
                                    <th>Kapasitas</th>
                                    <td id="modal_kapasitas"></td>
                                </tr>
                                <tr>
                                    <th>Fasilitas</th>
                                    <td id="modal_fasilitas"></td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td id="modal_lokasi"></td>
                                </tr>
                                <!-- Tambahkan baris lain sesuai dengan data yang ingin ditampilkan -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".editRuangan", function() {
                var id = $(this).attr("data-id");
                console.log("ID yang didapatkan adalah: ", id);

                // AJAX call untuk mengambil data ruangan
                $.ajax({
                    url: "{{ route('editRuangan') }}?id=" +
                        id, // Sesuaikan dengan URL endpoint Anda
                    type: "GET",
                    dataType: "JSON",
                    // Mengirimkan ID sebagai parameter
                    success: function(data) {
                        // Mengisi tabel pada modal dengan data yang didapat
                        $("#modal_nama_ruangan").text(data.nama);
                        $("#modal_kapasitas").text(data.kapasitas);
                        $("#modal_lokasi").text(data.lokasi);
                        // Jika 'fasilitas' adalah array atau koleksi, gabungkan menjadi string
                        $("#modal_fasilitas").text(data.id_fasilitas_baru);

                        // Menampilkan modal
                        $("#modal_editruangan").modal("show");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            });
        });
    </script>

    {{-- card today --}}


    <script>
        //   import idLocale from '@fullcalendar/core/locales/id'; // import locale Indonesia
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next,today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                locale: 'id',
                initialView: 'dayGridMonth',
                eventDisplay: 'block',
                events: '/ruang-rapat/events',
                eventOrder: 'id',
                eventDidMount: function(info) {
                    // var tooltip = new Tooltip(info.el, {
                    //     title: info.event.extendedProps.description,
                    //     placement: 'top',
                    //     trigger: 'hover',
                    //     container: 'body'
                    // });


                    if (info.event.extendedProps.id_ruangrapat === 1) {
                        info.el.style.backgroundColor =
                            '#ffa952'; // ex dirut
                    } else if (info.event.extendedProps.id_ruangrapat === 2) {
                        info.el.style.backgroundColor =
                            '#005792'; // Dirut
                    } else if (info.event.extendedProps.id_ruangrapat === 3) {
                        info.el.style.backgroundColor =
                            '#153b44'; // Dirop
                    } else if (info.event.extendedProps.id_ruangrapat === 4) {
                        info.el.style.backgroundColor =
                            '#685454'; //Dirum
                    } else if (info.event.extendedProps.id_ruangrapat === 5) {
                        info.el.style.backgroundColor =
                            '#42b883'; // aula
                    }
                    // Tambahkan lebih banyak kondisi jika diperlukan
                },
                displayEventTime: false,
                editable: false,
                selectable: true,
                eventClick: function(info) {
                    // Mengatur judul modal
                    $('#calendarModalLabel').text(info.event.extendedProps.nama_rapat);
                    // Mengatur isi modal, Anda bisa menyesuaikannya untuk menampilkan informasi yang Anda inginkan
                    var namaRuangan = info.event.extendedProps.nama_ruangan;
                    var peserta = info.event.extendedProps.jumlah_peserta;
                    var divisi = info.event.extendedProps.nama_divisi;

                    // Pastikan ini sesuai dengan data Anda
                    var startTime = moment(info.event.start).locale('id').format('LLLL');
                    var endTime = moment(info.event.end).locale('id').format('LLLL');
                    var modalBody = `
                <table class="table table-striped dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <td>
                                <h5>Waktu Masuk</h5>
                            </td>
                            <td>${startTime}</td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Waktu Selesai</h5>
                            </td>
                            <td>${endTime}</td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Nama Ruangan</h5>
                            </td>
                            <td>${namaRuangan}</td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Jumlah Peserta</h5>
                            </td>
                            <td>${peserta}</td>
                        </tr>
                        <tr>
                            <td>
                                <h5>Divisi</h5>
                            </td>
                            <td>${divisi}</td>
                        </tr>
                    </thead>
                </table>
            `;

                    $('.modal-body').html(modalBody);

                    // Menampilkan modal
                    $('#calendarModal').modal('show');
                }
            });

            calendar.render();
        });
    </script>

    <!-- END wrapper -->

    <?php include 'layouts/right-sidebar.php'; ?>

    <?php include 'layouts/footer-scripts.php'; ?>

    <!-- Fullcalendar js -->
    <script src="vendor/fullcalendar/main.min.js"></script>

    <!-- Calendar App Demo js -->
    <script src="js/pages/demo.calendar.js"></script>

    <!-- App js -->
    <script src="js/app.min.js"></script>
</body>

</html>
