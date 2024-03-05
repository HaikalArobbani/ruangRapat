@extends('layouts.app')

@section('content')
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
            <div class="row" style="margin-top: 20px;"> <!-- Margin top untuk row -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="panel panel-primary">
                                <div class="panel-heading" style="margin-bottom: 20px;">
                                    <!-- Margin bottom untuk panel heading -->
                                    <button type="button" class="btn btn-success waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target="#tambahRuangan">Tambah Ruangan</button>

                                </div>
                            </div>

                            <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100"
                                style="margin-top: 20px;"> <!-- Margin top untuk table -->
                                <thead>
                                    <tr>
                                        <th width="4%">NO</th>
                                        <th>Nama</th>
                                        <th>Kapasistas</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Fasilitas</th>
                                        <th>Lokasi</th>
                                        <th width="10%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($ruangRapat as $r)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $r->nama }}</td>
                                            <td>{{ $r->kapasitas }}</td>
                                            <td>{{ $r->pegawai->nama }}</td>
                                            <td>{{ $r->id_fasilitas_baru }}</td>
                                            <td>{{ $r->lokasi }}</td>
                                            <td>
                                                <center>
                                                    <a class="btn  btn-warning editRuangan"
                                                        data-id="{{ $r->id }}">Edit</a>
                                                    <a class="btn  btn-danger hapusRuangan"
                                                        data-id="{{ $r->id }}">Hapus</a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div> <!-- end row-->
        </div>
    </div>
    <!-- Edit Ruang Rapat -->
    <div class="modal fade" id="modal_editruangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="">Edit Ruangan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="post" action="{{ route('updateRuangan') }}" onkeydown="return event.key != 'Enter';">
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
                        <label>Penanggung Jawab</label>
                        <select name="id_pegawai" id="id_pegawai" class="kondisi form-control" required>
                            <option value=""disabled selected>Pilih Penanggung Jawab</option>
                            @foreach ($pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        <div>
                            <label for="">Fasilitas</label>
                            <br>
                            <select class="js-edit-basic-multiple" name="fasilitas_edit_baru[]" id="edit-fasilitas_baru"
                                multiple="multiple" style="width:100%" data-toggle="select2">
                                <option value=""disabled selected>Edit fasilitas</option>
                                @foreach ($fasilitas_baru as $f)
                                    <option value="{{ $f->nama }}">{{ $f->nama }}</option>
                                @endforeach
                            </select>
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="">Lokasi</label>
                            <input id="lokasi" name="lokasi" type="text" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="idruangRapat" id="idruangRapat" value="" required>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light"
                                value="Simpan">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Tambah ruangan -->
    <div class="modal fade" id="tambahRuangan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Tambah Ruangan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('simpanRuangan') }}" onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Ruangan</label>
                            <input type="text" id="nama" name="nama" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="kapasitas">Kapasitas ruangan</label>
                            <input type="number" id="kapasitas" name="kapasitas" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="id_pegawai">Penanggung Jawab</label>
                            <select id="id_pegawai" name="id_pegawai" class="form-control" required>
                                <option value="" disabled selected>Pilih Penanggung Jawab</option>
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fasilitas_baru">Fasilitas</label>
                            <select class="select_fasilitas" id="fasilitas_baru" name="fasilitas_baru[]"
                                data-toggle="select2" multiple="multiple" style="width: 100%;"
                                placeholder="Pilih Fasilitas">
                                @foreach ($fasilitas_baru as $fb)
                                    <option value="{{ $fb->nama }}">{{ $fb->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" id="lokasi" name="lokasi" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // $('.select_fasilitas').select2({
            //     placeholder: "Pilih Fasilitas",
            //     allowClear: true
            // });
            // $('#edit-fasilitas_baru').select2();

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
    </script>
@endsection
