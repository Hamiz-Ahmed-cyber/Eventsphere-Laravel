@extends('layouts.admin')
@section('title', 'Reports')
@section('content')
<div class="grid gap-5 md:grid-cols-2"><section class="card"><h2 class="font-display text-xl font-semibold">Participation report</h2><p class="mt-2 text-sm text-ink-700">Registrations, attendance, and average feedback by event.</p><a href="{{ route('admin.reports.participation') }}" class="btn-primary mt-5">Download PDF</a></section><section class="card"><h2 class="font-display text-xl font-semibold">User growth report</h2><p class="mt-2 text-sm text-ink-700">Monthly sign-ups grouped by user role.</p><a href="{{ route('admin.reports.user-growth') }}" class="btn-primary mt-5">Download PDF</a></section></div>
@endsection
