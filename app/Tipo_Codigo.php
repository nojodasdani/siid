<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Codigo extends Model
{
    protected $table = 'tipo_codigo';

    protected $fillable = ['nombre'];
}
