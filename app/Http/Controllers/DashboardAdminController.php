<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas_Baru;
use App\Models\Pegawai;
use App\Models\Permohonan_Rapat;
use App\Models\RuangRapat;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use App\Models\Divisi;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public function TampilAdmin(Request $request)
    {
        $id = ('id');
        $data = Pegawai::with('divisiModel')->get();
        return response()->json($data);
        dd($data);
    }

    public function rapatDiajukan(Request $request)
    {

        $adminRuangan = Auth::user()->adminRuangan;
        if ($adminRuangan > 0) {
            $data1 =  Permohonan_Rapat::where('status', 1)->where('id_ruangrapat', Auth::user()->adminRuangan)->with('divisi')->get();
        } else {
            $data1 =  Permohonan_Rapat::where('status', 1)->with('divisi')->get();
        }
        return response()->json(($data1));
    }
    public function rapatDiterima(Request $request)
    {


        $adminRuangan = Auth::user()->adminRuangan;
        if ($adminRuangan > 0) {
            $data1 =  Permohonan_Rapat::where('status', 2)->where('id_ruangrapat', Auth::user()->adminRuangan)->with('divisi')->get();
        } else {
            $data1 =  Permohonan_Rapat::where('status', 2)->with('divisi')->get();
        }
        return response()->json($data1);
    }

    public function ruangan_dibooking(Request $request)
    {

        RuangRapat::all();
        $data1 = Permohonan_Rapat::where('status', 1)->whereDate('waktu_masuk', Carbon::now())->with('ruangrapat')->get();
        return response()->json($data1);
        // dd($data1);

    }
}
