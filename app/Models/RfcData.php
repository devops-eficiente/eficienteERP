<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfcData extends Model
{
    use HasFactory;
    protected $table = 'rfc_data';

    protected $casts = [
        'data' => 'array'
    ];

    protected $fillable = [
        'person_id',
        'data'
    ];

    public function rfc_data(){
        return $this->belongsTo(Person::class);
    }
}
