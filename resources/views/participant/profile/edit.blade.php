@extends('layouts.participant')

@section('title', 'Profile Settings')

@section('content')

<div class="max-w-2xl">
    <form method="POST" action="{{ route('participant.profile.update') }}" class="p-card space-y-5">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-xs text-slate-500 mb-1 block">Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="p-input" required>
            </div>
            <div>
                <label class="text-xs text-slate-500 mb-1 block">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="p-input" required>
            </div>
            <div>
                <label class="text-xs text-slate-500 mb-1 block">Mobile Number</label>
                <input type="text" name="mobile" value="{{ old('mobile', $user->details->mobile ?? '') }}" class="p-input">
            </div>
            <div>
                <label class="text-xs text-slate-500 mb-1 block">Department</label>
                <input type="text" name="department" value="{{ old('department', $user->details->department ?? '') }}" class="p-input">
            </div>
            <div>
                <label class="text-xs text-slate-500 mb-1 block">Enrollment No.</label>
                <input type="text" name="enrollment_no" value="{{ old('enrollment_no', $user->details->enrollment_no ?? '') }}" class="p-input">
            </div>
        </div>

        <hr class="border-slate-100">

        <div>
            <label class="text-xs text-slate-500 mb-1 block">New Password <span class="text-slate-400">(leave blank to keep current)</span></label>
            <input type="password" name="password" class="p-input" placeholder="••••••••">
        </div>
        <div>
            <label class="text-xs text-slate-500 mb-1 block">Confirm New Password</label>
            <input type="password" name="password_confirmation" class="p-input" placeholder="••••••••">
        </div>

        <button type="submit" class="p-btn-primary w-full !py-3">Save Changes</button>
    </form>
</div>
@endsection
