<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends model
{
    use SoftDeletes;

    protected $table = "equipo";

    protected $fillable = [
      'nombre',
      'logo',
      'instituto_id',
      'color_id',
      'user_id'
    ];

    protected function user(){
      return $this->belongsTo(User::class);
    }

    protected function instituto(){
      return $this->belongsTo(Instituto::class);
    }

    public function color(){
      return $this->belongsTo(Color::class);
    }

    public function inscripcionequipo(){
      return $this->hasOne(InscripcionEquipo::class);
    }

    public function inscripcionjugador(){
      return $this->hasOne(InscripcionJugador::class);
    }
}
