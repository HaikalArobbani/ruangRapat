<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peserta_rapat extends Model
{
    protected $table = "peserta_rapat";

    public function pegawai_absen()
    {
        return $this->belongsTo('App\Models\PegawaiAbsen', 'id_pegawai_absen')->withDefault([
            'nama' => '-',
            // withDefault berfungsi menggantikan isi kolom nama menjadi - jika kolom nama di hapus
        ]);
    }

    public function permohonanRapat()
    {
        return $this->belongsTo('App\Models\Permohonan_Rapat', 'id_permohonan_rapat')->withDefault([
            'nama' => '-',
            // withDefault berfungsi menggantikan isi kolom nama menjadi - jika kolom nama di hapus
        ]);
    }
    public function ruangRapat()
{
    return $this->permohonanRapat()->with('ruangRapat'); // asumsikan ada relasi 'ruangRapat' di model 'PermohonanRapat'
}
}
