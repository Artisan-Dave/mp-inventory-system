<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
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
                        <a href="{{ route('product.add') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Add Product
                        </a>
                         <form method="GET" action="{{ route('product.search') }}">
                            <x-text-input type="text" name="search" value="{{ request()->query('search') }}"/>
                            <x-primary-button type="submit" >Search</x-primary-button>
                        </form>

                    </div>
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Product name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Stocks
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Price
                                </th>
                                @if (auth()->user()->usertype !== 'user')
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr
                                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $product->product_name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $product->category }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->quantity }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $product->price }}
                                    </td>
                                    @if (auth()->user()->usertype == 'admin')
                                        <td class="px-6 py-4 w-auto">
                                            <div x-data="{ open: false, productId: null, productName: '' }" class="flex justify-start gap-6">
                                                <a href="{{ URL::signedRoute('product.edit', ['product_id' => $product->id]) }}"
                                                    class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Edit</a>
                                                <x-danger-button
                                                    @click="open = true; productId={{ $product->id }}; productName='{{ $product->product_name }}'">
                                                    Delete
                                                </x-danger-button>

                                                {{-- Confirmation Modal --}}
                                                <div x-cloak x-show="open"
                                                    class="fixed inset-0 flex items-center justify-center text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 bg-opacity-50 dark:bg-opacity-50">
                                                    <div class="bg-gray-50 dark:bg-gray-800 dark:text-gray-400 text-gray-700 p-6 rounded-lg md-w-3/4 shadow-md">
                                                        <h3 class="text-lg font-semibold mb-4">Are you sure you
                                                            want to delete </span><span class="text-red-500"
                                                                x-text="productName"></span> ?</h3>
                                                        <div class="flex justify-between">
                                                            <!-- Cancel Button -->
                                                            <x-primary-button @click="open = false"
                                                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Cancel</x-primary-button>

                                                            <!-- Delete Button -->
                                                            <form
                                                                action="{{ route('product.delete', ['product_id' => $product->id]) }}"
                                                                method="POST" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                {{-- <input type="hidden" name="student_id"
                                                                            :value="studentId"> --}}
                                                                <x-danger-button type="submit"
                                                                    class="bg-red-500 text-white px-4 py-2 rounded">Delete</x-danger-button>
                                                            </form>
                                                        </div>
                                                    </div> <!-- Modal Body -->
                                                </div> <!-- Modal -->
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                                @empty
                                    <div>
                                        <h2 class="flex justify-center bg-gray-200">No record found</h2>
                                    </div>
                            @endforelse
                            <div class="py-3 px-6">
                                {{$products->appends(['search' => request()->search])->links()}}
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
