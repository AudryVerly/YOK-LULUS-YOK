<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianKriteriaForm extends Model
{
    protected $table= 'penilaian_kriteria_form';

    protected $fillable = [
        'idPenilaianForm',
        'idKriteriaKinerja',
        'nilai'
    ];
}
