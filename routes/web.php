<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\Permohonan_rapat;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();




Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// ruangan-home
Route::get('/getRoomDetails', [App\Http\Controllers\HomeController::class, 'getRoomDetails'])->name('getRoomDetails');


Auth::routes();

//Ruang Rapat
Route::get('/ruangRapat', [App\Http\Controllers\RuangRapatController::class, 'ruangRapat'])->name('ruangRapat');
Route::post('/simpanRuangan', [App\Http\Controllers\RuangRapatController::class, 'simpanRuangan'])->name('simpanRuangan');
Route::get('/editRuangan', 'App\Http\Controllers\RuangRapatController@editRuangan')->name('editRuangan');
Route::post('/updateRuangan', 'App\Http\Controllers\RuangRapatController@updateRuangan')->name('updateRuangan');
Route::get('/hapusRuangan{id}', 'App\Http\Controllers\RuangRapatController@hapusRuangan');





//pegawai
Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'pegawai'])->name('pegawai');
Route::post('/simpanPegawai', 'App\Http\Controllers\PegawaiController@simpanPegawai',)->name('simpanPegawai');
Route::get('/editPegawai', 'App\Http\Controllers\PegawaiController@editPegawai')->name('editPegawai');
Route::post('/updatePegawai', [App\Http\Controllers\PegawaiController::class, 'updatePegawai'])->name('updatePegawai');
Route::get('/hapusPegawai{id}', 'App\Http\Controllers\PegawaiController@hapusPegawai');
Route::get('/lampiranPegawai', 'App\Http\Controllers\PegawaiController@lampiranPegawai')->name('lampiranPegawai');

//fasilitas  untuk Tambahan
// Route::get('/coba', [App\Http\Controllers\HomeController::class], 'coba')->name('coba');
Route::get('/fasilitas', 'App\Http\Controllers\HomeController@fasilitas')->name('fasilitas');
Route::post('/simpanFasilitas', 'App\Http\Controllers\HomeController@simpanFasilitas')->name('simpanFasilitas');
Route::get('/editFasilitas', 'App\Http\Controllers\HomeController@editFasilitas')->name('editFasilitas');
Route::post('/updatefasilitas', 'App\Http\Controllers\HomeController@updateFasilitas')->name('updateFasilitas');
Route::get('/hapusFasilitas{id}', 'App\Http\Controllers\HomeController@hapusFasilitas');

//fasilitas ruang rapat
Route::get('/fasilitas_baru', 'App\Http\Controllers\FasilitasController@index')->name('fasilitas_baru');
Route::post('/simpanFasilitas_baru', 'App\Http\Controllers\FasilitasController@simpanFasilitas_baru')->name('simpanFasilitas_baru');
Route::get('/editFasilitasBaru', 'App\Http\Controllers\FasilitasController@editFasilitasBaru')->name('editFasilitasBaru');
Route::post('/updateFasilitasBaru', 'App\Http\Controllers\FasilitasController@updateFasilitasBaru')->name('updateFasilitasBaru');
Route::get('/hapusBaru{id}', 'App\Http\Controllers\FasilitasController@hapusBaru');





//permohonan_rapat
Route::get('/permohonan_rapat', 'App\Http\Controllers\HomeController@permohonan_rapat')->name('permohonan_rapat');
Route::post('/simpanPermohonan', 'App\Http\Controllers\HomeController@simpanPermohonan')->name('simpanPermohonan');

// Calendar
Route::get('/ruang-rapat/events', 'App\Http\Controllers\HomeController@getEvents')->name('getEvents');
Route::get('/detailEvent', 'App\Http\Controllers\HomeController@detailEvent')->name('detailEvent');

Route::get('/editPermohonan', 'App\Http\Controllers\HomeController@editPermohonan')->name('editPermohonan');
Route::post('/statusTerima', 'App\Http\Controllers\HomeController@statusTerima')->name('statusTerima');
Route::get('/editStatus', 'App\Http\Controllers\HomeController@editStatus')->name('editStatus');
Route::post('/statusDiterima', 'App\Http\Controllers\HomeController@statusDiterima')->name('statusDiterima');

Route::get('/editTolak', 'App\Http\Controllers\HomeController@editTolak')->name('editTolak');
Route::post('/statusTolak', 'App\Http\Controllers\HomeController@statusTolak')->name('statusTolak');

Route::get('/editSelesai', 'App\Http\Controllers\HomeController@editSelesai')->name('editSelesai');
Route::post('/statusSelesai', 'App\Http\Controllers\HomeController@statusSelesai')->name('statusSelesai');

Route::post('/updateStatus', 'App\Http\Controllers\HomeController@updateStatus')->name('updateStatus');
Route::post('/updatePermohonan', 'App\Http\Controllers\HomeController@updatePermohonan')->name('updatePermohonan');

