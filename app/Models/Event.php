<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'event_id';

    protected $fillable = [
        'title', 'description', 'category', 'event_date', 'event_time', 'venue',
        'organizer_id', 'banner_image', 'rulebook', 'max_participants', 'status',
        'waitlist_enabled', 'cancellation_allowed', 'cancellation_cutoff', 'certificate_fee',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'waitlist_enabled' => 'boolean',
            'cancellation_allowed' => 'boolean',
        ];
    }

    // ---- Relationships ----
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'event_id');
    }

    public function seating()
    {
        return $this->hasOne(EventSeating::class, 'event_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'event_id');
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'event_id');
    }

    public function media()
    {
        return $this->hasMany(MediaGallery::class, 'event_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'event_id');
    }

    // ---- Scopes ----
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>=', now()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('event_date', '<', now()->toDateString());
    }

    // ---- Helpers ----
    public function seatsAvailable(): int
    {
        if (! $this->seating) {
            return $this->max_participants;
        }

        return max(0, $this->seating->total_seats - $this->seating->seats_booked);
    }

    public function isFull(): bool
    {
        return $this->seatsAvailable() <= 0;
    }
}
