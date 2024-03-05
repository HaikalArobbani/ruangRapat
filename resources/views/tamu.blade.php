<head>
    <title>Tamu</title>
    <?php include 'layouts/title-meta.php'; ?>

    <?php include 'layouts/head-css.php'; ?>
    <style>
        body {
            background-image: url("{{ asset('images/background.jpg') }}");
            background-size: cover;
            background-position: center;
        }

        .content {
            margin-top: 20px;
            background-color: rgba(255, 255, 255, 0.8);

            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 20px;
        }

        .card-body small {
            font-size: 14px;
        }

        .card-body h5 {
            margin-top: 10px;
            font-size: 18px;
        }

        .avatar-group i {
            margin-right: 5px;
        }
    </style>
</head>
<!--
    
    <td>-->

<body>
    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-3"></div>
            <div class="col-xxl-6">
                <div class="content">
                    @foreach ($permohonan_rapat as $p)
                        <div class="card">
                            <div class="card-body">
                                {{-- <a href="" class="float-end btn btn-sm btn-danger"> Absen</a> --}}
                                <a data-id="{{ $p->id }}" class="float-end btn btn-sm btn-danger absenRuangan"
                                    href="/absen_tamu{{ $p->id }}">Absen</a>
                                <small
                                    class="text-muted">{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->formatLocalized('%A, %d %B %Y') }}</small>

                                <h5 class="my-2 fs-16">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#task-detail-modal"
                                        class="text-body">
                                        {{ $p->nama_rapat }}</a>
                                </h5>

                                <p class="mb-0">
                                    <span class="pe-2 text-nowrap mb-2 d-inline-block">
                                        <i class="ri-briefcase-2-line text-success"></i>
                                        {{ $p->divisiPermohonan->nama }} </span>
                                    <span class="text-nowrap mb-2 d-inline-block">
                                        <i class="ri-user-fill text-warning"></i>
                                        {{ $p->jumlah_peserta }}
                                    </span>
                                    &nbsp;
                                    <span class="text-nowrap mb-2 d-inline-block">
                                        <i class="ri-home-3-line text-danger"></i>
                                        {{ $p->ruangRapat->nama }} </span>
                                </p>

                                <div class="avatar-group mt-0">
                                    <i class="ri-time-line text-primary"></i>
                                    &nbsp;<b>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('H:i') }}
                                    </b>&nbsp;WIB
                                </div>
                            </div> <!-- end card-body -->
                        </div>
                    @endforeach
                </div> <!-- content -->
            </div>
        </div>
    </div>
    <!-- dragula js-->
    <script src="assets/vendor/dragula/dragula.min.js"></script>

    <!-- demo js -->
    <script src="assets/js/pages/component.dragula.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>

</body>

</html>
