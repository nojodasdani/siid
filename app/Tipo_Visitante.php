<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Visitante extends Model
{
    protected $table = 'tipo_visitante';

    protected $fillable = ['tipo'];
}
