<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'iso',
        'created_by_user_id',
        'updated_by_user_id'
    ];
    public function states()
    {
        return $this->hasMany(State::class);
    }
}
