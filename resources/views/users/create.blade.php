@extends('layouts.pos')

@section('title', 'Create User')

@section('content')
<!--<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-lg">-->
    <div>
    <h2 class="text-2xl font-bold mb-6 text-gray-800">➕ Create New User</h2>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-800 p-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="Enter full name" required>
        </div>

        <!-- Email -->
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="Enter email address" required>
        </div>

        <!-- Password -->
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Password</label>
            <input type="password" name="password" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="Enter password" required>
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="block mb-1 font-semibold text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" 
                   placeholder="Confirm password" required>
        </div>

        <!-- User Type -->
        <div>
            <label class="block mb-1 font-semibold text-gray-700">User Type</label>
            <select name="usertype" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" 
                    required>
                <option value="" disabled selected>Select user type</option>
                <option value="admin" {{ old('usertype')=='admin' ? 'selected' : '' }}>Admin</option>
                <option value="cashier" {{ old('usertype')=='cashier' ? 'selected' : '' }}>Cashier</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full bg-blue-600 text-white py-2 rounded-lg shadow hover:bg-blue-700 transition duration-200 font-semibold">
            Create User
        </button>
    </form>
</div>
@endsection