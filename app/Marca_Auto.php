<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca_Auto extends Model
{
    protected $table = 'marca';

    public function modelos()
    {
        return $this->hasMany('App\Modelo_Auto', 'id_marca');
    }
}
