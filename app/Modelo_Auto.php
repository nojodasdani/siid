<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modelo_Auto extends Model
{
    protected $table = 'modelo';

    protected $fillable = ['id_marca', 'modelo'];
}
