@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
    <form class="mb-6 flex flex-wrap gap-3" method="GET">
        <input name="search" value="{{ request('search') }}" class="rounded-lg border-maroon-200 text-sm" placeholder="Search name or email">
        <select name="role" class="rounded-lg border-maroon-200 text-sm"><option value="">All roles</option>@foreach(['participant', 'organizer', 'admin'] as $role)<option value="{{ $role }}" @selected(request('role') === $role)>{{ ucfirst($role) }}</option>@endforeach</select>
        <button class="btn-primary">Filter</button>
    </form>
    <div class="card overflow-x-auto"><table class="min-w-full text-left text-sm"><thead class="border-b border-maroon-100 text-ink-700"><tr><th class="pb-3">User</th><th class="pb-3">Role</th><th class="pb-3">Status</th><th class="pb-3">Actions</th></tr></thead><tbody>
        @forelse($users as $user)<tr class="border-b border-maroon-100 last:border-0"><td class="py-3"><p class="font-medium">{{ $user->name }}</p><p class="text-ink-700">{{ $user->email }}</p></td><td class="py-3 capitalize">{{ $user->role }}</td><td class="py-3 capitalize">{{ $user->status }}</td><td class="py-3"><div class="flex flex-wrap gap-2"><form method="POST" action="{{ route('admin.users.role', $user) }}">@csrf @method('PATCH')<select name="role" class="rounded border-maroon-200 text-xs">@foreach(['participant','organizer','admin'] as $role)<option value="{{ $role }}" @selected($user->role === $role)>{{ ucfirst($role) }}</option>@endforeach</select><button class="ml-1 text-maroon-500">Save</button></form><form method="POST" action="{{ route('admin.users.status', $user) }}">@csrf @method('PATCH')<button class="text-maroon-500">{{ $user->status === 'active' ? 'Suspend' : 'Activate' }}</button></form></div></td></tr>
        @empty<tr><td colspan="4" class="py-6 text-center text-ink-700">No users found.</td></tr>@endforelse
    </tbody></table><div class="mt-4">{{ $users->links() }}</div></div>
@endsection
