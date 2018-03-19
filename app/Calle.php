<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calle extends Model
{
    protected $table = 'calle';

    public function numeros(){
        return $this->hasMany('App\Numero', 'id_calle');
    }
}
