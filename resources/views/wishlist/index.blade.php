<x-app-layout>
    <div class="py-12 bg-[#FBFBFD] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10 text-center sm:text-left">
                <h2 class="text-4xl font-semibold text-gray-900 tracking-tight">My Wishlist</h2>
                <p class="mt-2 text-lg text-gray-500 font-light">Items you've saved for later.</p>
            </div>

            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 p-8">
                @if($wishlists->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <p class="mt-4 text-lg text-gray-500 font-medium">Your wishlist is currently empty.</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 shadow-md hover:shadow-lg">
                                Discover Gifts
                            </a>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($wishlists as $wishlist)
                            <div class="group relative bg-white border border-gray-100 rounded-[2rem] overflow-hidden hover:shadow-2xl transition duration-500 flex flex-col">
                                <div class="relative h-64 bg-gray-50 overflow-hidden">
                                    <img src="{{ $wishlist->product->image_url }}" alt="{{ $wishlist->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                                    
                                    <div class="absolute top-4 right-4 z-10 flex flex-col gap-2">
                                        <form action="{{ route('wishlist.remove', $wishlist->product) }}" method="POST" class="wishlist-remove-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-3 bg-white/90 backdrop-blur-sm rounded-full text-red-500 hover:text-red-600 hover:scale-110 transition shadow-sm" title="Remove from Wishlist">
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition truncate">
                                            <a href="{{ route('products.show', $wishlist->product) }}">
                                                <span aria-hidden="true" class="absolute inset-0"></span>
                                                {{ $wishlist->product->name }}
                                            </a>
                                        </h3>
                                        <p class="text-xl font-bold text-gray-900 ml-4 whitespace-nowrap">₹{{ number_format($wishlist->product->base_price, 2) }}</p>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-4 line-clamp-2 flex-grow">{{ $wishlist->product->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
