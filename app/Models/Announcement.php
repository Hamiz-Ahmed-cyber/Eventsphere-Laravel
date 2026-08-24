<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $primaryKey = 'announcement_id';

    protected $fillable = ['sent_by', 'title', 'message', 'target_role', 'event_id'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
