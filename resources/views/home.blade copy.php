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
                                            <div id="external-events" class="mt-3">
                                                <marquee behavior="" direction="">Infomasi Nama ruangan berdasarkan
                                                    Warna</marquee>
                                                <p class="text-muted"></p>
                                                <table class="table table-centered table-borderless mb-0 "
                                                    style="margin-top: 20px;">
                                                    <!-- Margin top untuk table -->
                                                    <tbody>
                                                        @foreach ($ruangan as $r)
                                                            <tr>
                                                                <td>
                                                                <td>
                                                                    {{-- <button type="button"
                                                                        class="btn  btn-md mb-0 w-200"
                                                                        style="background-color: {{ $r->id == 1 ? '#005792' : ($r->id == 2 ? '#28a745' : '#dc3545') }}; color: #ffffff;">
                                                                        <i class="ri-home-office-fill "></i>
                                                                        {{ $r->nama }}
                                                                    </button> --}}
                                                                    {{-- <button type="button" data-id="{{ $r->id }}"
                                                                        data-toggle="modal" data-target="#detailModal"
                                                                        class="btn btn-success btn-md mb-0 w-100"
                                                                        style="background-color: {{ $r->id == 1 ? '#005792' : ($r->id == 2 ? '#28a745' : '#dc3545') }}; color: #ffffff;"><i
                                                                            class="ri-home-office-fill "></i>
                                                                        {{ $r->nama }}
                                                                    </button> --}}
                                                                    <a class="btn editRuangan"
                                                                        style="background-color: {{ $r->id == 1 ? '#005792' : ($r->id == 2 ? '#28a745' : '#dc3545') }}; color: #ffffff;"
                                                                        data-id="{{ $r->id }}"><i
                                                                            class="ri-home-office-fill "></i>
                                                                        {{ $r->nama }}</a>
                                                                </td>

                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div>
                                                    <button type="button"
                                                        class="btn btn-success btn-sm mb-2 w-100">Ruang Rapat
                                                        Dirut</button>
                                                    <br>
                                                    <button type="button"
                                                        class="btn btn-success btn-sm mb-2 w-100">AULA</button>
                                                </div>


                                                <div class="external-event"
                                                    style="background-color: #005792; color: #ffffff;"
                                                    data-class="bg-warning">
                                                    <i class="ri-home-office-fill me-2 vertical-middle"></i>Ruang Rapat
                                                    Dirut
                                                </div>

                                                <div class="external-event"
                                                    style="background-color: #42b883; color: #ffffff;"
                                                    data-class="bg-warning" data-toggle="modal"
                                                    data-target="#infoModal">
                                                    <i class="ri-home-office-fill me-2 vertical-middle"></i>AULA
                                                </div>
                                                <div class="external-event"
                                                    style="background-color: #153b44; color: #ffffff;"
                                                    data-class="bg-warning">
                                                    <i class="ri-home-office-fill me-2 vertical-middle"></i>Ruang Rapat
                                                    Dirum
                                                </div>

                                                <div class="external-event"
                                                    style="background-color: #685454; color: #ffffff;"
                                                    data-class="bg-warning">
                                                    <i class="ri-home-office-fill me-2 vertical-middle"></i>Ruang Rapat
                                                    Dirop
                                                </div>
                                                <div class="external-event"
                                                    style="background-color: #ffa952; color: #ffffff;"
                                                    data-class="bg-warning">
                                                    <i class="ri-home-office-fill me-2 vertical-middle"></i>Ruang Rapat
                                                    Ex-Dirut
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
                        <h4 class="modal-title" id="">Edit Ruangan</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="{{ route('updateRuangan') }}"
                            onkeydown="return event.key != 'Enter';">
                            @csrf
                            <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input id="nama" name="nama" type="text" class="form-control" required>

                            </div>
                            <div class="form-group">
                                <label for="">Kapasitas</label>
                                <input id="kapasitas" name="kapasitas" type="number" class="form-control" required>
                            </div>
                            {{-- <div>
                                <label for="">Fasilitas</label>
                                <br>
                                <select class="js-edit-basic-multiple" name="fasilitas_edit_baru[]"
                                    id="edit-fasilitas_baru" multiple="multiple" style="width:100%"
                                    data-toggle="select2">
                                    <option value=""disabled selected>Edit fasilitas</option>
                                    @foreach ($fasilitas_baru as $f)
                                        <option value="{{ $f->nama }}">{{ $f->nama }}</option>
                                    @endforeach
                                </select>
                                <br>
                            </div> --}}
                            <div class="form-group">
                                <label for="">Lokasi</label>
                                <input id="lokasi" name="lokasi" type="text" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="idruangRapat" id="idruangRapat" value="" required>
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                {{-- <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light"
                                    value="Simpan">Simpan</button> --}}
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
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
                    success: function(data) {
                        // Mengisi form pada modal dengan data yang didapat
                        $("#nama").val(data.nama);
                        $("#kapasitas").val(data.kapasitas);
                        $("#lokasi").val(data.lokasi);
                        $("#idruangRapat").val(data.id);

                        // Set selected untuk penanggung jawab
                        // $("#id_pegawai").val(data.id_pegawai).trigger("change");

                        // // Set selected untuk fasilitas (multi-select)
                        // $("#edit-fasilitas_baru").val(data.id_fasilitas_baru).trigger("change");

                        // Menampilkan modal
                        $("#modal_editruangan").modal("show");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    },
                });
            });
        });
    </script>

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
                            '#685454'; // Dirop
                    } else if (info.event.extendedProps.id_ruangrapat === 4) {
                        info.el.style.backgroundColor =
                            '#153b44'; //Dirum
                    } else if (info.event.extendedProps.id_ruangrapat === 5) {
                        info.el.style.backgroundColor =
                            '#42b883'; // aula
                    }
                    // Tambahkan lebih banyak kondisi jika diperlukan
                },
                displayEventTime: false,
                editable: true,
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
