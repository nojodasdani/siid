<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Numero extends Model
{
    protected $table = 'numero';
    protected $fillable = ['id_calle', 'numero'];

    public function calle()
    {
        return $this->belongsTo(Calle::class, 'id_calle');
    }

    public function colonos()
    {
        return $this->hasMany(User::class, 'id_numero');
    }
}
