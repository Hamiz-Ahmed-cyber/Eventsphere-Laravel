<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $primaryKey = 'certificate_id';
    public $timestamps = false;

    protected $fillable = ['event_id', 'student_id', 'certificate_url', 'fee_paid', 'issued_on'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
