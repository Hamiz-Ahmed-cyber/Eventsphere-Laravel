<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventSeating;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Admin ----
        $admin = User::create([
            'name' => 'System Admin',
            'email' => 'admin@eventsphere.test',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
        ]);

        // ---- Organizer ----
        $organizer = User::create([
            'name' => 'Ayesha Khan',
            'email' => 'organizer@eventsphere.test',
            'password' => Hash::make('Organizer@123'),
            'role' => 'organizer',
        ]);
        UserDetail::create(['user_id' => $organizer->id, 'department' => 'Computer Science', 'mobile' => '03001234567']);

        // ---- Participant ----
        $participant = User::create([
            'name' => 'Hamiz Ahmed',
            'email' => 'participant@eventsphere.test',
            'password' => Hash::make('Participant@123'),
            'role' => 'participant',
        ]);
        UserDetail::create([
            'user_id' => $participant->id,
            'department' => 'Software Engineering',
            'enrollment_no' => 'SE-2023-014',
            'mobile' => '03007654321',
        ]);

        // ---- Sample approved event ----
        $event = Event::create([
            'title' => 'TechWiz Hackathon 2026',
            'description' => 'A 24-hour full-stack hackathon open to all departments.',
            'category' => 'Technical',
            'event_date' => now()->addDays(10)->toDateString(),
            'event_time' => '10:00:00',
            'venue' => 'Main Auditorium',
            'organizer_id' => $organizer->id,
            'max_participants' => 100,
            'status' => 'approved',
        ]);

        EventSeating::create([
            'event_id' => $event->event_id,
            'total_seats' => 100,
            'seats_booked' => 0,
        ]);

        // ---- Sample pending event (for testing the admin approval flow) ----
        Event::create([
            'title' => 'Cultural Fest — Rangoli Night',
            'description' => 'Annual cultural celebration with music, dance, and food stalls.',
            'category' => 'Cultural',
            'event_date' => now()->addDays(20)->toDateString(),
            'event_time' => '17:00:00',
            'venue' => 'Open Ground',
            'organizer_id' => $organizer->id,
            'max_participants' => 300,
            'status' => 'pending',
        ]);

        $this->command->info('Seeded users:');
        $this->command->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@eventsphere.test', 'Admin@123'],
                ['Organizer', 'organizer@eventsphere.test', 'Organizer@123'],
                ['Participant', 'participant@eventsphere.test', 'Participant@123'],
            ]
        );
    }
}
