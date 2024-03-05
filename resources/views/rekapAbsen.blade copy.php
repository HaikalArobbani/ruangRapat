@extends('layouts.app')

@section('content')
<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

$roletamu = Auth::user()->role;

?>
<div class="row">
    <div class="col-md-12">

    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>Rekap Rapat</h4>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div>
                                                <a href="{{ url('/pdf_rapat' . $id) }}" class="btn btn-sm btn-success " data-id=""> <i class="fa fa-print"></i>
                                                    PDF </a>
                                            </div>


                                            <table id="datatable" class="table table-striped table-bordered">
                                                @if(Session::has('sukses'))
                                                <div class="alert alert-danger alert-dismissible fade in">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    {{ Session::get('sukses') }}
                                                </div>
                                                @endif
                                                <thead>
                                                    <tr>
                                                        <th width="5%">NO</th>
                                                        <th width>Nama</th>
                                                        <th width=>Divisi / Instansi</th>
                                                        <th width=>Jabatan</th>
                                                        <th width="20%">Waktu Absen</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $no = 1;
                                                    @endphp
                                                    @foreach($rekapAbsen as $ra)
                                                    <tr>
                                                        <td>{{ $no++ }}</td>
                                                        <td>
                                                            @if($ra->tamu == 1)
                                                            {{ $ra->nama }}
                                                            @else
                                                            {{ $ra->rekapAbsen->nama }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($ra->tamu == 1)
                                                            {{$ra->divisi}}
                                                            @else
                                                            {{$ra->divisiAbsen->nama}}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $ra->jabatan }}

                                                        </td>


                                                        <td>
                                                            <?php
                                                            Carbon::setlocale('id');
                                                            echo Carbon::parse($ra->created_at)->translatedFormat('l, d F Y H:i');
                                                            ?>
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection