<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRegime extends Model
{
    use HasFactory;
    protected $table = 'tax_regimes';
    protected $guarded = [];

    public function clients(){
        return $this->belongsToMany(Client::class)->withPivot('status','end_date','start_date');;
    }
    public function employees(){
        return $this->belongsToMany(Employee::class)->withPivot('status','end_date','start_date');;
    }
}
