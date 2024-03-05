<?php


namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\Permohonan_Rapat;
use Carbon\Carbon;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function riwayat(Request $request)
    {
        // $riwayat = Permohonan_Rapat::orderBy('id', 'DESC');
        
        $riwayat = Permohonan_Rapat::withCount('pesertaRapat')->orderBy('id', 'DESC');

        if ($request->has('bulan')) {
            $bulan = Carbon::parse($request->bulan)->format('m');
            $riwayat->whereMonth('tanggal_pinjam', $bulan);
        }

        $riwayat = $riwayat->get();

        return view('riwayat', compact('riwayat'));
    }
}
