<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $table = 'acceso';

    protected $fillable = ['id_colono', 'id_visitante', 'id_tipo_acceso', 'id_status', 'id_codigo', 'nombre_colono', 'domicilio'];
}
