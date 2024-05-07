<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $table = 'persons';
    protected $fillable = [
        'rfc',
        'type',
        'regimen',
        'start_date',
        'status',
        'comments'
    ];

    public function employee(){
        return $this->hasOne(Employee::class);
    }
    public function client(){
        return $this->hasOne(Client::class);
    }
    public function addresses(){
        return $this->hasMany(Address::class);
    }
    public function contacts(){
        return $this->hasMany(Contact::class);
    }
    public function rfc_data(){
        return $this->hasMany(RfcData::class);
    }
    public function tax_regimes(){
        return $this->belongsToMany(TaxRegime::class)->withPivot('status','end_date','start_date');
    }

    /**
     * Obtiene una colección de Persons de tipo clientes.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getClients()
    {
        return self::has('client')->paginate(15);
    }
    /**
     * Obtiene una colección de de Persons de tipo empleados.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getEmployees()
    {
        return self::has('employee')->paginate(15);
    }
}