Route::get('/hapusPermohonan{id}', 'App\Http\Controllers\HomeController@hapusPermohonan');
Route::get('/detailPermohonan', 'App\Http\Controllers\HomeController@detailPermohonan')->name('detailPermohonan');
Route::get('/ruang-rapat/events', 'App\Http\Controllers\HomeController@getEvents')->name('getEvents');
Route::get('/getDivisi', 'App\Http\Controllers\HomeController@getDivisi')->name('getDivisi');
Route::get('/getRuang', 'App\Http\Controllers\HomeController@getRuang')->name('getRuang');
Route::get('/getPengajuanJson', 'App\Http\Controllers\HomeController@getPengajuanJson')->name('getPengajuanJson');
Route::post('/simpanAjuan', 'App\Http\Controllers\HomeController@simpanAjuan')->name('simpanAjuan');
Route::get('/getDetailAjuan', 'App\Http\Controllers\HomeController@getDetailAjuan')->name('getDetailAjuan');
Route::get('/hapusAjuan/{id}', 'App\Http\Controllers\HomeController@hapusAjuan')->name('hapusAjuan');

//AGENDA
Route::get('/agenda', 'App\Http\Controllers\AgendaController@agenda')->name('agenda');
Route::get('/konfirmasiAjuan', 'App\Http\Controllers\AgendaController@konfirmasiAjuan')->name('konfirmasiAjuan');
Route::post('/konfirmasiTerimaAksi', 'App\Http\Controllers\AgendaController@konfirmasiTerimaAksi')->name('konfirmasiTerimaAksi');
Route::post('/konfirmasiTolakAksi', 'App\Http\Controllers\AgendaController@konfirmasiTolakAksi')->name('konfirmasiTolakAksi');
Route::get('/getAgendaJson', 'App\Http\Controllers\AgendaController@getAgendaJson')->name('getAgendaJson');
Route::get('/selesaikan', 'App\Http\Controllers\AgendaController@selesaikan')->name('selesaikan');
Route::get('/getDetailPeserta', 'App\Http\Controllers\AgendaController@getDetailPeserta')->name('getDetailPeserta');

// Riwayat
Route::get('/riwayat', 'App\Http\Controllers\RiwayatController@riwayat')->name('riwayat');


//Jadwal ruangan
// Route::get('/agenda', 'App\Http\Controllers\HomeController@agenda')->name('agenda');

//absen
// Route::get('/absen', [App\Http\Controllers\HomeController::class, 'absen'])->name('absen');
Route::post('/simpanAbsen', 'App\Http\Controllers\HomeController@simpanAbsen')->name('simpanAbsen');

// Route::post('/absen', 'App\Http\Controllers\HomeController@absen')->name('absen');
Route::get('/absenOld', 'App\Http\Controllers\HomeController@absen')->name('absen');

Route::get('/absen_rapat{id_permohonan_rapat}', 'App\Http\Controllers\HomeController@absen_rapat')->name('absen_rapat');

// Route::post('/', 'App\Http\Controllers\HomeController@absen');
Route::get('/rekapAbsen{id_permohonan_rapat}', 'App\Http\Controllers\HomeController@rekapAbsen')->name('rekapAbsen');

// pdf
Route::get('/pdf_rapat{id}', 'App\Http\Controllers\HomeController@pdf_rapat')->name('pdf_rapat');
Route::get('/pdf_permohonan', 'App\Http\Controllers\HomeController@pdf_permohonan')->name('pdf_rapat');
Route::get('/pdf_permohonan2', 'App\Http\Controllers\HomeController@pdf_permohonan2')->name('pdf_rapat2');


// Import Exel
Route::get('/export_excel', 'App\Http\Controllers\HomeController@export_excel');
Route::get('/export_excel2', 'App\Http\Controllers\HomeController@export_excel2');



//divisi

Route::get('/divisi', 'App\Http\Controllers\DivisiController@divisi')->name('divisi');
Route::post('/simpanDivisi', 'App\Http\Controllers\DivisiController@simpanDivisi')->name('simpanDivisi');
Route::get('/editDivisi', 'App\Http\Controllers\DivisiController@editDivisi')->name('editDivisi');
Route::post('/updateDivisi', 'App\Http\Controllers\DivisiController@updateDivisi')->name('updateDivisi');
Route::get('/hapusDivisi{id}', 'App\Http\Controllers\DivisiController@hapusDivisi');

// Upload Notulen
Route::post('/uploadNotulen', 'App\Http\Controllers\HomeController@uploadNotulen')->name('uploadNotulen');
// lihat notulen
Route::get('/TampilLampiran', 'App\Http\Controllers\HomeController@TampilLampiran')->name('TampilLampiran');

