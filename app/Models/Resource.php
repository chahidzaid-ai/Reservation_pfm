<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation; // <--- Linked correctly

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'manager_id',
        'name',
        'location',
        'state',    // Old column
        'status',   // New column for maintenance
        'specs',
        'notes',
    ];

    protected $casts = [
        'specs' => 'array',
    ];

    // --- CONSTANTS (These were missing) ---
    public const STATE_AVAILABLE = 'available';
    public const STATE_MAINTENANCE = 'maintenance';
    public const STATE_DISABLED = 'disabled';

    // --- RELATIONSHIPS ---
    public function category()
    {
        return $this->belongsTo(ResourceCategory::class, 'category_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_items', 'resource_id', 'reservation_id');
    }

    // --- CHECK: IS IT RESERVED OR OCCUPIED NOW? ---
    public function getIsReservedAttribute()
    {
        $now = now(); 

        return $this->reservations()
            ->where(function ($query) {
                // Ignore cancelled or refused reservations
                $query->where('status', '!=', 'cancelled')
                      ->where('status', '!=', 'refused')
                      ->where('status', '!=', 'finished');
            })
            // Check if NOW is inside the reservation period
            ->where('start_at', '<=', $now)
            ->where('end_at', '>=', $now)
            ->exists();
    }
}