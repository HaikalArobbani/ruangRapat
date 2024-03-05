<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\RuangRapat;
use App\Models\Fasilitas;
use App\Models\Absen;
use App\Models\Permohonan_Rapat;
use App\Models\Divisi;
use App\Models\Fasilitas_Baru;
use App\Models\Pengajuan_rapat;
use App\Models\Peserta_rapat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use PDF;
use DateInterval;
use Hamcrest\Core\HasToString;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Builder\Function_;
use PhpParser\Node\Expr\FuncCall;
use PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report\Php;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailRapat;
use App\Models\PegawaiAbsen;
use Illuminate\Support\Facades\Validator;

use App\Exports\PermohonanExport;
use App\Exports\PermohonanSelesaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\SoftDeletes;
use function GuzzleHttp\Promise\all;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['simpan_tamu_absen']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



    // home
    public function index()
    {
        $ruangan = RuangRapat::all(); // Mengambil semua data ruangan
        $fasilitas_baru = Fasilitas_Baru::all();
        return view('home', compact('ruangan', 'fasilitas_baru'));
    }

    // ruangan - home
    public function getRoomDetails($id)
{
    $ruangan = RuangRapat::find($id); // Mengambil data ruangan berdasarkan ID
    if ($ruangan) {
        return response()->json([
            'nama' => $ruangan->nama,
            'kapasitas' => $ruangan->kapasitas,
            'id_fasilitas_baru' => $ruangan->id_fasilitas_baru,
            'lokasi' => $ruangan->lokasi,
            // tambahkan properti lain jika perlu
        ]);
    } else {
        return response()->json(['error' => 'Ruangan tidak ditemukan'], 404);
    }
}

    public function status()
    {
        $countAvailableRooms = DB::table('ruang_rapat')->where('status', 'available')->count();

        return view('home', compact('countAvailableRooms'));
    }


    //Ruang Rapat

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

    // Pegawai
    public function admin()
    {
        $pegawai = Pegawai::all();
        $divisi = Divisi::all();
        return view('admin', ['pegawai' => $pegawai, 'divisi' => $divisi]);
    }

    // Tambah Pegawai
    public function simpanPegawai(Request $request)
    {
        if ($request->hasFile('lampiran'))
        //cek apakah form dengan nama lampiran mengirim file
        {

            $fileLampiran = $request->file('lampiran');
            //menyimpan data dari file ke variable $fileLampiran

            //dari form ambil nama 
            //controller ambil dari nama

            //ubah nama file tersebut menggabungkan string dan waktu dan nama asli file dengan method getclientoriginalname
            $namafileLampiran = 'lampiran -' . time() . '-' . $fileLampiran->getClientOriginalName();
            //hasil nya akan di simpan di variable $namafilelampiran

            //menentukan direktori penyimpanan file 
            $tujuanUpload = 'lampiran';
            //variable $tujuanUpload menyimpan lokasi penyimpanan file


            $fileLampiran->move($tujuanUpload, $namafileLampiran);
            //method diatas berfungsi untuk memindahkan file yg diunggah ke direktori yang sudah ditentukan dengan variable $tujuan upload


            $validatedData = $request->validate([
                // digunakan untuk melakukan validasi pada data yang dikirimkan dengan aturan yang sudah ditentukan pada parameter $request  
                'no_induk' => 'required|unique:pegawai,no_induk',
                'nama' => 'required|max:200',
                'divisi' => 'required',
                'jabatan' => 'required',
            ]);

            $data = array(
                'no_induk' => $validatedData['no_induk'],
                'nama' => $validatedData['nama'],
                'divisi' => $validatedData['divisi'],
                'jabatan' => $validatedData['jabatan'],
                'updated_at' => Carbon::now(),
                'lampiran' => $namafileLampiran,
            );

            //jika user tidak melakukan input file lampiran, maka akan menggunakan syntax menyimpan data menggunakan kode yang ada di bawah ini
        } else {
            $validatedData = $request->validate([
                'nama' => 'required|max:200',
                'divisi' => 'required',
                'jabatan' => 'required',
                'lampiran' => '|10x10'
            ]);

            $data = array(
                'no_induk' => $validatedData['no_induk'],
                'nama' => $validatedData['nama'],
                'divisi' => $validatedData['divisi'],
                'jabatan' => $validatedData['jabatan'],
                'updated_at' => Carbon::now(),
            );
        }


        $simpan = DB::table('pegawai')->insert($data);
        return redirect('pegawai')->with("sukses", "Pegawai berhasil  di tambah");
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
        return redirect('pegawai')->with("sukses", "Data Pegawai Berhasil  di ubah");
    }


    //Hapus Pegawai
    public function hapusPegawai($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('pegawai')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('/pegawai')->with("Berhasil di hapus");
    }





    //Fasilitas

    //show table
    public function fasilitas()
    {
        # code
        $fasilitas = DB::table('fasilitas')->get();
        return view('fasilitas', ['fasilitas' => $fasilitas]);
    }

    //tambah fasilitas
    public function simpanFasilitas(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|unique:fasilitas,nama',
        ]);

        $simpan = DB::table('fasilitas')->insert([
            'nama' => $validatedData['nama'],
        ]);

        return redirect('fasilitas')->with("sukses", "Fasilitas berhasil di tambah");
    }

    //edit Fasilitas


    public function editFasilitas(Request $request)
    {
        $id = $request->input('id');
        $fasilitas = Fasilitas::find($id);
        return response()->json($fasilitas);
    }

    public function updateFasilitas(Request $request)
    {
        $data = array(
            'nama' => $request->post('nama'),
            //nama di database                 //nama di form
            'kondisi' => $request->post('kondisi'),

        );
        // dd($request->post('idKendaraan'));
        $simpan = DB::table('fasilitas')->where('id', "=", $request->post('idFasilitas'))->update($data);
        return redirect('fasilitas')->with("sukses", "Data Fasilitas berhasil di ubah");
    }


    //hapus Fasilitas

    public function hapusFasilitas($id)
    {
        // menghapus data pegawai berdasarkan id yang dipilih
        DB::table('fasilitas')->where('id', $id)->delete();
        // alihkan halaman ke halaman pegawai
        return redirect('fasilitas')->with("Berhasil di hapus");
    }



    //Permohonan Rapat

    public function getEvents(Request $request)
    {
    $events = Permohonan_Rapat::with(['ruangRapat', 'divisiPermohonan'])->get();
    return response()->json($events->map(function ($event) {
        return [
            'id' => $event->id, // tanggal selesai
            'title' => $event->divisiPermohonan->nama, // nama event
            'start' => $event->tanggal_pinjam, // tanggal mulai
            'end' => $event->tanggal_selesai, // tanggal selesai
            'id_ruangrapat' => $event->id_ruangrapat, // ID ruang rapat
            'jumlah_peserta' => $event->jumlah_peserta,
            'nama_rapat' => $event->nama_rapat,
            'nama_divisi' => $event->divisiPermohonan->nama, // Asumsi relasi mengembalikan objek dengan properti 'nama'
            'nama_ruangan' => $event->ruangRapat->nama, // Asumsi relasi mengembalikan objek dengan properti 'nama'
            // Tambahkan properti lain yang dibutuhkan oleh FullCalendar
        ];
    }));
    // dd($permohonan_rapat2);
    dd($events);
    // return Response::json($events);
    }
    public function detailEvent(Request $request, $id) {
    $event = Permohonan_Rapat::with('ruanganRapat')->findOrFail($id);

    return response()->json([
        'id' => $event->id,
        'nama_rapat' => $event->nama_rapat,
        'start' => $event->tanggal_pinjam,
        'end' => $event->tanggal_selesai,
        'description' => $event->ruanganRapat->nama,
        // 'nama_ruangan' => $event->ruanganRapat->nama,
        // tambahkan properti lain yang diperlukan
    ]);
    }


    public function permohonan_rapat(Request $request)
    {
        $divisiRapat = Auth::user()->divisiRapat;
        $permohonan_rapat = Permohonan_Rapat::where('status', 1)->orderBy('id', 'desc')->get(); //status
        $permohonan_rapat2 = Permohonan_Rapat::where('status', 2)->get(); //status
        $permohonan_rapat3 = Permohonan_Rapat::where('status', 3)->get(); //status
        $permohonan_rapat4 = Permohonan_Rapat::where('status', 4)->get(); //status

        $jumlah_ditolak = count($permohonan_rapat3);

        $divisi = Divisi::all();
        $pegawai = Pegawai::all();
        $fasilitas = Fasilitas::all();
        $ruangRapat = RuangRapat::all();
        $id_permohonan_rapat = Absen::all();

        if ($divisiRapat) {
            $pegawai = PegawaiAbsen::where('divisi_id', $divisiRapat)->get();
        } else {
            $pegawai = PegawaiAbsen::all();
        }

        return view('permohonan_rapat', ['permohonan_rapat' => $permohonan_rapat, 'pegawai' => $pegawai, 'fasilitas' => $fasilitas, 'ruangRapat' => $ruangRapat, 'divisi' => $divisi, 'permohonan_rapat2' => $permohonan_rapat2, 'permohonan_rapat3' => $permohonan_rapat3, 'permohonan_rapat4' => $permohonan_rapat4,]);
    }

    public function getDivisi(Request $request)
    {
        $pemohonId = $request->input('pemohonId');
        $pegawai = PegawaiAbsen::findOrFail($pemohonId);
        $divisi = Divisi::where('id', $pegawai->divisi_id)->first();

        return response()->json(['divisi' => $divisi]);
    }

    public function getRuang(Request $request)
    {
        $ruangId = $request->input('ruangId');

        try {
            $ruang = RuangRapat::findOrFail($ruangId);
            $today = Carbon::now()->toDateString();
            $permohonan = Permohonan_Rapat::with('divisi')
                ->where('id_ruangrapat', $ruangId)
                ->where('status', 'diterima')
                ->whereDate('tanggal_pinjam', $today)
                ->get();

            return response()->json(['ruang' => $ruang, 'permohonan' => $permohonan]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data ruang tidak ditemukan.'], 404);
        }
    }

    public function getPengajuanJson()
    {
        // $dataPengajuan = Permohonan_Rapat::orderBy('id', 'desc')->get();
        $roleAdmin = Auth::user()->adminRuangan;
        if ($roleAdmin < 2)
        {
            $dataPengajuan = Permohonan_Rapat::with(['pengajuanRapat' => function ($query) use ($roleAdmin) {
                $query->where('status', 'menunggu');
            }])->whereHas('pengajuanRapat', function ($query) use ($roleAdmin) {
                $query->where('status', 'menunggu');
            })->orderBy('id', 'desc')->get();            
        } else {
            $dataPengajuan = Permohonan_Rapat::with(['pengajuanRapat' => function ($query) use ($roleAdmin) {
                $query->where('status', 'menunggu');
            }])->whereHas('pengajuanRapat', function ($query) use ($roleAdmin) {
                $query->where('status', 'menunggu')
                      ->where('id_ruangrapat', $roleAdmin);
            })->orderBy('id', 'desc')->get();
        }

        return response()->json(['data' => $dataPengajuan]);
    }

    public function getDetailAjuan(Request $request)
    {
        $idAjuan = $request->input('idAjuan');
        // dd($idAjuan);
        $permohonan_rapat = Permohonan_Rapat::with(['divisi', 'ruangrapat', 'pegawai_absen'])->where('id_ajuan', $idAjuan)->get();
        $idPermohonanRapat = Permohonan_Rapat::where('id_ajuan', $idAjuan)->first();
       
        $pesertaRapat = Peserta_rapat::with(['pegawai_absen.divisipegawai'])->where('id_permohonan_rapat', $idPermohonanRapat->id)->get();
        return response()->json(['ajuan' => $permohonan_rapat, 'peserta' => $pesertaRapat, 'idPermohonanRapat' => $idPermohonanRapat]);
    }

    public function hapusAjuan($id)
    {
        $ajuan = Pengajuan_rapat::find($id);

        if ($ajuan) {
            $id_ajuan = $ajuan->id;
            $id_permohonan_rapat = Permohonan_Rapat::where('id_ajuan', $id_ajuan)->first();
            Peserta_rapat::where('id_permohonan_rapat', $id_permohonan_rapat->id)->delete();
            Permohonan_Rapat::where('id_ajuan', $id_ajuan)->delete();
            $ajuan->delete();

            return response()->json(['status' => 'success', 'message' => 'Data berhasil dihapus.']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }
    }

    public function simpanAjuan(Request $request)
    {
        $userId = Auth::id();

        $data = new Pengajuan_rapat;
        $data->status = 'menunggu';
        $data->save();
        $id_pengajuan = $data->id;

        $tanggalDanDurasi = $request->input('tanggalDanDurasi');
        $selectedParticipants = $request->input('selectedParticipants');
        $jumlahPeserta = count($selectedParticipants);

        foreach ($tanggalDanDurasi as $dataTanggalDurasi) {
            $tanggal_pinjam = $dataTanggalDurasi['waktu_pinjam'];
            $durasi_pinjam = $dataTanggalDurasi['durasi_pinjam'];
            $tanggal_selesai = date('Y-m-d H:i:s', strtotime($tanggal_pinjam . ' + ' . $durasi_pinjam . ' hours'));
            $ruangan = $request->input('idRuangan');

            $jadwal_bentrok = Permohonan_Rapat::where('id_ruangrapat', $ruangan)
                ->where('status', '!=', 'selesai')
                ->where(function ($query) use ($tanggal_pinjam, $tanggal_selesai) {
                    $query->where(function ($subquery) use ($tanggal_pinjam, $tanggal_selesai) {
                        $subquery->where('tanggal_pinjam', '>=', $tanggal_pinjam)
                            ->where('tanggal_pinjam', '<', $tanggal_selesai);
                    })
                        ->orWhere(function ($subquery) use ($tanggal_pinjam, $tanggal_selesai) {
                            $subquery->where('tanggal_selesai', '>', $tanggal_pinjam)
                                ->where('tanggal_selesai', '<=', $tanggal_selesai);
                        })
                        ->orWhere(function ($subquery) use ($tanggal_pinjam, $tanggal_selesai) {
                            $subquery->where('tanggal_pinjam', '<=', $tanggal_pinjam)
                                ->where('tanggal_selesai', '>=', $tanggal_selesai);
                        });
                })
                ->count();
            // dd($jadwal_bentrok);

            if ($jadwal_bentrok != 0) {
                $hapusAjuan = Pengajuan_rapat::findorfail($id_pengajuan);
                $hapusAjuan->delete();

                return response()->json(['status' => 'error', 'message' => 'Penyimpanan tidak berhasil karena jadwal sudah terisi']);
                // break; 
            }

            $data2 = new Permohonan_Rapat;
            $data2->id_ajuan = $id_pengajuan;
            $data2->nama_pemohon = $request->input('tambahNamaPemohon');
            $data2->divisi = $request->input('tambahDivisi');
            $data2->tanggal_pinjam = $tanggal_pinjam;
            $data2->tanggal_selesai = $tanggal_selesai;
            $data2->hari = 11;
            $data2->jumlah_peserta = $jumlahPeserta;
            $data2->id_ruangrapat = $ruangan;
            $data2->nama_rapat = $request->input('namaKegiatan');
            $data2->status = 1;
            $data2->durasi = 11;
            $data2->save();

            $id_permohonan_rapat = $data2->id;

            foreach ($selectedParticipants as $participant) {
                $pesertaTerpilih = new Peserta_rapat;
                $pesertaTerpilih->id_permohonan_rapat = $id_permohonan_rapat;
                $pesertaTerpilih->id_pegawai_absen = $participant['id'];
                $pesertaTerpilih->save();
            }
        }
        return response()->json(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
    }



    //tambah Permohonan
    public function simpanPermohonan(Request $request)
    {
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pinjam'
        ]);

        $tanggal_pinjam = Carbon::parse($request->input('tanggal_pinjam'));
        $tanggal_selesai = Carbon::parse($request->input('tanggal_selesai'));
        $ruangRapatId = $request->post('id_ruangrapat');

        $selisihJam = $tanggal_pinjam->diffInHours($tanggal_selesai);

        $selisihJamDecimal = $tanggal_pinjam->floatDiffInHours($tanggal_selesai);


        $existingPeminjaman = Permohonan_Rapat::where('id_ruangrapat', $ruangRapatId)->where(function ($query) use ($tanggal_pinjam, $tanggal_selesai) {
            $query->where('tanggal_pinjam', '<=', $tanggal_selesai)
                ->where('tanggal_selesai', '>=', $tanggal_pinjam);
        })->exists();

        if ($existingPeminjaman) {
            return redirect()->back()->with('gagal', 'Maaf, waktu peminjaman ruang sudah terisi. Silakan pilih waktu lain.');
        }

        $divisiRapat = Auth::user()->divisiRapat;
        $simpan = new Permohonan_Rapat();
        $ruangRapat = RuangRapat::all();
        $fasilitas = Fasilitas::where('kondisi', 'ok');
        $fasilitas = $request->post('namafasilitas');
        if (is_null($fasilitas)) {
            $implode =
                $request->post('namafasilitas');
        } else {
            $implode = implode(",", $fasilitas);
        }


        $jumlah_peserta = $request->post('jumlah_peserta');
        $id_ruangrapat = $request->post('id_ruangrapat');
        $ruangRapat = RuangRapat::where('id', $request->post('id_ruangrapat'))->first();
        $kapasitas = $ruangRapat->kapasitas;

        $waktuMasuk = $request->post('waktu_masuk');
        $waktuKeluar = $request->post('waktu_keluar');

        $datetimeMasuk = new DateTime($waktuMasuk);
        $datetimeKeluar = new DateTime($waktuKeluar);

        $durasi = $datetimeMasuk->diff($datetimeKeluar);

        $totalJam = floor($durasi->days * 24 + $durasi->h + $durasi->i / 60 + $durasi->s / 3600);
        $durasiFormatted = sprintf('%02d', $totalJam);
        // dd($durasiFormatted);

        $nd1 = new DateTime($waktuMasuk);
        $nd2 = new DateTime($waktuKeluar);
        $interval = $nd1->diff($nd2);
        $tgl = $interval->format('%r%d');

        //
        if ($jumlah_peserta > $kapasitas) {
            return redirect('permohonan_rapat')->with("gagal", "Gagal input!! Jumlah Peserta melebihi kapasitas ");
        } elseif ($tgl < 0) {
            // kode untuk kondisi ini
            return redirect('permohonan_rapat')->with("gagal", "Gagal input!! " . date('d F Y', strtotime($waktuKeluar)) . " lebih awal dari " . date('d F Y', strtotime($waktuMasuk)) . " Silahkan Pilih yang benar ");

            // Kondisi Jika user yang login
        } elseif ($divisiRapat > 0) {
            $simpan->nama_rapat = $request->post('nama_rapat');
            $simpan->nama_pemohon = $request->post('nama_pemohon');
            $simpan->divisi = $divisiRapat;
            $simpan->tanggal_pinjam = $request->post('tanggal_pinjam');
            $simpan->tanggal_selesai = $request->post('tanggal_selesai');
            $simpan->hari = $request->post('hari');
            $simpan->deskripsi_rapat = $request->post('deskripsi_rapat');
            $simpan->jumlah_peserta = $request->post('jumlah_peserta');
            $simpan->id_ruangrapat = $request->post('id_ruangrapat');
            $simpan->id_pegawai = $request->post('id_pegawai');
            $simpan->id_fasilitas = $implode;
            $simpan->notulen = $request->post('notulen');
            $simpan->durasi = $selisihJam;
            $simpan->status = 1;

            // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
            $simpan->save();

            $emailruang = $request->post('id_ruangrapat');
            //menyimpan nilai id ruangrapat di var emailruang
            if ($emailruang > 1 && $emailruang < 4) {
                $email = User::where('adminRuangan', '=', $emailruang)->value('emailbaru');
            } else {
                $email = User::where('name', '=', 'adminRumga')->value('emailbaru');
            }

            $details = [
                'title' => 'Mail from websitepercobaan.com',
                'body' => 'This is for testing email using smtp'
            ];
            // Mail::to($email)->send(new \App\Mail\EmailRapat($details));
            return redirect('permohonan_rapat')->with("sukses", "Permohonan berhasil Di tambahkan");

            // Kondisi Jika admin yang login
        } else {
            // kode untuk kondisi lainnya
            $simpan->nama_rapat = $request->post('nama_rapat');
            $simpan->nama_pemohon = $request->post('nama_pemohon');
            $simpan->divisi = $request->post('divisi');
            $simpan->tanggal_pinjam = $request->post('tanggal_pinjam');
            $simpan->tanggal_selesai = $request->post('tanggal_selesai');
            $simpan->deskripsi_rapat = $request->post('deskripsi_rapat');
            $simpan->jumlah_peserta = $request->post('jumlah_peserta');
            $simpan->id_ruangrapat = $request->post('id_ruangrapat');
            $simpan->id_pegawai = $request->post('id_pegawai');
            $simpan->id_fasilitas = $implode;
            $simpan->notulen = $request->post('notulen');
            $simpan->status = 1;
            $simpan->durasi = $selisihJam;
            // adalah baris kode yang digunakan untuk mengisi data dari form ke dalam objek $simpan dengan metode post. 
            $simpan->save();

            $emailruang = $request->post('id_ruangrapat');
            //menyimpan nilai id ruangrapat di var emailruang
            if ($emailruang > 1 && $emailruang < 4) {
                $email = User::where('adminRuangan', '=', $emailruang)->value('emailbaru');
            } else {
                $email = User::where('name', '=', 'adminRumga')->value('emailbaru');
            }

            //PENAMBAHAN FARIS

            //PENAMBAHAN FARIS

            //mencari alamat email yang terkait dengan pengguna yanng memiliki nilai adminruangan sama sdengan nilai yang ada di variable emailruang
            //mengirim email sesuai berdasarkan id ruang rapat dengan nilai di admin ruangan
            // dd($email);
            $details = [
                'title' => 'Mail from websitepercobaan.com',
                'body' => 'This is for testing email using smtp'
            ];
            // Mail::to($email)->send(new \App\Mail\EmailRapat($details));
            return redirect('permohonan_rapat')->with("sukses", "Permohonan berhasil Di tambahkan");
        }
    }


    //hapus permohonan
    public function hapusPermohonan($id)
    {
        //Ambil data yang memilliki nilai permohonan rapat
        $permohonan = DB::table('permohonan_rapat')->where('id', $id)->first();
        $id_ruangrapat = $permohonan->id_ruangrapat;


        // cara mengubah status rapat menjadi 1
        DB::table('ruangrapat')->where('id', $id_ruangrapat)->update(['status' => 1]);

        // menghapus data permohonan rapat berdasarkan id yang dipilih
        DB::table('permohonan_rapat')->where('id', $id)->delete();

        return redirect('permohonan_rapat')->with("Permohonan Berhasil dihapus");
    }

    //Edit Permohonan //
    public function editPermohonan(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }

    // edit_status_baca 
    public function editBaca(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }

    //update status baca

    public function updateBaca(Request $request)
    {
        $id = $request->input('id');
        $data = array(
            'status_baca' => 2,
        );
        $simpan = DB::table('permohonan_rapat')->where('id', '=', $id)->update($data);
    }

    public function updatePermohonan(Request $request)
    {
        $fasilitas = $request->post('fasilitas');
        if (is_null($fasilitas)) {
            $implode =
                $request->post('fasilitas');
        } else {
            $implode = implode(",", $fasilitas);
        }

        $jumlah_peserta = $request->post('jumlah_peserta');
        // ambil nilai dari jumlah peserta dari form
        $id_ruangrapat = $request->post('id_ruangrapat');
        //mengambil id ruang rapat
        $ruangRapat = RuangRapat::where('id', $request->post('id_ruangrapat'))->first();
        // $ruangRapat = RuangRapat::where('kapasitas', 30)->first();
        // dd($ruangRapat);
        //mencari id ruang rapat di table ruang rapat
        $kapasitas = $ruangRapat->kapasitas;



        $waktuMasuk = $request->post('waktu_masuk');
        $waktuKeluar = $request->post('waktu_keluar');

        $nd1 = new DateTime($waktuMasuk);
        $nd2 = new DateTime($waktuKeluar);
        //DateTime merubah format tanggal menjadi angka
        //variable $nd1 beriksan nilai dari waktu masuk namun diubah formatnya menjadi angka dengan DateTime.
        //dirubah menjadi angka agar dapat dikurangi
        $interval = $nd1->diff($nd2);
        $tgl = $interval->format('%r%d');

        $data = array(
            'nama_rapat' => $request->post('nama_rapat'),
            'nama_pemohon' => $request->post('nama_pemohon'),
            'divisi' => $request->post('divisi_edit'),
            //nama di database                 //nama di form
            'waktu_masuk' => $request->post('waktu_masuk'),
            'waktu_keluar' => $request->post('waktu_keluar'),
            'deskripsi_rapat' => $request->post('deskripsi_rapat'),
            'jumlah_peserta' => $request->post('jumlah_peserta'),
            'id_ruangrapat' => $request->post('id_ruangrapat'),
            'id_pegawai' => $request->post('id_pegawai'),
            'id_fasilitas' => $implode,
        );



        if ($jumlah_peserta > $kapasitas) {
            return redirect('permohonan_rapat')->with("gagal", "Gagal input!! Jumlah Peserta melebihi kapasitas ");
        } elseif ($tgl < 0) {
            return redirect('permohonan_rapat')->with("gagal", "Gagal input!! " . date('d F Y', strtotime($waktuKeluar)) . " lebih awal dari " . date('d F Y', strtotime($waktuMasuk)) . " Silahkan Pilih yang benar ");
        } else {
            $simpan = DB::table('permohonan_rapat')->where('id', "=", $request->post('idpermohonan_rapat'))->update($data);
            return redirect('permohonan_rapat')->with("sukses", "Permohonan berhasil di edit");
        }

        // dd($request->post('idKendaraan'));

    }
    //Edit Status
    public function editStatus(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }


    public function statusTerima(Request $request)
    {
        // $data = array(
        //     'id_ruangrapat' => $request->post('id_ruangrapat_status'),
        //     'status' => 2,
        //     'catatan' => $request->post('catatan'),
        //     'kode_absen' => $request->post('kode_absen')
        // );

        // $idRapat =  $request->post('id_ruangrapat_status');
        // $newStartDateTime = strtotime($request->post('tglpinjam') . ' ' . $request->post('tglMasukTerima'));
        // $newEndDateTime = strtotime($request->post('tglpinjam') . ' ' . $request->post('tglKeluarTerima'));

        // // Mengambil data waktu masuk dan waktu keluar dari database
        // $existingBookings = DB::table('permohonan_rapat')->where('id_ruangrapat', $idRapat)->where('status', 2)->get();

        // // Fungsi untuk memeriksa apakah waktu masuk dan waktu keluar pemesanan baru tumpang tindih dengan data pemesanan yang sudah ada
        // function isBookingOverlap($existingBookings, $newStartDateTime, $newEndDateTime)
        // {
        //     foreach ($existingBookings as $booking) {
        //         $existingStartDateTime = strtotime($booking->waktu_masuk);
        //         $existingEndDateTime = strtotime($booking->waktu_keluar);
        //         // Memeriksa apakah tanggal tumpang tindih dengan data pemesanan yang ada
        //         if (date('Y-m-d', $newStartDateTime) === date('Y-m-d', $existingStartDateTime) || date('Y-m-d', $newEndDateTime) === date('Y-m-d', $existingEndDateTime)) {
        //             return false; // Pemesanan baru tumpang tindih dengan data pemesanan yang ada
        //         }
        //         // Memeriksa apakah waktu masuk dan waktu keluar pemesanan baru tumpang tindih dengan data pemesanan yang ada
        //         if ($newStartDateTime < $existingEndDateTime && $newEndDateTime > $existingStartDateTime) {
        //             return true; // Pemesanan baru tumpang tindih dengan data pemesanan yang ada
        //         }
        //     }
        //     return false; // Pemesanan baru tidak tumpang tindih dengan data pemesanan yang ada

        $data = array(
            'id_ruangrapat' => $request->post('id_ruangrapat_status'),
            'status' => 2,
            'catatan' => $request->post('catatan'),
            'kode_absen' => $request->post('kode_absen')
        );

        $idRapat = $request->post('id_ruangrapat_status');
        $tglMasuk = strtotime($request->post('tglpinjam'));
        $jamMasuk = $request->post('tglMasukTerima');
        $tglKeluar = strtotime($request->post('tglpinjam'));
        $jamKeliar =
            $newStartDateTime = strtotime($request->post('tglpinjam') . ' ' . $request->post('tglMasukTerima'));
        $newEndDateTime = strtotime($request->post('tglpinjam') . ' ' . $request->post('tglKeluarTerima'));

        // Mengambil data waktu masuk dan waktu keluar dari database
        $existingBookings = DB::table('permohonan_rapat')->where('id_ruangrapat', $idRapat)->where('status', 2)->get();

        // Fungsi untuk memeriksa apakah waktu masuk dan waktu keluar pemesanan baru tumpang tindih dengan data pemesanan yang sudah ada
        function isBookingOverlap($existingBookings, $newStartDateTime, $newEndDateTime)
        {
            foreach ($existingBookings as $booking) {
                $existingStartDateTime = strtotime($booking->waktu_masuk);
                $existingEndDateTime = strtotime($booking->waktu_keluar);
                // Memeriksa apakah tanggal tumpang tindih dengan data pemesanan yang ada
                if (date('Y-m-d', $newStartDateTime) === date('Y-m-d', $existingStartDateTime) || date('Y-m-d', $newEndDateTime) === date('Y-m-d', $existingEndDateTime)) {
                    return false; // Pemesanan baru tumpang tindih dengan data pemesanan yang ada
                }
                // Memeriksa apakah waktu masuk dan waktu keluar pemesanan baru tumpang tindih dengan data pemesanan yang ada
                if ($newStartDateTime < $existingEndDateTime && $newEndDateTime > $existingStartDateTime) {
                    return true; // Pemesanan baru tumpang tindih dengan data pemesanan yang ada
                }
            }
            return false; // Pemesanan baru tidak tumpang tindih dengan data pemesanan yang ada
        }

        // Memeriksa validitas pemesanan baru
        if (!isBookingOverlap($existingBookings, $newStartDateTime, $newEndDateTime)) {
            $simpan = DB::table('permohonan_rapat')->where('id', "=", $request->post('idpermohonan_rapat'))->update($data);
            return redirect('permohonan_rapat')->with("sukses", "Permohonan Berhasil Diterima");
        } else {
            return redirect('permohonan_rapat')->with("gagal", "Permohonan Tidak Dapat Diterima. Ada tumpang tindih dengan data pemesanan yang sudah ada.");
        }
    }



    //Tolak permohonan
    public function update_status_baca(Request $request)
    {
        $data = array(
            'status_baca' => 2,
        );

        $simpan = DB::table('permohonan_rapat')->where('status_baca', 1)->update($data);

        return redirect('permohonan_rapat');
    }



    public function editTolak(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }
    public function statusTolak(Request $request)
    {
        $data = array(
            'status' => 3,
            'status_baca' => 1,
            'catatan' => $request->post('catatan')

        );
        $simpan = DB::table('permohonan_rapat')->where('id', $request->post('idpermohonan_rapat_tolak'))->update($data);

        return redirect('permohonan_rapat')->with("gagal", "Permohonan Di tolak");
    }

    public function simpanTolak(Request $request)
    {
        $tolak = new RuangRapat;

        $tolak->catatan = $request->post('catatan');

        return redirect(('permohonan_rapat'));
    }
    // Upload Notulen

    public function Uploadnotulen(Request $request)
    {
        $fileNotulen = $request->file('lampiranNotulen');
        $tujuanNotulen = 'notulen';

        $namaFile = 'Notulensi-' . time() . '-' . $fileNotulen->getClientOriginalName();
        $fileNotulen->move($tujuanNotulen, $namaFile);

        $data = array(
            'lampiran' => $namaFile,
            'updated_at' => Carbon::now(),
        );
        $simpan = DB::table('permohonan_rapat')->where('id', $request->post('idpermohonan_rapat_lampiran'))->update($data);

        return redirect('permohonan_rapat')->with("sukses", "Notulensi Berhasil Di Upload");
    }



    //Status Selesai
    public function TampilNotulen(Request $request)
    {
        $id = $request->input('id'); //ID dari button
        $data = Permohonan_Rapat::find($id);
        //ambil data dari table pegawai- dan menemukan id yang sama yang sudah di pasing dari id di button
        return response()->json($data);
        // data di kembalikan dalam format json. yang berada dalam javascript
    }
    public function editSelesai(Request $request)
    {
        $id = $request->input('id');
        $data = Permohonan_Rapat::find($id);
        return response()->json($data);
    }
    public function statusSelesai(Request $request)
    {
        $data = array(
            'status' => 4,
            'catatan' => $request->post('catatan'),

        );
        $simpan = DB::table('permohonan_rapat')->where('id', $request->post('idpermohonan_rapat_selesai'))->update($data);

        return redirect('permohonan_rapat')->with("sukses", "Rapat Selesai");
    }

    public function simpanSelesai(Request $request)
    {
        $tolak = new RuangRapat;

        $tolak->catatan = $request->post('catatan');

        return redirect(('permohonan_rapat'));
    }

    //jadwal
    public function agendaOLD(Request $request)
    {
        $ruangRapat = RuangRapat::all();

        // buat filter tanggal  
        $awal = $request->awal;
        //ambil dari id di form
        //ambil nilai inputan
        $akhir = $request->akhir;

        // dd($request->awal);
        $data1 = RuangRapat::whereDoesntHave('permohonan_rapat', function ($query) {
            $query->where('status', 2)->whereDate('waktu_masuk', Carbon::now());
        })->get();

        // return response()->json($data1);

        if (is_Null($awal)) {
            $dt = Carbon::now();
            //untuk mendapatkan tanggal hari ini
            $permohonan_rapat = Permohonan_Rapat::where('status', 2)->whereDate('waktu_masuk', $dt->toDateString())->orderBy("id_ruangrapat", "desc")->get(); //status 
            $data1 = RuangRapat::whereDoesntHave('permohonan_rapat', function ($query) {
                $query->where('status', 2)->whereDate('waktu_masuk', Carbon::now());
            })->get();
            return view('agenda', ['permohonan_rapat' => $permohonan_rapat, 'tglFilterAwal' => $dt, 'tglFilterAkhir' => $dt, 'data1' => $data1]);
        } else {
            //fungsi untuk filter jadwal di tanggal yang di pilih
            $permohonan_rapat = Permohonan_Rapat::where('status', 2)->whereDate('waktu_masuk', '>=', $awal)->whereDate('waktu_masuk', '<=', $akhir)->orderBy('id_ruangrapat', 'desc')->get();
            $data1 = RuangRapat::whereDoesntHave('permohonan_rapat', function ($query) {
                $query->where('status', 2)->whereDate('waktu_masuk', Carbon::now());
            })->get();
            return view('agenda', ['permohonan_rapat' => $permohonan_rapat, 'awal' => $awal, 'akhir' => $akhir, 'tglFilterAwal' => $request->awal, 'tglFilterAkhir' => $request->akhir, 'data1' => $data1]);
        }
    }

    //absen

    public function simpanAbsen(Request $request)
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



        return redirect('permohonan_rapat')->with("sukses", "Absen Berhasil ");
    }

    //Kode Absen
    public function absen(Request $request)
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
            return view('absen', ['id_permohonanRapat' => $id_permohonanRapat, 'divisi' => $divisi, 'PegawaiAbsen' => $PegawaiAbsen], )->with("sukses", "Silahkan isi Absen");
        } else {
            session()->flash('gagal', 'kode Rapat untuk absen salah, silahkan minta ketua rapat untuk kode yang benar');
            return view('permohonan_rapat', ['permohonan_rapat' => $permohonan_rapat, 'pegawai' => $pegawai, 'fasilitas' => $fasilitas, 'ruangRapat' => $ruangRapat, 'permohonan_rapat2' => $permohonan_rapat2, 'permohonan_rapat3' => $permohonan_rapat3, 'permohonan_rapat4' => $permohonan_rapat4, 'divisi' => $divisi], ['sukses' => 'kode']);
        }
    }

   

    public function rekapAbsen($id_permohonan_rapat)
    {

        $id_permohonanRapat = $id_permohonan_rapat;
        $rekapAbsen = Peserta_rapat::where('id_permohonan_rapat', $id_permohonanRapat)
        ->where('absen', 'sudah')
        ->get();
        // $rekapAbsen2 = Absen::where([
        //     ['id_permohonan_rapat', $id_permohonan_rapat],
        //     ['hari', 2]
        // ])->get();
        return view('rekapAbsen', ['rekapAbsen' => $rekapAbsen, 'id' => $id_permohonan_rapat]);
    }

    //pdf
    public function pdf_rapat($id)
    {
        $permohonan_rapat = Permohonan_Rapat::find($id);
        $rekapAbsen = Absen::where('id_permohonan_rapat', $id)->orderBy("hari", "asc")->get();

        // Generate QR code
        $namaRapat = $permohonan_rapat->nama_rapat;
        $ruangRapat = $permohonan_rapat->ruangRapat->nama;
        $wakturapat = $permohonan_rapat->waktu_masuk . ' - ' . $permohonan_rapat->waktu_keluar;
        $qrcodeData = "Nama Rapat: " . $namaRapat . "\nRuang Rapat: " . $ruangRapat . "\nWaktu Rapat: " . $wakturapat;
        $qrcode = QrCode::size(100)->generate($qrcodeData);

        $pdf = PDF::loadView('pdf_rapat', ['rekapAbsen' => $rekapAbsen, 'permohonan_rapat' => $permohonan_rapat, 'qrcode' => $qrcode])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }



    //pdf permohonan rapat
    public function pdf_permohonan()
    {
        $permohonan_rapat2 = Permohonan_Rapat::where('status', 2)->get(); //status
        $pdf = PDF::loadview('pdf_permohonan', ['permohonan_rapat2' => $permohonan_rapat2])->setpaper('a4', 'landscape');
        // dd($permohonan_rapat2);
        return $pdf->stream();
    }

    public function pdf_permohonan2()
    {
        $permohonan_rapat3 = Permohonan_Rapat::where('status', 4)->get(); //status
        $pdf = PDF::loadview('pdf_permohonan_selesai', ['permohonan_rapat3' => $permohonan_rapat3])->setpaper('a4', 'landscape');
        return $pdf->stream();
    }



    // exel
    public function export_excel()
    {
        return Excel::download(new PermohonanExport, 'permohonan_rapat.xlsx');
        //download, fungsi dari php
    }

    public function export_excel2()
    {
        return Excel::download(new PermohonanSelesaiExport, 'permohonan_rapat.xlsx');
    }

    //divisi
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

    //json
    public function jsonAbsen(Request $request)
    {
        $divisi_id = $request->get('divisi_id');

        // Mengambil daftar pegawai berdasarkan divisi_id yang dipilih
        $data = PegawaiAbsen::where('divisi_id', $divisi_id)->get();

        // Mengembalikan data dalam format JSON
        return response()->json($data);
    }


    public function ajaxPermohonanRapat(Request $request)
    {
        $tglPinjam = $request->get('tgl');
        $durasi = json_decode($request->get('durasi'), true);
        $jamMulai = $request->get('jam_mulai');
        $jamSelesai = $request->get('jam_selesai');


        $tanggalAntara = [];
        $currentDate = new DateTime($tglPinjam);
        foreach ($durasi as $hari) {
            $formattedDate = $currentDate->format('Y-m-d');
            $tanggalAntara[] = $formattedDate;
            $currentDate->modify('+1 day');
        }
        // $permohonanRapat = Permohonan_rapat::where('status', 2)->whereIn('tanggal_pinjam', $tanggalAntara)->get();
        // $permohonanRapat = Permohonan_rapat::where('status', 2)->where('waktu_masuk', $jamMulai)->whereIn('tanggal_pinjam', $tanggalAntara)->get();

        $permohonanRapat = Permohonan_rapat::where('status', 2)
            ->whereIn('tanggal_pinjam', $tanggalAntara)
            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                $query->where(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('waktu_masuk', '<=', $jamSelesai)
                        ->where('waktu_keluar', '>=', $jamMulai);
                })
                    ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                        $q->where('waktu_masuk', '>=', $jamMulai)
                            ->where('waktu_masuk', '<=', $jamSelesai);
                    })
                    ->orWhere(function ($q) use ($jamMulai, $jamSelesai) {
                        $q->where('waktu_keluar', '>=', $jamMulai)
                            ->where('waktu_keluar', '<=', $jamSelesai);
                    });
            })
            ->get();

        return response()->json($permohonanRapat);
    }

 // absen_rapat
 public function absen_rapat($id){
    $peserta_rapat = peserta_rapat::find($id);
    return view('absen', ['peserta_rapat' => $peserta_rapat]);
}


    //  daftar_rapat_peserta 
    public function daftar_rapat_peserta()
{
    // Mendapatkan id_divRapat dari user yang sedang login
    $id_divRapat = Auth::user()->divisiRapat;

    // Mengambil data peserta rapat dengan id_pegawai_absen yang sama dengan $id_divRapat
    // dan memuat relasi 'permohonanRapat' serta relasi bersarang 'ruangRapat'
    $pesertaRapat = Peserta_rapat::with(['permohonanRapat.ruangRapat'])
        ->where('id_pegawai_absen', $id_divRapat)
        ->get();

    // Kirim data ke view
    return view('daftar_rapat_peserta', compact('pesertaRapat'));
}

