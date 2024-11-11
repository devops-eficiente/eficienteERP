<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $connection = 'mysql_wabapi'; // Conexión a la base de datos externa
    protected $table = 'messages';

    protected $casts = [
        'payload' => 'array'
    ];

    public function step(){
        return $this->belongsTo(Step::class);
    }
}
