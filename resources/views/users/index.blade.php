@extends('layouts.pos')

@section('title', 'Users')

@section('content')

@if(session('success'))
    <div class="bg-green-200 text-green-800 p-3 rounded mb-4 relative">
        {{ session('success') }}
        <button onclick="this.parentElement.style.display='none'" 
                class="absolute top-1 right-2 text-green-900 font-bold">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif






<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Users Management</h2>

    <!-- Add User Button -->
    <div class="mb-4">
        <a href="{{ route('users.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">
            ➕ Add User
        </a>
    </div>

    <!-- Users Table -->
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded shadow-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm">
                <tr>
                    <th class="px-4 py-3 text-left">Number</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">User Type</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-black 
                                     {{ $user->usertype === 'admin' ? 'bg-green-600' : 'bg-blue-600' }}">
                            {{ ucfirst($user->usertype) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <!-- Edit Button -->
                        <a href="{{ route('users.edit', $user) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1 rounded transition">
                            ✏️ Edit/Update
                        </a>

                        <!-- Delete Button -->
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Are you sure you want to delete this user?')" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition">
                                🗑️ Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @if($users->isEmpty())
                <tr>
                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">
                        No users found.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection