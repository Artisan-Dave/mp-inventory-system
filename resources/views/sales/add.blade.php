<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Record Sale') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <x-text-input id="searchInput" name="searchInput" type="text" class="block w-full mt-1"
                    placeholder="Search Product" />

                <form method="post" action="{{ route('sale.save') }}">
                    @csrf
                    <!-- Customer Name -->
                    <div class="mt-4">
                        <x-input-label for="customer_name" :value="__('Customer Name')" />
                        <x-text-input id="customer_name" class="block mt-1 w-full" type="text" name="customer_name"
                            :value="old('customer_name')" required autofocus autocomplete="customer_name" />
                        <x-input-error :messages="$errors->get('customer_name')" class="mt-2" />
                    </div>

                    <div class="w-auto overflow-x-auto mt-4 mx-auto overflow-y-scroll">
                        <h4 class="text-gray-900 dark:text-white">Products:</h4>
                        <div class="w-full">
                            @foreach ($products as $product)
                                <div class="product-item px-6 py-1 text-gray-900 whitespace-nowrap dark:text-white"
                                    data-name="{{ strtolower($product->product_name) }}">
                                    <label>{{ $product->product_name }} - ₱{{ $product->price }}
                                        ({{ $product->quantity }}
                                        in
                                        stock)
                                    </label>
                                    <x-text-input class="quantity-input" type="number"
                                        name="products[{{ $product->id }}][quantity]" min="0" placeholder="Qty"
                                        data-id="{{ $product->id }}" />
                                    <x-text-input class="price-input" type="hidden"
                                        name="products[{{ $product->id }}][price]" value="{{ $product->price }}"
                                        data-id="{{ $product->id }}" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="totalAmount" class="mt-4 text-lg font-bold text-green-600">Total:0.00</div>
                    <div class="flex items-center justify-center mt-4 p-6">
                        <x-primary-button class="ms-4">
                            {{ __('Submit Sale') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const items = document.querySelectorAll('.product-item');
            let debounceTimeout = null;

            searchInput.addEventListener('input', () => {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(() => {
                    const keyword = searchInput.value.toLowerCase();
                    items.forEach(item => {
                        const name = item.getAttribute('data-name');
                        item.style.display = name.includes(keyword) ? '' : 'none';
                    });
                }, 300);
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const quantityInputs = document.querySelectorAll('.quantity-input');
            const totalAmountDisplay = document.getElementById('totalAmount');

            function updateTotal() {
                let total = 0;
                            
                quantityInputs.forEach(input => {
                    const productId = input.dataset.id;
                    const quantity = parseFloat(input.value) || 0;

                    const priceInput = document.querySelector(`.price-input[data-id="${productId}"]`);
                    const price = parseFloat(priceInput.value) || 0;

                    if (quantity > 0) {
                        total += quantity * price;
                    }
                });

                totalAmountDisplay.textContent = `Total: ${total.toFixed(2)}`;
            }

            quantityInputs.forEach(input => {
                input.addEventListener('input', updateTotal);
            });

            updateTotal();
        });
    </script>
</x-app-layout>