public function daftar_peserta_rapat($id)
{
    // Ambil data peserta beserta relasi pegawai_absen dan permohonanRapat
    $rapatPeserta = Peserta_rapat::with(['pegawai_absen', 'permohonanRapat'])
        ->where('id_permohonan_rapat', $id)
        ->get();

    // Kembali ke view dengan data peserta yang ditemukan
    return view('daftar_peserta_rapat', ['rapatPeserta' => $rapatPeserta]);
}



public function update_peserta_absen(Request $request)
{
    // Konversi data tanda tangan dari base64 ke file
    $base64Data = $request->input('tanda_tangan');
    list(, $base64Data) = explode(',', $base64Data);
    $decodedData = base64_decode($base64Data);
    $fileName = uniqid() . '.jpg';
    $fileDirectory = 'images/ttd/'; // Direktori di dalam folder public
    $filePath = public_path($fileDirectory . $fileName);

    // dd($filePath);
    // Simpan file tanda tangan ke disk
    file_put_contents($filePath, $decodedData);

    // Menyiapkan data untuk update database
    $data = [
        'absen' => 'sudah',
        'ttd_absen' => $fileName,
        'updated_at' => \Carbon\Carbon::now(),
    ];

    // Update data peserta rapat di database
    DB::table('peserta_rapat')
        ->where('id', $request->input('idruangRapat'))
        ->update($data);

    // Redirect ke halaman daftar rapat peserta dengan pesan sukses
    return redirect('daftar_rapat_peserta')->with('sukses', 'Berhasil Absen');
}

