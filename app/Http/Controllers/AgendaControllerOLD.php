<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan_Rapat;
use App\Models\RuangRapat;
use App\Models\Pengajuan_rapat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class AgendaController extends Controller
{
    public function agenda()
    {
        
        $ruangRapat = RuangRapat::all();
        $rapatToday = Permohonan_Rapat::where('status', 'diterima')->whereDate('tanggal_pinjam', now())->get();
        $countRapatToday = count($rapatToday);

        $rapatUpcoming = Permohonan_Rapat::where('status', 'diterima')->whereDate('tanggal_pinjam', now()->addDay()->toDateString())
            ->orderBy('tanggal_pinjam')
            ->get();
        $countUpcoming = count($rapatUpcoming);

        $rapatOther = Permohonan_Rapat::where('status', 'diterima')->whereDate('tanggal_pinjam', '>', now()->addDay()->toDateString())
            ->orderBy('tanggal_pinjam')
            ->get();
        $countrapatOther = count($rapatOther);

        $agenda = Permohonan_Rapat::all();
        return view('agenda', compact('agenda', 'ruangRapat', 'rapatToday', 'rapatUpcoming', 'rapatOther', 'countRapatToday', 'countUpcoming', 'countrapatOther'));
    }

    public function getAgendaJson(){
        $rapatToday = Permohonan_Rapat::with(['divisi', 'ruangrapat', 'pegawai_absen'])->where('status', 'diterima')->whereDate('tanggal_pinjam', now())->get();
        $rapatUpcoming = Permohonan_Rapat::with(['divisi', 'ruangrapat', 'pegawai_absen'])->where('status', 'diterima')->whereDate('tanggal_pinjam', now()->addDay()->toDateString())
            ->orderBy('tanggal_pinjam')
            ->get();
        $rapatOther = Permohonan_Rapat::with(['divisi', 'ruangrapat', 'pegawai_absen'])->where('status', 'diterima')->whereDate('tanggal_pinjam', '>', now()->addDay()->toDateString())
            ->orderBy('tanggal_pinjam')
            ->get();
        return response()->json(['today' => $rapatToday, 'upcoming' => $rapatUpcoming, 'other'=> $rapatOther]);
    }

    public function konfirmasiAjuan(Request $request)
    {
        $idAjuan = $request->input('idAjuan');
        $permohonan_rapat = Permohonan_Rapat::with(['divisi', 'ruangrapat', 'pegawai_absen'])->where('id_ajuan', $idAjuan)->first();
        return response()->json(['data' => $permohonan_rapat]);
    }

    public function konfirmasiTerimaAksi(Request $request){
        $ruang = $request->input('tambahRuangKonfirmasi');
        $idAjuan = $request->input('tambahIdAjuan');


        //=================================
        $data = array(
            'id_ruangrapat' => $ruang,
            'status' => 'diterima',
        );
        DB::table('permohonan_rapat')->where('id_ajuan', $idAjuan)->update($data);
        //=================================

        //=================================
        $pengajuan = Pengajuan_rapat::find($idAjuan);
        $pengajuan->status = 'diterima';
        $pengajuan->save();
        //=================================

        return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan.']);

    }

    public function konfirmasiTolakAksi(Request $request)
    {
        $ruang = $request->input('tambahRuangKonfirmasi');
        $idAjuan = $request->input('tambahIdAjuan');

        //=================================
        $data = array(
            'status' => 'ditolak',
        );
        DB::table('permohonan_rapat')->where('id_ajuan', $idAjuan)->update($data);
        //=================================

        //=================================
        $pengajuan = Pengajuan_rapat::find($idAjuan);
        $pengajuan->status = 'ditolak';
        $pengajuan->save();
        //=================================
        return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan.']);

    }

}
