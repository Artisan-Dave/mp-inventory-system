<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Record Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="post" action="{{ route('sale.save') }}">
                    @csrf
                    <!-- Customer Name -->
                    <div class="">
                        <x-input-label for="customer_name" :value="__('Customer Name')" />
                        <x-text-input id="customer_name" class="block mt-1 w-full" type="text" name="customer_name"
                            :value="old('customer_name')" required autofocus autocomplete="customer_name" />
                        <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                    </div>

                    <div class="w-full overflow-x-auto mt-4">
                        <h4 class="text-xl text-gray-900 dark:text-white">Products:</h4>
                        @foreach ($products as $product)
                            <div class="px-6 py-1 text-gray-900 whitespace-nowrap dark:text-white">
                                <label>{{ $product->product_name }} - ₱{{ $product->price }} ({{ $product->quantity }}
                                    in
                                    stock)</label>
                                <x-text-input type="number" name="products[{{ $product->id }}][quantity]"
                                    min="0" placeholder="Qty" />
                                <x-text-input type="hidden" name="products[{{ $product->id }}][price]"
                                    value="{{ $product->price }}" />
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-center mt-4 p-6">
                        <x-primary-button class="ms-4">
                            {{ __('Submit Sale') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
