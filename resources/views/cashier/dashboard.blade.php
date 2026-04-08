@extends('layouts.pos')

@section('title', 'Cashier Dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h1>
    <p>This is your cashier dashboard. You can manage POS and view your sales.</p>

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- POS Shortcut -->
        <a href="{{ route('pos.index') }}" class="block px-6 py-8 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 text-center">
            🛒 POS
        </a>

        <!-- Sales Shortcut -->
        <a href="{{ route('sales.index') }}" class="block px-6 py-8 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 text-center">
            🧮 View Sales
        </a>
    </div>
</div>
@endsection