// absen tamu
public function absen_tamu($id){
    $permohonan_rapat = Permohonan_Rapat::find($id);
    return view('absen_tamu', ['permohonan_rapat' => $permohonan_rapat]);
}
public function simpan_tamu_absen(Request $request)
{
    // Konversi data tanda tangan dari base64 ke file
    $base64Data = $request->input('tanda_tangan');
    list(, $base64Data) = explode(',', $base64Data);
    $decodedData = base64_decode($base64Data);
    $fileName = uniqid() . '.jpg';
    $fileDirectory = 'images/ttd/'; // Direktori di dalam folder public
    $filePath = public_path($fileDirectory . $fileName);

    // dd($filePath);
    // Simpan file tanda tangan ke disk
    file_put_contents($filePath, $decodedData);
    $permohonan_rapat = Permohonan_rapat::all();
    // Menyiapkan data untuk update database
    $data = [
        'id_permohonan_rapat' => $request->input('id_permohonan_rapat'),
        'nama_tamu' => $request->input('nama_tamu'),
        'instansi_tamu' => $request->input('instansi_tamu'),
        'absen' => 'sudah',
        'ttd_absen' => $fileName,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];

    // Simpan data baru ke tabel peserta_rapat
    DB::table('peserta_rapat')->insert($data);
    // Redirect ke halaman daftar rapat peserta dengan pesan sukses
    return view('tamu', compact('permohonan_rapat'));

}


}
