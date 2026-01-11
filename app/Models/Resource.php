<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'manager_id',
        'name',
        'location',
        'state',
        'specs',
        'notes',
    ];

    protected $casts = [
        'specs' => 'array',
    ];

    public const STATE_AVAILABLE = 'available';
    public const STATE_MAINTENANCE = 'maintenance';
    public const STATE_DISABLED = 'disabled';

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
}
