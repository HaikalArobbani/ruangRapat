@extends('layouts.second')

@section('content')


<?php

use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan_Rapat;
use App\Models\PegawaiAbsen;








?>


@if(Session::has('sukses'))

<style>
    .no-click {
        pointer-events: none;
    }
</style>


<div class="alert alert-danger alert-dismissible fade in">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
    {{ Session::get('sukses') }}
</div>
@endif
<div class="col-md-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">ABSEN PESERTA RAPAT</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="{{ route('simpan_isi_absen')}}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                @csrf



                <div class="form-group">
                    <label>Nama </label>
                    <input type="text" name="PegawaiAbsen" id="PegawaiAbsen" class="kondisi form-control" required placeholder="Nama">

                    <label for="">Divisi hahah / Instansi </label>
                    <input type="text" name="divisi" id="divisi" class=" form-control" required>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                    </div>
                </div>

                <input type="hidden" value="{{$id_permohonanRapat}}" name="id_permohonanRapat">
                <div class="">
                    <button type="submit" class="btn btn-dark waves-effect waves-light">ABSEN</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
<!-- {{$id_permohonanRapat}} -->


<script>
    $(document).ready(function() {

        $('#PegawaiAbsen').select2;


        $('#PegawaiAbsen').on('change', function() {
            var idPegawai = $(this).val();
            console.log(idPegawai); // Tambahkan pernyataan console.log di sini

            $.ajax({

                url: "jsonAbsen?id=" + idPegawai,
                // url: "jsonAbsen?id=" + idPegawai, - Menentukan URL yang akan diminta dengan menambahkan parameter "id" yang berisi nilai idPegawai.
                type: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    // Mengubah opsi dalam elemen dengan ID "divisi"
                    // yang memiliki nilai yang sesuai dengan data.divisi_id menjadi terpilih dan memicu event 'change'.
                    $('#divisi option[value="' + data.divisi_id + '"]').prop('selected', true).trigger('change');
                    $('#jabatan option[value="' + data.jabatan + '"]').prop('selected', true).trigger('change');


                }

            });
        });

    })
</script>