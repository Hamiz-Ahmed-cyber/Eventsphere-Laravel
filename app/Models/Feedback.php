<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'feedback_id';
    public $timestamps = false;

    protected $fillable = [
        'event_id', 'student_id', 'rating', 'organizational_quality', 'content_relevance',
        'venue_rating', 'coordination_rating', 'technical_arrangements', 'hospitality_rating',
        'comments', 'status', 'submitted_on',
    ];

    protected function casts(): array
    {
        return ['submitted_on' => 'datetime'];
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
