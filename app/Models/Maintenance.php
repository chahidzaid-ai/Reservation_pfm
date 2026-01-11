<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'start_at',
        'end_at',
        'reason',
        'created_by',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
