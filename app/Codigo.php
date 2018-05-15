<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    protected $table = "codigo";

    protected $fillable = ['id_usuario', 'contenido', 'usos_restantes', 'vigente', 'id_tipo_codigo', 'nombre_visitante', 'nombre_colono', 'domicilio', 'imagen'];
}
