<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappSession extends Model
{
    use HasFactory;
    protected $connection = 'mysql_wabapi'; // Conexión a la base de datos externa
    protected $table = 'whatsapp_sessions';

    protected $casts = [
        'permissions' => 'array',
    ];
    // Relación con Step (whatsapp_sessions tiene muchos Steps)
    public function step()
    {
        return $this->hasOne(Step::class);
    }
}
