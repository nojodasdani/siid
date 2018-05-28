<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Marca_Auto extends Model
{
    protected $table = 'marca';

    protected $fillable = ['marca', 'imagen'];

    public function modelos()
    {
        return $this->hasMany(Modelo_Auto::class, 'id_marca');
    }
}
