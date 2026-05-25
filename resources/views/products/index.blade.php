<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
            {{ __('Premium Catalog') }}
        </h2>
    </x-slot>

    <div class="py-24 bg-surface min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Hero Header -->
            <div class="text-center mb-24 pt-12">
                <h3 class="text-6xl font-serif font-medium text-brand mb-6 tracking-tight">Minimal. Timeless. Refined.</h3>
                <p class="text-lg text-muted max-w-2xl mx-auto font-light tracking-wide">Objects worth keeping. Designed with intention for everyday elegance.</p>
            </div>

            <!-- Search and Filter Bar -->
            <div class="mb-16 bg-white p-6 rounded-[2rem] shadow-sm border border-border flex flex-col md:flex-row items-center justify-between gap-8">
                <form action="{{ route('home') }}" method="GET" class="w-full md:w-1/2 relative">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="block w-full pl-11 pr-4 py-3.5 bg-surface border-transparent rounded-xl text-brand focus:ring-1 focus:ring-accent focus:bg-white focus:border-accent transition-all duration-500 placeholder-muted">
                </form>

                <div class="w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
                    <div class="flex space-x-3">
                        <a href="{{ route('home', ['search' => request('search')]) }}" class="px-6 py-2.5 rounded-xl text-sm font-medium tracking-wide transition-all duration-500 whitespace-nowrap {{ !request('category') ? 'bg-brand text-white shadow-md' : 'bg-surface text-brand hover:bg-border' }}">All</a>
                        @foreach($categories as $cat)
                            <a href="{{ route('home', ['category' => $cat, 'search' => request('search')]) }}" class="px-6 py-2.5 rounded-xl text-sm font-medium tracking-wide transition-all duration-500 whitespace-nowrap {{ request('category') == $cat ? 'bg-brand text-white shadow-md' : 'bg-surface text-brand hover:bg-border' }}">{{ $cat }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse ($products as $product)
                    <div class="group relative bg-white rounded-[2rem] border border-black/5 hover:border-black/10 hover:shadow-xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                        <div class="relative aspect-[4/5] overflow-hidden bg-surface flex items-center justify-center">
                            <!-- Wishlist Toggle -->
                            <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="wishlist-form absolute top-6 right-6 z-10">
                                @csrf
                                <button type="submit" class="p-3 bg-white/70 backdrop-blur-md rounded-full text-muted hover:text-brand transition duration-500 shadow-sm border border-white/20" title="{{ in_array($product->id, $wishlistedIds) ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                    <svg class="w-5 h-5 {{ in_array($product->id, $wishlistedIds) ? 'text-brand fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </form>

                            @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-[85%] h-[85%] object-contain transition-transform duration-700 ease-out group-hover:scale-110 mix-blend-multiply">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-muted font-light uppercase tracking-widest text-sm">Preview</div>
                            @endif
                        </div>
                        
                        <div class="p-10 flex flex-col flex-grow bg-white">
                            <span class="text-[10px] font-semibold text-accent uppercase tracking-[0.2em] mb-4">{{ $product->category }}</span>
                            <h4 class="text-2xl font-serif font-medium text-brand mb-3 leading-tight tracking-tight">{{ $product->name }}</h4>
                            
                            <!-- Ratings -->
                            <div class="flex items-center mb-4">
                                <div class="flex text-accent">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($product->rating))
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @elseif($i == ceil($product->rating) && $product->rating - floor($product->rating) >= 0.5)
                                            <svg class="w-4 h-4 fill-current text-accent" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-{{$product->id}}-{{$i}}">
                                                        <stop offset="50%" stop-color="currentColor"/>
                                                        <stop offset="50%" stop-color="#E5E7EB" stop-opacity="1"/>
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-{{$product->id}}-{{$i}})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 fill-current text-border" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-xs text-muted ml-3 font-medium tracking-wide">{{ number_format($product->rating, 1) }} ({{ $product->reviews_count }})</span>
                            </div>

                            <p class="text-muted text-sm leading-relaxed flex-grow font-light mt-2">{{ Str::limit($product->description, 80) }}</p>
                            
                            <div class="mt-8 flex flex-col pt-6 border-t border-border">
                                <span class="text-xl font-serif text-brand mb-6">From ₹{{ number_format($product->base_price, 2) }}</span>
                                <a href="{{ route('products.show', $product) }}" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium tracking-wide rounded-xl text-white bg-brand hover:bg-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-brand transition-all duration-500 ease-out">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-2">No products found.</h3>
                        <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                        <a href="{{ route('home') }}" class="mt-6 inline-block text-blue-600 hover:underline">Clear all filters</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-16">
                {{ $products->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
