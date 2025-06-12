<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="post" action="{{route('product.save')}}">
                    @csrf
                    <!-- Product Name -->
                    <div class="">
                        <x-input-label for="product_name" :value="__('Product Name')" />
                        <x-text-input id="product_name" class="block mt-1 w-full" type="text" name="product_name"
                            :value="old('product_name')" required autofocus autocomplete="product_name" />
                        <x-input-error :messages="$errors->get('product_name')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category" :value="__('Category')" />
                        <x-text-input id="category" class="block mt-1 w-full" type="text" name="category"
                            :value="old('category')" required autocomplete="category" />
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <!-- Quantity -->
                    <div class="mt-4">
                        <x-input-label for="quantity" :value="__('Quantity')" />

                        <x-text-input id="quantity" class="block mt-1 w-full" type="number" name="quantity" required
                            autocomplete="quantity" />

                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>

                    <!-- Price -->
                    <div class="mt-4">
                        <x-input-label for="price" :value="__('Price')" />

                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" required
                            autocomplete="price" />

                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-center mt-4 p-6">
                        <x-primary-button class="ms-4">
                            {{ __('Save Product') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
