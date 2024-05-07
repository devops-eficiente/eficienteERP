<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapitalRegime extends Model
{
    use HasFactory;
    protected $table = 'capital_regimes';
    protected $fillable = [
        'name',
        'acronym'
    ];

    public function clients(){
        return $this->hasMany(Client::class);
    }
    // // Define un accesor para el atributo 'acronym'
    // public function getAcronymAttribute($value)
    // {
    //     // Elimina todos los espacios en blanco del valor y devuelve el resultado
    //     return str_replace(' ', '', $value);
    // }
}
