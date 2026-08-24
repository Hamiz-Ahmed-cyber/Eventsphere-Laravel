<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSeating extends Model
{
    protected $table = 'event_seating';
    protected $primaryKey = 'event_id';
    public $incrementing = false;

    protected $fillable = ['event_id', 'total_seats', 'seats_booked', 'waitlist_enabled'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
