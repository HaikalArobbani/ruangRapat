@extends('layouts.app')

@section('content')
    <?php
    
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Auth;
    
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
                                <table id="alternative-page-datatable"
                                    class="table table-striped dt-responsive nowrap w-100" style="margin-top: 20px;">
                                    <h3>Info Kegiatan</h3>
                                    <tbody>
                                        <tr>
                                            <td>{{ $rekapAbsen->first()->permohonanRapat->nama_rapat ?? 'Nama rapat tidak tersedia' }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($rekapAbsen->first()->tanggal_pinjam)->locale('id_ID')->isoFormat('dddd, D MMMM HH:mm') }}
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                            {{-- Tabel --}}

                            <table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100"
                                style="margin-top: 20px;">
                                <thead>
                                    <tr>
                                        <th width="4%">NO</th>
                                        <th>Namsdaa Peserta</th>
                                        <th>Waktu Absen</th>
                                        <th>Tanda Tangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($rekapAbsen as $r)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $r->pegawai_absen->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($r->updated_at)->locale('id_ID')->isoFormat('dddd, D MMMM HH:mm') }}
                                            </td>
                                            <td>
                                                @if ($r->ttd_absen)
                                                    <img src="{{ asset('images/ttd/' . $r->ttd_absen) }}" alt="Tanda Tangan"
                                                        style="max-width: 100px;">
                                                @else
                                                @endif
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
@endsection
