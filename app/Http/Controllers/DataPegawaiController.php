<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PegawaiAbsen;
use App\Models\Divisi;
use App\Models\Permohonan_Rapat;
use Carbon\Carbon;
use App\Models\Absen;
use App\Models\RuangRapat;
use App\Models\Pegawai;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\DB;






class DataPegawaiController extends Controller
{
    public function dataPegawai()
    {
        $pegawai = PegawaiAbsen::all();
        $divisi = Divisi::all();
        return view('dataPegawai', ['pegawai' => $pegawai, 'divisi' => $divisi]);
    }

    public function tambahPegawai(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:200',
            'divisi_id' => 'required',
            'jabatan' => 'required',
        ]);

        $data = array(
            'nama' => $validatedData['nama'],
            'divisi_id' => $validatedData['divisi_id'],
            'jabatan' => $validatedData['jabatan'],
        );
        $simpan = DB::table('pegawai_absen')->insert($data);
        return redirect('dataPegawai')->with("sukses", "Pegawai berhasil  di tambah");
    }

    public function hapusDataPegawai($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('pegawai_absen')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('/dataPegawai')->with("Berhasil di hapus");
    }

    public function editDataPegawai(Request $request)
    {
        $id = $request->input('id');
        //Baris kedua mengambil nilai "id" yang dikirim dari metode HTTP Request menggunakan method "input" dari objek $request, lalu nilai tersebut disimpan dalam variabel $id.

        $pegawai = PegawaiAbsen::find($id);
        //Baris ketiga melakukan pencarian data pegawai berdasarkan nilai $id menggunakan metode "find()" dari model Pegawai. Data pegawai yang ditemukan akan disimpan dalam variabel $pegawai.

        return response()->json($pegawai);
    }
    public function updateDataPegawai(Request $request)
    {
        $validatedData = $request->validate([
            // 'id_induk' => 'required',
            // 'nama' => 'required|max:200',
            // 'divisi' => 'required',
            // 'jabatan' => 'required',
            // 'lampiran' => 'required|10x10'
        ]);

        $data = array(
            'nama' => $request['nama'],
            'divisi_id' => $request['divisi_id'],
            'jabatan' => $request['jabatan'],


        );

        $simpan = DB::table('pegawai_absen')->where('id', "=", $request->post('idPegawaiedit'))->update($data);
        return redirect('dataPegawai')->with("sukses", "Data Pegawai Berhasil  di ubah");
    }

    public function isi_absen()
    {
        $permohonan_rapat = Permohonan_Rapat::where('status', 1)->orderBy('id', 'desc')->get(); //status
        $permohonan_rapat2 = Permohonan_Rapat::where('status', 2)->get(); //status
        $permohonan_rapat3 = Permohonan_Rapat::where('status', 3)->get(); //status
        $permohonan_rapat4 = Permohonan_Rapat::where('status', 4)->get(); //status

        $jumlah_ditolak = count($permohonan_rapat3); // Hitung jumlah permohonan_rapat3 yang ada



        $divisi = Divisi::all();
        $pegawai = Pegawai::all();
        $fasilitas = Fasilitas::all();
        $ruangRapat = RuangRapat::all();
        $id_permohonan_rapat = Absen::all();

        // $rekapAbsen = Absen::where('id_permohonan_rapat', $id_permohonan_rapat)->get();
        //filter untuk menampilkan ruangrapat yang memiliki status  

        // $testing = Permohonan_Rapat::get()->load('pegawai')


        return view('isi_absen', ['permohonan_rapat' => $permohonan_rapat, 'pegawai' => $pegawai, 'fasilitas' => $fasilitas, 'ruangRapat' => $ruangRapat, 'divisi' => $divisi, 'permohonan_rapat2' => $permohonan_rapat2, 'permohonan_rapat3' => $permohonan_rapat3, 'permohonan_rapat4' => $permohonan_rapat4,]);

        // return view('permohonan_rapat', ['permohonan_rapat' => $permohonan_rapat, 'pegawai' => $pegawai, 'fasilitas' => $fasilitas, 'ruangRapat' => $ruangRapat, 'divisi' => $divisi, 'permohonan_rapat2' => $permohonan_rapat2, 'permohonan_rapat3' => $permohonan_rapat3, 'permohonan_rapat4' => $permohonan_rapat4, 'rekapAbsen' => $rekapAbsen]);
    }

    //absen

    public function simpan_isi_absen(Request $request)
    {
        $timezone = 'Asia/Jakarta';
        $carbon = Carbon::now($timezone);
        $id = $request->post('id_permohonanRapat');
        $permohonanRapat = Permohonan_Rapat::find($id);
        $waktuMasuk = $permohonanRapat->waktu_masuk;
        $waktuKeluar = $permohonanRapat->waktu_keluar;

        // $tglkeluarDateTime = new DateTime($waktuKeluar);
        // $jadwal = new DatePeriod(
        //     new DateTime($waktuMasuk),
        //     new DateInterval('P1D'),
        //     $tglkeluarDateTime
        // );

        $selisihHari = Carbon::parse($waktuMasuk)->diffInDays($carbon);


        // $tglMasukKeluar = [];
        // foreach ($jadwal as $j => $ji) {
        //     $val1 = $ji->format('Y-m-d');
        //     $selisih = $carbon->diffInDays(Carbon::parse($val1));
        //     if ($val1 == $carbon->format('Y-m-d')) {
        //         $insert = +1;
        //     } elseif ($carbon > $val1) {
        //         $insert = $selisihHari;
        //     } else {
        //         $insert = "kosong";
        //     }
        //     $tglMasukKeluar[] = $val1;
        // }


        // dd($waktuMasuk);


        // dd($carbon);

        $idDivisi = PegawaiAbsen::where('id', $request->post('PegawaiAbsen'))->value('divisi_id');

        $simpan = new Absen;
        // $simpan = new RuangRapat; adalah baris kode yang digunakan untuk membuat objek baru dari model RuangRapat. Model adalah sebuah file yang berfungsi sebagai representation dari sebuah tabel pada database.

        $simpan->nama = $request->post('PegawaiAbsen');
        $simpan->tamu = $request->post('tamu');
        $simpan->id_permohonan_rapat = $request->post('id_permohonanRapat');
        if ($idDivisi == 0) {
            $simpan->divisi = $request->post('divisi');
        } else {
            $simpan->divisi = $idDivisi;
        }

        // dd($idDivisi);
        $simpan->jabatan = $request->post('jabatan');
        // $simpan->hari = $insert;
        // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
        $simpan->save();
        $divisi = $request->input('divisi_hidden');


        $request->session()->flash('sukses', 'Absen Berhasil');

        return redirect('isi_absen');
    }

    //Kode Absen
    public function kode_isi_absen(Request $request)
    {
        $kode_absen_input = $request->input('kode_absen_input');
        $kode_absen = $request->input('kode_absen');
        // $kode_absen_url = $request->input('kode_absen');
        $id_permohonanRapat = $request->input('idpermohonan_rapat');
        //ambil inputan idpermohonan_rapat dari form lalu di pasing ke variable id_permohonanRapat
        $PegawaiAbsen = PegawaiAbsen::all();

        $permohonan_rapat = Permohonan_Rapat::where('status', 1)->get(); //status
        $permohonan_rapat2 = Permohonan_Rapat::where('status', 2)->get(); //status
        $permohonan_rapat3 = Permohonan_Rapat::where('status', 3)->get(); //status
        $permohonan_rapat4 = Permohonan_Rapat::where('status', 4)->get(); //status
        $pegawai = Pegawai::all();
        $fasilitas = Fasilitas::all();
        $ruangRapat = RuangRapat::all();
        $divisi = Divisi::all();
        $namaPegawai = PegawaiAbsen::all();
        // $kode_absen_url = Permohonan_Rapat::find($kode_absen);

        // dd($id_permohonanRapat);




        //filter untuk menampilkan ruangrapat yang memiliki status  

        // $testing = Permohonan_Rapat::get()->load('pegawai')

        // dd($kode_absen);
        if ($kode_absen == $kode_absen_input) {
            return view('absen_isi', ['id_permohonanRapat' => $id_permohonanRapat, 'divisi' => $divisi, 'PegawaiAbsen' => $PegawaiAbsen],)->with("sukses", "Silahkan isi Absen");
        } else {
            session()->flash('gagal', 'kode Rapat untuk absen salah, silahkan minta ketua rapat untuk kode yang benar');
            return view('isi_absen', ['permohonan_rapat' => $permohonan_rapat, 'pegawai' => $pegawai, 'fasilitas' => $fasilitas, 'ruangRapat' => $ruangRapat, 'permohonan_rapat2' => $permohonan_rapat2, 'permohonan_rapat3' => $permohonan_rapat3, 'permohonan_rapat4' => $permohonan_rapat4, 'divisi' => $divisi], ['sukses' => 'kode']);
        }
    }

    public function edit_isi_Permohonan(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        // return response()->json($data);
        // Kembalikan hasilnya sebagai respons JSON
        return response()->json($data);
    }
}
