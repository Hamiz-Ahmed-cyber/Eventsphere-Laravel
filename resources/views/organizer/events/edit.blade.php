@extends('layouts.organizer')
@section('title', 'Edit Event')
@section('content')<div class="max-w-4xl card"><form method="POST" action="{{ route('organizer.events.update', $event) }}" enctype="multipart/form-data">@method('PUT')@include('organizer.events._form', ['submitLabel' => 'Save Changes'])</form></div>@endsection
