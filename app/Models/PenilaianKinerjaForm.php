<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianKinerjaForm extends Model
{
    protected $table = 'penilaian_kinerja_form';

    protected $fillable = [
        'idMahasiswa',
        'idLowongan',
        'idStaffUnit',
        'total_nilai',
        'tanggal_menilai',
        'catatan'
    ];
}
