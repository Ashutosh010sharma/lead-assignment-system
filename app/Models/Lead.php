<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'status',
        'is_deleted'
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
    ];


    public function assignment()
    {
        return $this->hasOne(LeadAssignment::class);
    }

    public function assignedUser()
    {
        return $this->hasOneThrough(
            User::class,
            LeadAssignment::class,
            'lead_id',
            'id',
            'id',
            'user_id'
        );
    }
}