@extends('layouts.app')

@section('content')
    <div>
        <div class="col-md-12">

        </div>

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
                                        data-bs-toggle="modal" data-bs-target="#tambahFasilitas">Tambah Fasilitas</button>

                                </div>
                            </div>

                            <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100"
                                style="margin-top: 20px;"> <!-- Margin top untuk table -->
                                <thead>
                                    <tr>
                                        <th width="8%">NO</th>
                                        <th>Nama</th>
                                        <th width="10%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($fasilitas as $f)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $f->nama }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-warning editFasilitas"
                                                    data-id="{{ $f->id }}">Edit</a>
                                                <a class="btn btn-sm btn-danger hapusFasilitas "
                                                    data-id="{{ $f->id }}">Hapus</a>
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
    <!-- Tambah Fasilitas -->
    <div class="modal fade" id="tambahFasilitas" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Tambah Fasilitas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route('simpanFasilitas') }}" onkeydown="return event.key != 'Enter';">

                        @csrf

                        <div class="form-group">

                            <label>Nama Fasilitas</label>
                            <input type="text" name="nama" class="form-control" required>
                            <!-- ganti name menjadi sesuai degnan yang ada di database -->

                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button> -->
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light"
                                value="Simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Edit fasilitas -->

    <div class="modal fade" id="modal_editFasilitas12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel-1">Edit Fasilitas</h4>
                </div>
                <div class="modal-body">

                    <form method="post" action="{{ route('updateFasilitas') }}" onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input id="nama12" name="nama12" type="text" class="form-control" required>

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="idFasilitas12" id="idFasilitas12" value="">
                            <button type="button" class="btn btn-default btn-sm waves-effect waves-light"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light"
                                value="Simpan">Simpan</button>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_editFasilitas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel-1">Edit Fasilitas</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form method="post" action="{{ route('updateFasilitas') }}"
                        onkeydown="return event.key != 'Enter';">
                        @csrf
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input id="nama" name="nama" type="text" class="form-control" required>

                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="idFasilitas" id="idFasilitas" value="">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light"
                                value="Simpan">Simpan</button>

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
            $('body').on('click', '.editFasilitas', function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "{{ route('editFasilitas') }}?id=" + id,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data) {
                        $('#idFasilitas').val(data.id);
                        $('#nama').val(data.nama);
                        $('#kondisi option[value="' + data.kondisi + '"]').prop(
                            'selected', true
                        );

                        $('#modal_editFasilitas').modal('show');
                    }
                })
            })




            $("body").on("click", ".hapusFasilitas", function() {
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
                            location.href = '<?php echo 'hapusFasilitas'; ?>' + id;
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
        })
    </script>
@endsection
