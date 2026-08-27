@extends('layouts.organizer')
@section('title', 'Create Event')
@section('content')<div class="max-w-4xl card"><p class="text-sm text-ink-300 mb-6">New events are submitted to Admin for approval before they appear publicly.</p><form method="POST" action="{{ route('organizer.events.store') }}" enctype="multipart/form-data">@include('organizer.events._form', ['submitLabel' => 'Submit for Approval'])</form></div>@endsection
