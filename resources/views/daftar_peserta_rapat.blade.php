@extends('layouts.app')

@section('content')
    <?php
    
    use Illuminate\Support\Facades\Auth;
    
    $roleDivisi = Auth::user()->divisiRapat;
    // $userhalo = Auth::user()->email;
    
    // dd($roleDivisi);
    ?>

    <div>
        <div>
            @if (Session::has('sukses'))
                <br>
                <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                    <strong>{{ Session::get('sukses') }} </strong>
                </div>
            @endif
            <div class="row" style="margin-top: 20px;">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="panel panel-primary">

                            </div>

                            <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100"
                                style="margin-top: 20px;">
                                <thead>
                                    <tr>
                                        <th width="4%">NO</th>
                                        <th>Nama Peserta</th>
                                        {{-- <th>Tanda tangan</th> --}}
                                        <th width="10%">Absen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp

                                    @foreach ($rapatPeserta as $rp)
                                        @php
                                            $tanggalPinjam = \Carbon\Carbon::parse($rp->permohonanRapat->tanggal_pinjam);
                                            $today = \Carbon\Carbon::now();
                                            // dd($today);

                                            $showButton = $tanggalPinjam->isPast() || $tanggalPinjam->isToday();
                                            // dd($showButton);
                                        @endphp
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $rp->pegawai_absen->nama }}</td>

                                            {{-- <td>
                                                <img src="{{ asset('images/ttd/' . $p->ttd_absen) }}" alt="Tanda Tangan"
                                                    style="max-width: 100px;">

                                            </td> --}}
                                            <td>
                                                <center>
                                                    @if (is_null($rp->absen))
                                                        <a data-id="{{ $rp->id }}"
                                                            class="btn btn-warning absenRuangan"
                                                            href="/absen_rapat{{ $rp->id }}">Absen</a>
                                                    @endif
                                                    <a data-id="{{ $rp->id }}"
                                                        class="btn-small btn-warning rekapAbsen"
                                                        href="/rekapAbsen{{ $rp->id_permohonan_rapat }}">Rekap Absen</a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script>
        $(document).ready(function() {
            
            // editRuangan
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
                        $("#id_pegawai").val(data.id_pegawai).trigger("change");

                        // Set selected untuk fasilitas (multi-select)
                        $("#edit-fasilitas_baru").val(data.id_fasilitas_baru).trigger("change");

                        // Menampilkan modal
                        $("#modal_editruangan").modal("show");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    },
                });
            });

            $("body").on("click", ".hapusRuangan", function() {
                var id = $(this).attr("data-id");

                Swal.fire({
                    title: "Yakin ingin hapus?",
                    text: "Anda tidak bisa mengembalikan data ini!!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!",
                    preConfirm: function() {
                        return new Promise(function(resolve) {
                            location.href = '<?php echo 'hapusRuangan'; ?>' + id;
                            resolve();
                        });
                    },
                }).then(function(result) {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success",
                        });
                    }
                });
            });
        });
    </script> --}}
@endsection
