<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = "municipio";

    protected $fillable = [
        'nombre'
    ];

    protected function departamento(){
        return $this->belongsTo(Departamento::class);
    }

    protected function instituto(){
        return $this->hasMany(Instituto::class);
    }

    protected function lugar(){
        return $this->hasMany(Lugar::class);
    }

    protected function datosbasicos(){
        return $this->hasMany(DatosBasicos::class);
    }
}