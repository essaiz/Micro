<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = ['cod', 'nombres', 'email'];

    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    public function getPromedioAttribute()
    {
        return $this->notas()->avg('nota');
    }

    public function getEstadoAttribute()
    {
        $promedio = $this->getPromedioAttribute();
        if (is_null($promedio)) {
            return 'Sin nota';
        }
        return $promedio >= 3 ? 'Aprobado' : 'Reprobado';
    }
}
