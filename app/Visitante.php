<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    protected $table = 'visitante';

    protected $fillable = ['id_auto', 'id_tipo_visitante', 'nombre', 'ultima_visita', 'permitido', 'descripcion', 'foto_cara'];

    public function auto()
    {
        return $this->belongsTo(Auto::class, 'id_auto');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo_Visitante::class, 'id_tipo_visitante');
    }
}
