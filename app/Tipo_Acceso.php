<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Acceso extends Model
{
    protected $table = 'tipo_acceso';

    protected $fillable = ['nombre'];
}
