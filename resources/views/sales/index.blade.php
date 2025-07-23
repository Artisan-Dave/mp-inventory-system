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
                        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition
                            class="font-medium text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </div>
                </div>
                @endif
                @if (session()->has('error'))
                    <div class="font-medium text-sm text-red-600 dark:text-red-400 ">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="py-3 px-6 w-auto md:flex justify-between">
                    <a href="{{ route('sale.add') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        Record Sale
                    </a>
                    <form method="GET" action="{{ route('sale.search') }}">
                        <x-text-input type="text" name="search" value="{{ request()->query('search') }}" />
                        <x-primary-button type="submit">Search</x-primary-button>
                    </form>

                </div>
                <div class="py-3 px-6">
                    {{ $sales->appends(['search' => request()->search])->links() }}
                </div>
                @foreach ($sales as $sale)
                    <div class="mx-6 py-2 text-gray-900 whitespace-nowrap dark:text-white gap-1">
                        <h4 class="text-md" id="name">Customer: {{ $sale->customer_name }}</h4>
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
                        <!-- TODO: Make a refund button -->
                        <div x-data="{ open: false, saleId:null}" class="mt-5 position-relative">
                            <x-danger-button @click="open = true; saleId={{ $sale->id }} {{ $sale->refunded ? 'disabled' : '' }}">
                                Refund
                            </x-danger-button>

                            <!-- Refund Modal -->
                            <div x-cloak x-show="open"
                                class="fixed inset-0 flex items-center justify-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 bg-opacity-50 dark:bg-opacity-50">
                                <div
                                    class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400 text-gray-700 p-6 rounded-lg md-w-3/4 shadow-md">
                                    <h3 class="text-lg font-semibold mb-4">Are you sure you
                                        want to refund </span><span class="text-red-500" x-text=""></span> ?
                                    </h3>
                                    <div class="flex justify-between">
                                        <!-- Cancel Button -->
                                        <x-primary-button @click="open = false"
                                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancel</x-primary-button>

                                        <!-- Delete Button -->
                                        <form action="{{ route('sale.refund', ['sale_id' => $sale->id]) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('GET')
                                            <x-danger-button type="submit">Yes</x-danger-button>
                                        </form>
                                    </div>
                                </div> <!-- Modal Body -->
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
