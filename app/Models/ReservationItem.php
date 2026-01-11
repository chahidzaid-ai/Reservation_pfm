<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'resource_id',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
