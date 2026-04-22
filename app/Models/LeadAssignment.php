<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadAssignment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'lead_id',
        'user_id',
        'assigned_at',
        'is_deleted'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'is_deleted' => 'boolean',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}