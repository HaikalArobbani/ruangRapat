@extends('layouts.app')

@section('content')
    @if (Session::has('sukses'))
        <style>
            .no-click {
                pointer-events: none;
            }
        </style>
        <br>
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ Session::get('sukses') }} </strong>
        </div>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <br>
    <center>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">ABSEN PESERTA RAPAT</h4>
                    <form method="post" action="{{ route('update_peserta_absen') }}" enctype="multipart/form-data"
                        onkeydown="return event.key != 'Enter';">
                        @csrf

                        <div class="no-click">
                            <label>Nama Rapat</label>
                            <input type="text" name="nama_rapat" id="nama_rapat" class="kondisi form-control" required
                                readonly placeholder="Nama" value="{{ $peserta_rapat->permohonanRapat->nama_rapat }}"
                                aria-describedby="emailHelp">
                        </div>
                        @php
                            setlocale(LC_TIME, 'id_ID', 'Indonesian_Indonesia', 'Indonesian');
                        @endphp

                        <div class="no-click">
                            <label>Waktu Rapat</label>
                            <input type="text" name="waktu_rapat" id="waktu_rapat" class="kondisi form-control" required
                                readonly placeholder="Waktu Rapat"
                                value="{{ \Carbon\Carbon::parse($peserta_rapat->permohonanRapat->tanggal_pinjam)->formatLocalized('%A, %d %B %Y') }}"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
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
                        <input type="hidden" value="{{ $peserta_rapat->id }}" name="idruangRapat">
                        <br>
                        <div class="">
                            <button type="submit" class="btn btn-dark waves-effect waves-light" id="btnAbsen"
                                disabled>ABSEN</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </center>


    </div>
    {{-- <!-- {{ $id_permohonanRapat }} --> --}}
    {{-- <script>
        var waktuRapat = "{{ $permohonanRapat->tanggal_pinjam }}"
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("waktu_rapat").value = waktuRapat;
            document.getElementById("waktu_rapat").readOnly = true;
        });
    </script>
    <script>
        var namaRapat = "{{ $permohonanRapat->nama_rapat }}";
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("nama_rapat").value = namaRapat;
            document.getElementById("nama_rapat").readOnly = true;
        });
    </script> --}}

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
    <script>
        $(document).ready(function() {
            $('#PegawaiAbsen').select2();
            $('#divisi').select2();


            // Fungsi untuk mengambil daftar pegawai berdasarkan divisi yang dipilih
            function fetchEmployeesByDivision(divisionId) {
                $.ajax({
                    url: "jsonAbsen?divisi_id=" + divisionId,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data) {
                        var pegawaiSelect = $('#PegawaiAbsen');
                        pegawaiSelect.empty(); // Menghapus opsi yang ada saat ini
                        pegawaiSelect.append(
                            '<option value="">Pilih Pegawai</option>'); // Menambahkan opsi default

                        // Menambahkan opsi untuk pegawai dengan divisi yang dipilih
                        data.forEach(function(pegawai) {
                            pegawaiSelect.append('<option value="' + pegawai.id + '">' + pegawai
                                .nama + '</option>');
                        });
                    }
                });
            }

            // Menangani perubahan pada dropdown divisi
            $('#divisi').on('change', function() {
                var selectedDivision = $(this).val();

                if (selectedDivision) {
                    fetchEmployeesByDivision(selectedDivision);
                } else {
                    // Jika divisi tidak dipilih, hapus opsi pegawai dan tambahkan opsi default
                    var pegawaiSelect = $('#PegawaiAbsen');
                    pegawaiSelect.empty();
                    pegawaiSelect.append('<option value="">Pilih Pegawai</option>');
                }
            });

            // Memanggil fungsi fetchEmployeesByDivision saat halaman dimuat untuk inisialisasi opsi pegawai
            fetchEmployeesByDivision($('#divisi').val());
        });
    </script>
@endsection
