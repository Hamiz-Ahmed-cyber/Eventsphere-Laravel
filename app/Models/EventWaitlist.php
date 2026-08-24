<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventWaitlist extends Model
{
    protected $table = 'event_waitlist';
    protected $primaryKey = 'waitlist_id';

    protected $fillable = ['user_id', 'event_id', 'waitlist_time', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
