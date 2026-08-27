<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $primaryKey = 'registration_id';

    protected $fillable = ['event_id', 'student_id', 'status', 'qr_code', 'registered_on'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getAttendanceAttribute(): ?Attendance
    {
        return Attendance::where('event_id', $this->event_id)
            ->where('student_id', $this->student_id)
            ->first();
    }
}
