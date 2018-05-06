<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    protected $table = 'accesos';

    protected $fillable = ['id_colono', 'id_visitante', 'id_tipo_acceso', 'id_status', 'id_codigo', 'nombre_colono', 'domicilio', 'auto'];

    public function colono()
    {
        return $this->belongsTo(User::class, 'id_colono');
    }

    public function visitante()
    {
        return $this->belongsTo(Visitante::class, 'id_visitante');
    }

    public function tipo_acceso()
    {
        return $this->belongsTo(Tipo_Acceso::class, 'id_tipo_acceso');
    }

    public function status()
    {
        return $this->belongsTo(Estatus::class, 'id_status');
    }

    public function codigo()
    {
        return $this->belongsTo(Codigo::class, 'id_codigo');
    }
}
