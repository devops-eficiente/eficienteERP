<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $fillable = [
        'country_id',
        'name',
        'iso',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     * Obtiene una colección de los estados de México.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function mexicoStates()
    {
        return self::where('country_id', 121)
            ->where('id', '!=', 0)
            ->get(['id', 'name']);
    }

    // Un estado pertenece a un país.
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Un estado tiene n ciudades.
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
