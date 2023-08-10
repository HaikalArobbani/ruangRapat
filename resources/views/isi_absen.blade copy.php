@extends('layouts.second')

@section('content')

<style>
    html,
    body {
        height: 100%;
    }

    * {
        box-sizing: border-box;
    }

    .bg-image {
        background-image: url("images/background.jpg");
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }
</style>


<?php

use Carbon\Carbon;

?>
@if(session('sukses'))
<div class="alert alert-info alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> {{ session('sukses') }}

</div>
@endif

<div class="bg-image">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Pilih Rapat</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Acara</th>
                                        <th>Waktu</th>
                                        <th>Ruangan</th>
                                        <th>Opsi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = 1;
                                    @endphp
                                    @foreach($permohonan_rapat2 as $pr)

                                    <tr>
                                        <th>{{$no++}}</th>
                                        <td>{{ $pr->nama_rapat}}</td>
                                        <td>
                                            <?php
                                            Carbon::setlocale('id');
                                            // date(' l, d F Y', strtotime($pr->waktu_masuk));
                                            echo Carbon::parse($pr->tanggal_pinjam)->translatedFormat('l, d F Y') . " " . Carbon::parse($pr->waktu_masuk)->translatedFormat('H:i');
                                            ?>
                                        </td>

                                        <td>

                                            {{ $pr ->ruangRapat->nama}}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-info kode_absen" data-id="{{$pr->id}}"><i class="fas fa-key"></i>Absen</a>
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

    <!-- <div class="modal" id="modal_kodeAbsen">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="">Silahkan Isi Kode Rapat</h4>
            </div>
            <div class="modal-body">
                <h1>
                    hello world
                </h1>
            </div>
        </div>
    </div>
</div> -->

    <div class="modal fade" id="modal_kodeAbsen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="">Silahkan Isi Kode Rapat</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{ route  ('kode_isi_absen') }}" onkeydown="return event.key != 'Enter';">

                        <!--  tidak bisa mempassing js ke html -->
                        <!-- <form method="post" action="{{ route('absen')}}" onkeydown="return event.key != 'Enter';"> -->
                        @csrf
                        <!-- perlindungan CSRF sebagai fitur bawaan untuk melindungi aplikasi web dari serangan ini. -->
                        <div class="form-group">
                            <label for="">Kode rapat</label>
                            <input name="kode_absen_input" type="text" class="form-control" placeholder="Masukan Kode Rapat">
                            <!-- id tidak boleh bentrok -->
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="kode_absen" id="kode_absen" value="">
                            <!-- Menerima id_permohonan_rapat_kode -->
                            <input type="text" name="idpermohonan_rapat" id="id_permohonan_rapat_kode" value="">
                            <button type="button" class="btn btn-default btn-sm waves-effect waves-light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light" value="Simpan">Simpan</button>

                        </div>

                    </form>
                </div>
            </div>
            <!-- id tidak boleh bentrok -->
        </div>
    </div>
</div>








<script>
    //Modal Kode Absen
    $('body').on('click', '.kode_absen', function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "{{ route ('edit_isi_Permohonan')}}?id=" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#id_permohonan_rapat_kode').val(data.id);
                // mendapatkan id_permohononanrapat lalu di passing di formm modal yang memiliki id = "id_permohonan_rapat_kode
                $('#kode_absen').val(data.kode_absen);
                $('#kode_absen_url').val(data.kode_absen);
                $('#modal_kodeAbsen').modal('show');
            }
        });
    })
</script>



@endsection