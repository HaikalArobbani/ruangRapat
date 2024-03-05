<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan_rapat extends Model
{
    protected $table = "pengajuan_rapat";

    public function permohonanRapat()
    {
        // 'id' adalah primary key di tabel 'pengajuan_rapat'
        // yang diacu oleh foreign key 'id_ajuan' di tabel 'permohonan_rapat'
        return $this->hasMany(Permohonan_Rapat::class, 'id_ajuan');
    }
}
