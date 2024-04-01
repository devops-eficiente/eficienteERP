<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaritalStatus extends Model
{
    use HasFactory;
    protected $table = 'marital_status';
    protected $guarded = [];
    /**
     * Get the employees for the marital status.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