//home
//looping table in ajax
//ruangrapat
Route::get('/tampilruang', 'App\Http\Controllers\TampilRuangRapatController@tampilruang')->name('tampilruang');
Route::get('/ruangan_terpakai', 'App\Http\Controllers\TampilRuangRapatController@ruangan_terpakai')->name('ruangan_terpakai');
Route::get('/ruangan_tersedia', 'App\Http\Controllers\TampilRuangRapatController@ruangan_tersedia')->name('ruangan_tersedia');
Route::get('/ruangan_dibooking', 'App\Http\Controllers\TampilRuangRapatController@ruangan_dibooking')->name('ruangan_dibooking');


//json
Route::get('/jsonAbsen', 'App\Http\Controllers\HomeController@jsonAbsen')->name('jsonAbsen');

//Data pegawai
Route::get('/dataPegawai', 'App\Http\Controllers\DataPegawaiController@dataPegawai')->name('dataPegawai');
Route::post('/tambahPegawai', 'App\Http\Controllers\DataPegawaiController@tambahPegawai')->name('tambahPegawai');
Route::get('/editDataPegawai', 'App\Http\Controllers\DataPegawaiController@editDataPegawai')->name('editDataPegawai');
Route::post('/updateDataPegawai', 'App\Http\Controllers\DataPegawaiController@updateDataPegawai')->name('updateDataPegawai');
Route::get('/hapusDataPegawai{id}', 'App\Http\Controllers\DataPegawaiController@hapusDataPegawai');


Route::get('/update_status_baca', 'App\Http\Controllers\HomeController@update_status_baca')->name('update_status_baca');

// ditolak
Route::get('/editBaca', 'App\Http\Controllers\HomeController@editBaca')->name('editBaca');
Route::post('/updateBaca', 'App\Http\Controllers\HomeController@updateBaca')->name('updateBaca');


Route::get('/TampilAdmin', 'App\Http\Controllers\DashboardAdminController@TampilAdmin')->name('TampilAdmin');

Route::get('/rapatDiajukan', 'App\Http\Controllers\DashboardAdminController@rapatDiajukan')->name('rapatDiajukan');

Route::get('/rapatDiterima', 'App\Http\Controllers\DashboardAdminController@rapatDiterima')->name('rapatDiterima');

Route::get('/ajaxPermohonanRapat', 'App\Http\Controllers\HomeController@ajaxPermohonanRapat')->name('ajaxPermohonanRapat');

Route::get('/isi_absen', 'App\Http\Controllers\DataPegawaiController@isi_absen')->middleware('guest')->name('isi_absen');
Route::post('/kode_isi_absen', 'App\Http\Controllers\DataPegawaiController@kode_isi_absen')->middleware('guest')->name('kode_isi_absen');
Route::get('/edit_isi_Permohonan', 'App\Http\Controllers\DataPegawaiController@edit_isi_Permohonan')->middleware('guest')->name('edit_isi_Permohonan');

Route::post('/simpan_isi_absen', 'App\Http\Controllers\DataPegawaiController@simpan_isi_absen')->middleware('guest')->name('simpan_isi_absen');

// List rapat peserta
Route::get('/daftar_rapat_peserta', [App\Http\Controllers\HomeController::class, 'daftar_rapat_peserta'])->name('daftar_rapat_peserta');
Route::post('/update_peserta_absen', 'App\Http\Controllers\HomeController@update_peserta_absen')->name('update_peserta_absen');

// List peserta Rapat
Route::get('/daftar_peserta_rapat{id_permohonan_rapat}', [App\Http\Controllers\HomeController::class, 'daftar_peserta_rapat'])->name('daftar_peserta_rapat');


// Tamu
Route::get('/tamu', function () {
    $permohonan_rapat = Permohonan_rapat::all();
    return view('tamu', compact('permohonan_rapat'));
});


//absen
// Route::get('/absen', [App\Http\Controllers\HomeController::class, 'absen'])->name('absen');
Route::post('/simpanAbsen', 'App\Http\Controllers\HomeController@simpanAbsen')->name('simpanAbsen');

// Route::post('/absen', 'App\Http\Controllers\HomeController@absen')->name('absen');
Route::get('/absenOld', 'App\Http\Controllers\HomeController@absen')->name('absen');

Route::get('/absen_rapat{id_permohonan_rapat}', 'App\Http\Controllers\HomeController@absen_rapat')->name('absen_rapat');
// absen tamu
Route::get('/absen_tamu{id}', function ($id){
    $permohonan_rapat = Permohonan_Rapat::find($id);
    return view('absen_tamu', ['permohonan_rapat' => $permohonan_rapat]);
});

Route::post('/simpan_tamu_absen', 'App\Http\Controllers\HomeController@simpan_tamu_absen')->name('simpan_tamu_absen');


// Route::post('/', 'App\Http\Controllers\HomeController@absen');
Route::get('/rekapAbsen{id_permohonan_rapat}', 'App\Http\Controllers\HomeController@rekapAbsen')->name('rekapAbsen');






//jangan lupa harus ada id dari row yang akan d hapus
