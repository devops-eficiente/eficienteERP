<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the BloodType that owns the Employee.
     */
    public function blood_type(): BelongsTo
    {
        return $this->belongsTo(BloodType::class);
    }

    /**
     * Get the IdentificationEmployee that owns the Employee.
     */
    public function identification_employee(): BelongsTo
    {
        return $this->belongsTo(IdentificationEmployee::class);
    }

    /**
     * Get the InstituteEmployee that owns the Employee.
     */
    public function institute_health(): BelongsTo
    {
        return $this->belongsTo(InstituteHealth::class);
    }

    /**
     * Get the MaritalStatus that owns the Employee.
     */
    public function marital_status(): BelongsTo
    {
        return $this->belongsTo(MaritalStatus::class);
    }
    protected $casts = [
        'contacts' => 'array',
        'emergency_contacts' => 'array',
    ];

}
