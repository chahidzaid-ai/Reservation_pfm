<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'start_at',
        'end_at',
        'justification',
        'manager_note',
        'decided_by',
        'decided_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'decided_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REFUSED = 'refused';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_FINISHED = 'finished';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'reservation_items');
    }

    public function decider()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}
