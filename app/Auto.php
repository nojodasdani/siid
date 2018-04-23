<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    protected $table = 'auto';

    protected $fillable = ['placa', 'id_modelo', 'id_color', 'foto_placa', 'foto_auto'];

    public function modelo()
    {
        return $this->belongsTo(Modelo_Auto::class, 'id_modelo');
    }

    public function color()
    {
        return $this->belongsTo(Color_Auto::class, 'id_color');
    }
}
