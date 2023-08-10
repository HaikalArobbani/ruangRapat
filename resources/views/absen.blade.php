@extends('layouts.app')

@section('content')
<?php

use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;
use App\Models\Permohonan_Rapat;
use App\Models\PegawaiAbsen;



$divisiRapat = Auth::user()->divisiRapat;
$divisiPegawai = PegawaiAbsen::all();
$roleTamu = Auth::user()->role;





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
            <form method="post" action="{{ route('simpanAbsen')}}" enctype="multipart/form-data" onkeydown="return event.key != 'Enter';">
                @csrf

                @if ($roleTamu == 4)
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="PegawaiAbsen" id="" class="kondisi form-control" required placeholder="Nama" value="">

                    <label>Instansi\Divisi</label>
                    <input type="text" name="divisi" id="" class=" form-control" required placeholder="Instansi" value="">

                    <label>Jabatan</label>
                    <input type="text" name="jabatan" id="" class=" form-control" required placeholder="jabatan" value="">


                </div>

                <div class="form-group">

                    <input type="text" name="tamu" id="" class=" form-control" required placeholder="tamu" value="1">
                </div>


                @else

                <div class="no-click">
                    <label for="">Divisi</label>
                    <select name="divisi" id="divisi" class="form-control " required>

                        <option>Select Item</option>

                        @foreach ($divisi as $d)
                        <!-- Memanggil nilai value divisi rapat agar sesuai dengan id dari divisi -->
                        <option value="{{ $d->id }}" {{ ( $d->id == $divisiRapat) ? 'selected' : '' }}> {{ $d->nama }}
                            <!-- Default value select sesuai dengan id id divisi -->
                            <!-- selected, fungsi dari php -->
                            <!-- menyocokok id divisi dengan nilai di divisiRapat -->
                            <!-- tanda ? berfungsi sebagai operator tennary -->
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Nama </label>
                    <select name="PegawaiAbsen" id="PegawaiAbsen" class="form-control select2-dropdown" required>
                        <option value="">Pilih Pegawai</option>
                        @foreach($PegawaiAbsen as $pa)
                        @if($pa->divisi_id == $divisiRapat)
                        <option value="{{$pa->id}}">{{$pa->nama}}</option>
                        @endif
                        @endforeach

                    </select>
                    <div class="form-group">
                        @if($roleTamu < 4 ) <label>Jabatan</label>
                            <select name="jabatan" id="jabatan" class="form-control" required>
                                <option value="">Pilih Jenis</option>
                                <?php
                                $jabatanAbsen = array(); // Array untuk melacak jabatan yang sudah digunakan
                                ?>
                                @foreach($PegawaiAbsen as $pa)
                                <?php
                                if (!in_array($pa->jabatan, $jabatanAbsen)) {
                                    // Jika jabatan belum digunakan sebelumnya, tampilkan dalam opsi
                                    $jabatanAbsen[] = $pa->jabatan; // Tambahkan jabatan ke dalam array yang sudah digunakan
                                ?>
                                    <option value="{{$pa->jabatan}}">{{$pa->jabatan}}</option>
                                <?php
                                }
                                ?>
                                @endforeach
                            </select>
                            @else
                            @endif
                    </div>
                </div>
                @endif
                <input type="hidden" value="{{$id_permohonanRapat}}" name="id_permohonanRapat">
                <div class="">
                    <button type="submit" class="btn btn-dark waves-effect waves-light">ABSEN</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- {{$id_permohonanRapat}} -->

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
                    pegawaiSelect.append('<option value="">Pilih Pegawai</option>'); // Menambahkan opsi default

                    // Menambahkan opsi untuk pegawai dengan divisi yang dipilih
                    data.forEach(function(pegawai) {
                        pegawaiSelect.append('<option value="' + pegawai.id + '">' + pegawai.nama + '</option>');
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