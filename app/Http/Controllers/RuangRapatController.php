<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\RuangRapat;
use App\Models\Fasilitas_Baru;
use Illuminate\Support\Facades\DB;



class RuangRapatController extends Controller
{
    public function ruangRapat()
    {
        //Relasi menggunakan Eloquent
        $encryptedUrl = encrypt(route('ruangRapat'));
        $ruangRapat = RuangRapat::all();
        $pegawai = Pegawai::all();
        $fasilitas_baru = Fasilitas_Baru::all();

        return view('ruangRapat', ['ruangRapat' => $ruangRapat, 'pegawai' => $pegawai, 'fasilitas_baru' => $fasilitas_baru]);
    }

    //Tambah ruangan
    public function simpanRuangan(Request $request)
    // $request adalah sebuah parameter yang bertipe Request yang berfungsi sebagai objek yang menangkap request dari form.
    {
        $fasilitas_baru = $request->post('fasilitas_baru');
        if (is_null($fasilitas_baru)) {
            $implode =
                $request->post('fasilitas_baru');
        } else {
            $implode = implode(",", $fasilitas_baru);
        }
        $simpan = new RuangRapat;
        // $simpan = new RuangRapat; adalah baris kode yang digunakan untuk membuat objek baru dari model RuangRapat. Model adalah sebuah file yang berfungsi sebagai representation dari sebuah tabel pada database.
        $simpan->nama = $request->post('nama');
        $simpan->kapasitas = $request->post('kapasitas');
        $simpan->id_pegawai = $request->post('id_pegawai');
        $simpan->id_fasilitas_baru = $implode;
        $simpan->lokasi = $request->post('lokasi');
        $simpan->status = 1;
        // dd($implode);
        // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
        $simpan->save();

        return redirect('ruangRapat')->with("sukses", "Ruangan Berhasil  Ditambah");
    }
    //Penolakan



    //edit Ruangan
    public function editRuangan(Request $request)
    {
        $id = $request->input('id');
        $data = RuangRapat::find($id);
        return response()->json($data);
    }

    public function updateRuangan(Request $request)
    {

        $fasilitas_edit_baru = $request->post('fasilitas_edit_baru');
        if (is_null($fasilitas_edit_baru)) {
            $implode = $request->post('id_fasilitas_baru');
        } else {
            $implode2 = implode(",", $fasilitas_edit_baru);
        }
        $data = array(
            'nama' => $request->post('nama'),
            //nama di database                 //nama di form
            'kapasitas' => $request->post('kapasitas'),
            'id_pegawai' => $request->post('id_pegawai'),
            'id_fasilitas_baru' => $implode2,
            'lokasi' => $request->post('lokasi'),


        );
        // dd($request->post('idKendaraan'));
        $simpan = DB::table('ruangrapat')->where('id', "=", $request->post('idruangRapat'))->update($data);
        return redirect('ruangRapat')->with("sukses", "Ruangan berhasil di ubah");
    }
    //Hapus Ruangan
    public function hapusRuangan($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('ruangrapat')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('/ruangRapat')->with("Berhasil di hapus");
    }
}
