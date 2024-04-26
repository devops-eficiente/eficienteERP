<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'n_client',
        'person_id',
        'company_name',
        'capital_regime',
        'status',
        'updated_date',
        'rfc_verified',
    ];

    protected $casts = [
        'rfc_data' => 'array'
    ];

    public function person(){
        return $this->belongsTo(Person::class);
    }
}
