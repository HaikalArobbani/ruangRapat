<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\RuangRapat;
use App\Models\Fasilitas_Baru;
use App\Models\Divisi;
use Carbon\Carbon;


use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    // Pegawai
    public function pegawai()
    {
        $pegawai = Pegawai::all();
        $divisi = Divisi::all();
        return view('pegawai', ['pegawai' => $pegawai, 'divisi' => $divisi]);
    }

    // Tambah Pegawai
    public function simpanPegawai(Request $request)
    {

        $validatedData = $request->validate([
            'nama' => 'required|max:200',
        ]);

        $data = array(
            'nama' => $validatedData['nama'],
            'updated_at' => Carbon::now(),
        );



        $simpan = DB::table('pegawai')->insert($data);
        return redirect('pegawai')->with("sukses", "Admin berhasil  di tambah");
    }

    //Modal lampiran Pegawai
    public function lampiranPegawai(Request $request)
    {
        $id = $request->input('id'); //ID dari button
        $data = Pegawai::find($id);
        //ambil data dari table pegawai- dan menemukan id yang sama yang sudah di pasing dari id di button
        return response()->json($data);
        // data di kembalikan dalam format json. yang berada dalam javascript
    }

    //Edit Pegawai
    public function editPegawai(Request $request)  //objek request sebagai parameter
    //request digunakan untuk mengambil data dari permintaan yang dikirm oleh aplikasi
    {
        $id = $request->input('id');
        //Baris kedua mengambil nilai "id" yang dikirim dari metode HTTP Request menggunakan method "input" dari objek $request, lalu nilai tersebut disimpan dalam variabel $id.

        $pegawai = Pegawai::find($id);
        //Baris ketiga melakukan pencarian data pegawai berdasarkan nilai $id menggunakan metode "find()" dari model Pegawai. Data pegawai yang ditemukan akan disimpan dalam variabel $pegawai.



        return response()->json($pegawai);
        //Baris terakhir mengembalikan data pegawai dalam format JSON sebagai respon dari HTTP Request menggunakan method "json()" dari objek "response()". Data pegawai akan dikirim ke pengguna melalui HTTP Response.

    }

    public function updatePegawai(Request $request)
    {
        // dd($request->post('nama'));
        // dd($request->post('idPegawaiedit'));
        if ($request->hasFile('new_lampiran')) {
            $fileLampiran = $request->file('new_lampiran');
            $namafileLampiran = 'lampiran -' . time() . '-' . $fileLampiran->getClientOriginalName();
            $tujuanUpload = 'lampiran';
            $fileLampiran->move($tujuanUpload, $namafileLampiran);



            $data = array(
                'no_induk' => $request['no_induk'],
                'nama' => $request['nama'],
                'divisi' => $request['divisi_edit'],
                'jabatan' => $request['jabatan'],
                'updated_at' => Carbon::now(),
                'lampiran' => $namafileLampiran,
            );
        } else {
            $validatedData = $request->validate([
                // 'id_induk' => 'required',
                // 'nama' => 'required|max:200',
                // 'divisi' => 'required',
                // 'jabatan' => 'required',
                // 'lampiran' => 'required|10x10'
            ]);

            $data = array(
                'no_induk' => $request['no_induk'],
                'nama' => $request['nama'],
                'divisi' => $request['divisi_edit'],
                'jabatan' => $request['jabatan'],
                'lampiran' => $request['lampiran'],
                'updated_at' => Carbon::now(),
            );
        }

        // $data = array(
        //     'no_induk' => $request->post('id_induk'),
        //     //nama di database                 //nama di form
        //     'nama' => $request->post('nama'),
        //     'jabatan' => $request->post('jabatan'),
        //     'divisi' => $request->post('divisi'),

        // );
        // dd($request->post('idPegawai'));
        $simpan = DB::table('pegawai')->where('id', "=", $request->post('idPegawaiedit'))->update($data);
        return redirect('pegawai')->with("sukses", "Data Admin Berhasil  di ubah");
    }


    //Hapus Pegawai
    public function hapusPegawai($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('pegawai')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('/pegawai')->with("Berhasil di hapus");
    }

    
}
