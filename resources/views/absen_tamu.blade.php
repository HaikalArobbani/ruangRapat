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

<body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

    <br>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-3"></div>
            <div class="col-xxl-6">
                <div class="content">
                    <br>
                    <center>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">ABSEN TAMU KEGIATAN</h4>
                                    <form method="post" action="{{ route('simpan_tamu_absen') }}"
                                        enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">

                                        <div class="no-click">
                                            <label>Nama Rapat</label>
                                            <input type="text" name="nama_rapat" id="nama_rapat"
                                                class="kondisi form-control" required readonly placeholder="Nama"
                                                value="{{ $permohonan_rapat->nama_rapat }}"
                                                aria-describedby="emailHelp">
                                        </div>
                                        @php
                                            setlocale(LC_TIME, 'id_ID', 'Indonesian_Indonesia', 'Indonesian');
                                        @endphp

                                        <div class="no-click">
                                            <label>Waktu Rapat</label>
                                            <input type="text" name="waktu_rapat" id="waktu_rapat"
                                                class="kondisi form-control" required readonly placeholder="Waktu Rapat"
                                                value="{{ \Carbon\Carbon::parse($permohonan_rapat->tanggal_pinjam)->formatLocalized('%A, %d %B %Y') }}"
                                                aria-describedby="emailHelp">
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label for="nama_tamu">Nama Peserta</label>
                                                <input type="text" class="form-control" id="nama_tamu"
                                                    name="nama_tamu" placeholder="masukan nama">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="nama_instansi">Nama Instansi</label>
                                                <input type="text" class="form-control" id="instansi_tamu"
                                                    name="instansi_tamu" placeholder="masukan nama Instansi">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {{-- nama namu --}}

                                            <label for="">Tanda Tangan</label>
                                            <br>
                                            <canvas id="signatureCanvas" width="300" height="100"
                                                style="border: 2px solid #d6cbcb8d;"></canvas>
                                            <br>
                                            <center>
                                                <a href="#" id="resetSignature">Reset</a>
                                            </center>
                                            <input type="hidden" name="tanda_tangan" id="tandaTanganInput">

                                            <label class="form-check-label" for="customCheckcolor1"> Absen</label>
                                            <input type="checkbox" class="form-check-input" id="customCheckcolor1">
                                        </div>
                                        <input type="text" value="{{ $permohonan_rapat->id }}"
                                            name="id_permohonan_rapat">
                                        <br>
                                        <div class="">
                                            <button type="submit" class="btn btn-dark waves-effect waves-light"
                                                id="btnAbsen" disabled>ABSEN</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>
                    </center>
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
    <script>
        // disable button
        document.addEventListener("DOMContentLoaded", function() {
            var checkbox = document.getElementById("customCheckcolor1");
            var btnAbsen = document.getElementById("btnAbsen");

            checkbox.addEventListener("change", function() {
                if (this.checked) {
                    btnAbsen.removeAttribute("disabled");
                } else {
                    btnAbsen.setAttribute("disabled", "disabled");
                }
            });
        });
    </script>
    <script>
        // Tanda tangan atau signatur
        document.addEventListener("DOMContentLoaded", function() {
            var canvas = document.getElementById('signatureCanvas');
            var signaturePad = new SignaturePad(canvas);

            //    evet pada btn absen
            document.getElementById('btnAbsen').addEventListener('click', function() {
                var dataURL = signaturePad.toDataURL();
                document.getElementById('tandaTanganInput').value = dataURL;
            });

            // reset ttd
            document.getElementById('resetSignature').addEventListener('click', function(e) {
                e.preventDefault();
                signaturePad.clear();
            });
        });
    </script>

</body>
