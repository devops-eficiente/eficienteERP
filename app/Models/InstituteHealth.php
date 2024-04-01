<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstituteHealth extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the employees for the marital status.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
