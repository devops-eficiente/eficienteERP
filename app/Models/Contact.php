<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'person_id',
        'email',
        'phone'
    ];

    public function person(){
        return $this->belongsTo(Person::class);
    }
}
