<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = "permohonan_rapat";

    protected $fillables = ["id", "nama_rapat", "divisi", "tanggal_pinjam", "waktu_masuk", "waktu_keluar", "deskripsi_rapat", "jumlah_peserta", "id_ruangrapat", "id_pegawai", "id_fasilitas", "notulen", "status", "catatan", "kode_absen", "status_baca", "durasi"];
    
}
