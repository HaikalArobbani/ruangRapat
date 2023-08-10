<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PegawaiAbsen;
use App\Models\Divisi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DivisiController extends Controller
{
    ///divisi
    public function divisi()
    {
        $divisi = DB::table('divisi')->get();
        return view('divisi', ['divisi' => $divisi]);
    }

    //Tambah Divisi
    public function simpanDivisi(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required|unique:divisi,nama',
        ]);

        $simpan = DB::table('divisi')->insert([
            'nama' => $validatedData['nama'],
        ]);

        return redirect('divisi')->with("sukses", "Divisi berhasil di tambah");
    }

    // Edit Divisi


    public function editDivisi(Request $request)
    {
        $id = $request->input('id');
        $divisi = Divisi::find($id);
        return response()->json($divisi);
    }

    public function updateDivisi(Request $request)
    {
        $data = array(
            'nama' => $request->post('nama_divisi'),
            //nama di database                 //nama di form

        );
        // dd($request->post('idKendaraan'));
        $simpan = DB::table('divisi')->where('id', "=", $request->post('iddivisi'))->update($data);
        return redirect('divisi')->with("sukses", "Data Divisi berhasil di ubah");
        // dd($simpan);
    }
    //hapus DIvisi
    public function hapusDivisi($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('divisi')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('divisi')->with("Berhasil di hapus");
    }
}
