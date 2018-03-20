<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aviso extends Model
{
    protected $table = 'aviso';

    protected $fillable = [
        'texto', 'creado_por', 'visible'
    ];

    public function usuario(){
        return $this->belongsTo('App\User','creado_por');
    }
}
