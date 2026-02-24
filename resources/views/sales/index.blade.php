@extends('layouts.pos')

@section('title', 'Sales')

@section('content')
<h1 class="text-2xl font-bold mb-4">Sales</h1>



<form method="GET" action="{{ route('sales.index') }}" 
      class="mb-6 flex flex-wrap items-end gap-4 bg-black p-4 rounded shadow">

    <div>
        <label class="block text-sm font-medium">From</label>
        <input type="date" name="from" value="{{ request('from') }}"
            class="border rounded px-3 py-2 text-black">
    </div>

    <div>
        <label class="block text-sm font-medium">To</label>
        <input type="date" name="to" value="{{ request('to') }}"
            class="border rounded px-3 py-2 text-black">
    </div>

    <div>
        <button type="submit"
            class="bg-blue-600 text-blue px-4 py-2 rounded hover:bg-blue-700">
            Filter
        </button>
    </div>

    @if(request('from') && request('to'))
        <div>
            <a href="{{ route('Report.print', request()->all()) }}"
               class="bg-green-600 text-blue px-4 py-2 rounded hover:bg-green-700">
                Print
            </a>
<a href="{{ route('sales.pdf', request()->only('from', 'to')) }}"
   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
   Export PDF
</a>

</a>

        </div>
    @endif
</form>

@if(request('from') && request('to'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        Total Sales from {{ request('from') }} to {{ request('to') }} :
        <strong>FCFA {{ number_format($rangeTotal ?? 0, 2) }}</strong>
    </div>
@endif


<table class="w-full bg-black rounded shadow">
    <thead>
        <tr class="border-b text-left bg-green-100 text-black">
            <th class="px-4 py-2">Number</th>
            <th class="px-4 py-2">Product Name</th>
            <th class="px-4 py-2">Total</th>
            <th class="px-4 py-2">Date</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sales as $sale)
        <tr class="border-b text-left">
            <td class="px-4 py-2">{{  $loop->iteration}}</td>
            <td class="px-4 py-2">
    @if($sale->products->isNotEmpty())
        {{ $sale->products->pluck('name')->join(', ') }}
    @else
        N/A 
        @endif</td>

            <td class="px-4 py-2">FCFA {{ number_format($sale->total_amount, 2) }}</td>
            <td class="px-4 py-2">{{ $sale->created_at->format('d M Y, H:i') }}</td>
            <td class="px-4 py-2">
          <button class="bg-green-600 hover:bg-green-700 
               text-white font-semibold 
               px-4 py-2 rounded-lg transition">  <a href="{{ route('sales.show', $sale) }}" class="text-blue-600 hover:underline">View</a></button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


@endsection
