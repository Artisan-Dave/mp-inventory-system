<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Sales') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-3 px-6">
                    @if (session()->has('success'))
                        <div class="font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="font-medium text-sm text-red-600 dark:text-red-400">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="py-3 px-6 w-auto md:flex justify-between">
                        <a href="{{ route('sale.add') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Record Sale
                        </a>
                        <form method="GET" action="{{route('sale.search')}}">
                            <x-text-input type="text" name="search" value="{{ request()->query('search') }}" />
                            <x-primary-button type="submit">Search</x-primary-button>
                        </form>

                    </div>
                    <div class="py-3 px-6">
                            {{ $sales->appends(['search' => request()->search])->links() }}
                    </div>
                    @foreach ($sales as $sale)
                        <div class="mx-6 py-2 text-gray-900 whitespace-nowrap dark:text-white gap-1">
                            <h4 class="text-md">Customer: {{ $sale->customer_name }}</h4>
                            <p>Total: ₱{{ number_format($sale->total_amount, 2) }}</p>
                            <p>Date: {{ $sale->created_at }}</p>
                            <ul>
                                @foreach ($sale->products as $product)
                                    <li>
                                        {{ $product->product_name }} — Qty: {{ $product->pivot->quantity }} @
                                        ₱{{ $product->pivot->price }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
