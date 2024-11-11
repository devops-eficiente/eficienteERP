<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;
    protected $connection = 'mysql_wabapi'; // Conexión a la base de datos externa
    protected $table = 'steps';

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function whatsapp_session()
    {
        return $this->belongsTo(WhatsappSession::class);
    }
}
