@extends('layouts.participant')

@section('title', 'Submit Feedback')

@section('content')

<div class="max-w-2xl">
    <div class="p-card mb-6">
        <h3 class="font-display font-semibold text-slate-800">{{ $event->title }}</h3>
        <p class="text-sm text-slate-500 mt-1">{{ $event->event_date->format('d M Y') }} · {{ $event->venue }}</p>
    </div>

    <form method="POST" action="{{ route('participant.feedback.store', $event->event_id) }}" class="p-card space-y-6">
        @csrf

        <div>
            <label class="text-sm font-medium text-slate-800 mb-3 block">Overall Rating</label>
            <div class="flex gap-2" id="star-rating">
                @for($i = 1; $i <= 5; $i++)
                <label class="cursor-pointer">
                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" {{ old('rating') == $i ? 'checked' : '' }} required>
                    <span class="star text-3xl text-slate-300 peer-checked:text-amber-400 hover:text-amber-300 transition-colors" data-star="{{ $i }}">★</span>
                </label>
                @endfor
            </div>
            @error('rating') <p class="text-xs text-rose-500 mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach([
                'organizational_quality' => 'Organizational Quality',
                'content_relevance' => 'Content Relevance',
                'venue_rating' => 'Venue',
                'coordination_rating' => 'Coordination',
                'technical_arrangements' => 'Technical Arrangements',
                'hospitality_rating' => 'Hospitality',
            ] as $field => $label)
                <div>
                    <label for="{{ $field }}" class="text-sm font-medium text-slate-800 mb-2 block">{{ $label }}</label>
                    <select id="{{ $field }}" name="{{ $field }}" required class="p-input w-full">
                        <option value="">Select rating</option>
                        @for($score = 1; $score <= 5; $score++)
                            <option value="{{ $score }}" @selected(old($field) == $score)>{{ $score }} / 5</option>
                        @endfor
                    </select>
                    @error($field) <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>

        <div>
            <label class="text-sm font-medium text-slate-800 mb-2 block">Comments or suggestions (optional)</label>
            <textarea name="comments" rows="4" class="p-input" placeholder="What did you like? What could be improved?">{{ old('comments') }}</textarea>
        </div>

        <button type="submit" class="p-btn-primary w-full !py-3">Submit Feedback</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Fill stars up to hover position for visual feedback
    document.querySelectorAll('#star-rating .star').forEach(star => {
        star.addEventListener('mouseenter', () => {
            const val = parseInt(star.dataset.star);
            document.querySelectorAll('#star-rating .star').forEach(s => {
                s.classList.toggle('text-amber-400', parseInt(s.dataset.star) <= val);
                s.classList.toggle('text-slate-300', parseInt(s.dataset.star) > val);
            });
        });
    });
</script>
@endsection
