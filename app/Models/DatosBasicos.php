<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DatosBasicos extends Model
{
    use SoftDeletes;

    protected $table = "datos_basicos";

    protected $fillable = [
      'cedula',
      'foto',
      'primer_nombre',
      'segundo_nombre',
      'primer_apellido',
      'segundo_apellido',
      'tipo_sangre_id',
      'municipio_id',
      'genero_id',
      'direccion_id',
      'telefono_id',
      'eps_id',
      'email',
    ];

    protected function user(){
        return $this->hasOne(User::class);
    }

    public function arbitro(){
        return $this->hasOne(Arbitro::class);
    }

    public function telefono(){
        return $this->belongsTo(Telefono::class);
    }
    
    public function municipio(){
        return $this->belongsTo(Municipio::class);
    }
    
    public function direccion(){
        return $this->belongsTo(Direccion::class);
    }
    public function tipo_sangre(){
        return $this->belongsTo(TipoSangre::class);
    }
    public function genero(){
        return $this->belongsTo(Genero::class);
    }
    public function eps(){
        return $this->belongsTo(Eps::class);
    }
    public function jugador(){
        return $this->hasOne(Jugador::class);
    }
}