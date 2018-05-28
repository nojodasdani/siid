<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calle extends Model
{
    protected $table = 'calle';
    protected $fillable = ['calle'];

    public function numeros(){
        return $this->hasMany(Numero::class, 'id_calle');
    }
}
