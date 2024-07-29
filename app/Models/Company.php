<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'companies';
    protected $fillable = [
        'bussines_name',
        'rfc',
        'email',
        'phone',
    ];
    public function users(){
        return $this->hasMany(User::class);
    }
    public function persons(){
        return $this->hasMany(Person::class);
    }
    public function modules(){
        return $this->belongsToMany(Module::class);
    }
}
