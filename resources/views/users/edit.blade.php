@extends('layouts.pos')

@section('title', 'Edit User')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit User</h2>

    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT') <!-- Use PUT method for updates -->

        <div class="mb-3">
            <label class="block mb-1 font-semibold">Name</label>
            <input type="text" name="name" 
                   value="{{ old('name', $user->name) }}" 
                   class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" 
                   value="{{ old('email', $user->email) }}" 
                   class="w-full px-3 py-2 border rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1 font-semibold">Password</label>
            <input type="password" name="password" 
                   class="w-full px-3 py-2 border rounded">
            <small class="text-gray-500 text-sm">Leave blank to keep current password</small>
        </div>

        <div class="mb-3">
            <label class="block mb-1 font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" 
                   class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-3">
            <label class="block mb-1 font-semibold">User Type</label>
            <select name="usertype" class="w-full px-3 py-2 border rounded" required>
                <option value="admin" {{ old('usertype', $user->usertype)=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="cashier" {{ old('usertype', $user->usertype)=='cashier' ? 'selected' : '' }}>Cashier</option>
            </select>
        </div>

        <button type="submit" 
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Update User
        </button>
    </form>
</div>
@endsection