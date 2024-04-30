<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'state_id',
        'name',
        'created_by_user_id',
        'updated_by_user_id'
    ];

    /**
     * Obtiene una colección de ciudades con base en el id del estado.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getCitiesOfState($stateId)
    {
        if ($stateId >= 1) {
            return self::where('state_id', $stateId)
                ->get(['id', 'state_id', 'name']);
        }
    }

    // Una ciudad pertenece a un estado.
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
