<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'resource_id',
        'reservation_id',
        'status',
        'description',
        'manager_note',
        'handled_by',
    ];

    public const STATUS_OPEN = 'open';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_RESOLVED = 'resolved';

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
