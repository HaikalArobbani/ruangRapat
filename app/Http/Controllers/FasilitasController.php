<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fasilitas_Baru;
use Illuminate\Support\Facades\DB;


class FasilitasController extends Controller
{
    public function index()
    {
        # code
        $fasilitas_baru = DB::table('fasilitas_baru')->get();
        return view('fasilitas_baru', ['fasilitas_baru' => $fasilitas_baru]);
    }

    public function simpanFasilitas_baru(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|unique:fasilitas,nama',
        ]);

        $simpan = DB::table('fasilitas_baru')->insert([
            'nama' => $validatedData['nama'],
        ]);

        return redirect('fasilitas_baru')->with("sukses", "Fasilitas berhasil di tambah");
    }

    public function editFasilitasBaru(Request $request)
    {
        $id = $request->input('id');
        $fasilitas = Fasilitas_Baru::find($id);
        return response()->json($fasilitas);
    }

    public function updateFasilitasBaru(Request $request)
    {
        $data = array(
            'nama' => $request->post('nama'),
            //nama di database                 //nama di form

        );
        // dd($request->post('idKendaraan'));
        $simpan = DB::table('fasilitas_baru')->where('id', "=", $request->post('idFasilitas'))->update($data);
        return redirect('fasilitas_baru')->with("sukses", "Data Fasilitas berhasil di ubah");
    }


    //hapus Fasilitas
    public function hapusBaru($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('fasilitas_baru')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        // dd($id);
        return redirect('fasilitas_baru')->with("Berhasil di hapus");
    }
}
