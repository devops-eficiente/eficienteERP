<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRegime extends Model
{
    use HasFactory;
    protected $table = 'tax_regimes';

    protected $fillable = [
        'person_id',
        'tax_regime_id',
        'start_date',
        'end_date',
        'status'
    ];

    public function persons(){
        return $this->belongsToMany(Person::class)->withPivot('status','end_date','start_date');;
    }
}
