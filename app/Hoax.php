<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hoax extends Model
{
    protected $table = "table_hoax";
    protected $fillable = [
        'IdData',
        'label',
        'tanggal',
        'judul',
        'narasi',
    ];
}
