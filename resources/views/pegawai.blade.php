@extends('layouts.app')

@section('content')
    <div class="col-md-12">
        <!-- Kosong, bisa diisi konten lain jika diperlukan -->
    </div>

    @if (Session::has('sukses'))
        <br>
        <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong>{{ Session::get('sukses') }}</strong>
        </div>
    @endif

    <div class="row" style="margin-top: 20px;">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="margin-bottom: 20px;">
                            <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal"
                                data-bs-target="#tambahAdmin">Tambah Admin</button>
                        </div>
                    </div>

                    <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100"
                        style="margin-top: 20px;">
                        <thead>
                            <tr>
                                <th width="5%">NO</th>
                                <th width>Nama</th>
                                <th width="10%">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @foreach ($pegawai as $p)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-warning editPegawai" data-id="{{ $p->id }}">Edit</a>
                                        <a class="btn btn-sm btn-danger hapusPegawai"
                                            data-id="{{ $p->id }}">Hapus</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_lampiranPegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="lampiran"></h4>
                </div>
                <div class="modal-body">
                    <div id="testing" class="form-group"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- Tambah Admin --}}
    <div class="modal fade" id="tambahAdmin" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Tambah Admin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('simpanPegawai') }}" enctype="multipart/form-data"
                        onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="form-group">
                            <label>Nama Admin</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light"
                                value="Simpan">Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Edit Admin --}}
    <div class="modal fade" id="modal_editPegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel-1">Edit Admin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('updatePegawai') }}" enctype="multipart/form-data"
                        onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="form-group">
                            <label>Nama Admin</label>
                            <input id="nama" type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="idPegawaiedit" id="idPegawaiedit" value="" required>
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light"
                                value="Simpan">Simpan
                            </button>
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
            //Edit Pegawai
            $('body').on('click', '.editPegawai', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('editPegawai') }}?id=" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    //dari js ambil id 
                    {
                        $('#idPegawaiedit').val(data.id);
                        $('#no_induk').val(data.no_induk);
                        $('#nama').val(data.nama);
                        $('#divisi').val(data.divisi);
                        $('#divisi_edit option[value="' + data.divisi + '"]').prop(
                            'selected', true);
                        $('#jabatan option[value="' + data.jabatan + '"]').prop(
                            'selected', true
                        );
                        var filename = data.lampiran;
                        var object =
                            "<object data=\"lampiran/{FileName}\"  width=\"100px\" height=\"100px\">";
                        object += "</object>";
                        object = object.replace(/{FileName}/g, "/" + filename);
                        $('#testing2').html(object);
                        //nama id tidak boleh samaa


                        $('#modal_editPegawai').modal('show');



                    }
                })
            })




            //Hapus  Pegawai
            $("body").on("click", ".hapusPegawai", function() {
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
                            location.href = '<?php echo 'hapusPegawai'; ?>' + id;
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

            //lampiran Pegawai
            $('body').on('click', '.lampiranPegawai', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('lampiranPegawai') }}?id=" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        //  Syntax success:function(data) di atas digunakan sebagai callback function atau fungsi yang akan dieksekusi setelah request Ajax berhasil dilakukan dan mereturn data dalam format JSON dari server. 
                        //Parameter data dalam fungsi success ini akan memuat data yang diterima dari server, yang dalam kasus ini berisi objek yang berisi data pegawai yang dipilih beserta data lampiran-nya.

                        $('#idPegawai').val(data.id);
                        var filename = data.lampiran;
                        var object =
                            "<object data=\"lampiran/{FileName}\" type=\"application/pdf\" width=\"800px\" height=\"700px\">";
                        //"<object data=\"lampiran/{FileName}\": Mendefinisikan object dengan atribut data yang mengarahkan ke file yang akan ditampilkan. lampiran pada syntax ini adalah direktori yang berisi file-file lampiran, sedangkan {FileName} adalah variabel yang akan diganti dengan nama file yang diperoleh dari response data.
                        // type=\"application/pdf\": Atribut type mendefinisikan tipe konten file yang akan ditampilkan, pada kasus ini adalah file pdf.


                        object += "</object>";
                        //Kode tersebut menambahkan tag penutup </object> ke dalam variabel object yang sebelumnya telah diberi nilai tag pembuka <object>.
                        object = object.replace(/{FileName}/g, "/" + filename);
                        $('#testing').html(object);
                        //nama id dari si object nantinya di tarik di id form
                        $('#lampiran').html(data.lampiran);



                        // console.log(data.lampiran);

                        $('#modal_lampiranPegawai').modal('show');


                    }
                })
            })
        })
    </script>
@endsection


<!-- kode diatas adalah sebuah perulangan foreach yang akan menampilkan data dari objek $ruangRapat yang diterima dari controller.  -->
<!--data-id berfungsi utnuk simpan id dari setiap id di database -->
