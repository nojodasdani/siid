<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Numero extends Model
{
    protected $table = 'numero';

    public function calle()
    {
        return $this->belongsTo('App\Calle', 'id_calle');
    }

    public function colonos()
    {
        return $this->hasMany('App\User', 'id_numero');
    }
}
