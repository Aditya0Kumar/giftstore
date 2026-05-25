<x-app-layout>
    <div class="py-24 bg-surface min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-12">
                <a href="{{ route('home') }}" class="text-muted hover:text-brand flex items-center text-sm font-medium tracking-wide transition-colors duration-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Catalog
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[2rem] border border-border">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    
                    <!-- Image Area -->
                    <div class="relative bg-surface flex items-center justify-center p-8 lg:p-16 lg:border-r border-border overflow-hidden group">
                        <!-- Wishlist Toggle -->
                        <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="wishlist-form absolute top-8 right-8 z-10">
                            @csrf
                            <button type="submit" class="p-4 bg-white/70 backdrop-blur-md border border-white/20 rounded-full text-muted hover:text-brand transition-all duration-500 shadow-sm group/heart" title="{{ in_array($product->id, $wishlistedIds) ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                <svg class="w-6 h-6 {{ in_array($product->id, $wishlistedIds) ? 'text-brand fill-current' : '' }} group-hover/heart:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </form>
                        
                        @if($product->image_url)
                            <div class="relative z-10 w-[90%] h-[90%] flex items-center justify-center">
                                <img src="{{ asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-contain aspect-[4/5] transition-transform duration-1000 ease-out group-hover:scale-105 mix-blend-multiply">
                            </div>
                        @else
                            <div class="relative z-10 text-gray-400 flex flex-col items-center">
                                <svg class="w-24 h-24 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-xl font-light">Product Preview</span>
                            </div>
                        @endif
                    </div>

                    <!-- Customization Form -->
                    <div class="p-10 lg:p-16 flex flex-col justify-center">
                        <div class="mb-12">
                            <span class="text-[10px] font-semibold text-accent uppercase tracking-[0.2em] mb-4 block">{{ $product->category }}</span>
                            <h2 class="text-5xl lg:text-6xl font-serif font-medium text-brand tracking-tight mb-6 leading-tight">{{ $product->name }}</h2>
                            <p class="text-lg text-muted leading-relaxed font-light tracking-wide">{{ $product->description }}</p>
                        </div>

                        <div class="mb-12 pb-8 border-b border-border flex items-end justify-between">
                            <span class="text-muted font-medium text-lg tracking-wide">Total</span>
                            <div class="flex items-baseline space-x-1">
                                <span class="text-5xl font-serif font-medium text-brand tracking-tight transition-all duration-500" id="dynamic-price">₹{{ number_format($product->base_price, 2) }}</span>
                            </div>
                        </div>

                        <form action="{{ route('cart.add') }}" method="POST" id="customization-form" enctype="multipart/form-data" class="space-y-8">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="space-y-8">
                                @foreach($product->customizationOptions as $option)
                                    <div class="relative group" x-data="{ selected: '' }">
                                        <label class="block text-sm font-medium tracking-wide text-brand mb-4">{{ $option->name }}</label>
                                        
                                        @if($option->values)
                                            <!-- Pill-based Selection -->
                                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                                @foreach($option->values as $value)
                                                    <label class="relative">
                                                        <input type="radio" name="customization[{{ $option->type }}]" value="{{ $value }}" 
                                                               class="customization-input sr-only peer" 
                                                               @change="selected = '{{ $value }}'; calculatePrice()" required>
                                                        <div class="flex items-center justify-center px-4 py-3.5 text-sm font-medium tracking-wide border rounded-xl cursor-pointer transition-all duration-500 peer-checked:border-brand peer-checked:bg-brand peer-checked:text-white border-border bg-surface hover:bg-border text-brand">
                                                            {{ strtoupper(str_replace('_', ' ', $value)) }}
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @elseif($option->type === 'image' || $option->type === 'photo')
                                            <!-- File Upload -->
                                            <div class="relative">
                                                <input type="file" name="customization[{{ $option->type }}]" 
                                                       class="customization-input block w-full px-4 py-4 border border-dashed border-border bg-surface rounded-xl text-sm font-medium tracking-wide text-muted hover:border-brand hover:bg-white transition-all duration-500 cursor-pointer">
                                                <p class="mt-2 text-xs text-gray-400 italic">Recommended size: 1000x1000px (JPG/PNG)</p>
                                            </div>
                                        @elseif($option->type === 'date')
                                            <!-- Date Picker -->
                                            <input type="date" name="customization[{{ $option->type }}]" 
                                                   class="customization-input block w-full px-4 py-4 border-border rounded-xl shadow-sm focus:ring-1 focus:ring-accent focus:border-accent sm:text-sm tracking-wide transition-all duration-500 bg-surface hover:bg-white text-brand"
                                                   @change="calculatePrice()">
                                        @elseif($option->type === 'textarea' || $option->type === 'message')
                                            <!-- Multi-line Text -->
                                            <textarea name="customization[{{ $option->type }}]" rows="3"
                                                      class="customization-input block w-full px-4 py-4 border-border rounded-xl shadow-sm focus:ring-1 focus:ring-accent focus:border-accent sm:text-sm tracking-wide transition-all duration-500 bg-surface hover:bg-white text-brand"
                                                      placeholder="Enter your message..."
                                                      @keyup.debounce.300ms="calculatePrice()"></textarea>
                                        @else
                                            <!-- Default Text Input -->
                                            <input type="text" name="customization[{{ $option->type }}]" 
                                                   class="customization-input block w-full px-4 py-4 border-border rounded-xl shadow-sm focus:ring-1 focus:ring-accent focus:border-accent sm:text-sm tracking-wide transition-all duration-500 bg-surface hover:bg-white text-brand" 
                                                   placeholder="Enter {{ strtolower($option->name) }}..."
                                                   @keyup.debounce.300ms="calculatePrice()">
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Quantity Selector -->
                            <div class="pt-6 border-t border-border flex items-center justify-between" x-data="{ qty: 1 }">
                                <span class="text-muted font-medium text-lg tracking-wide">Quantity</span>
                                <div class="flex items-center border border-border rounded-xl bg-surface p-1">
                                    <button type="button" @click="if(qty > 1) { qty--; $nextTick(() => { document.getElementById('product-qty').dispatchEvent(new Event('change', { bubbles: true })); }); }" class="px-4 py-2 text-brand font-bold text-lg hover:bg-border rounded-lg transition">-</button>
                                    <input type="number" name="quantity" id="product-qty" x-model="qty" readonly class="w-12 text-center bg-transparent border-none focus:ring-0 text-brand font-medium text-lg customization-input">
                                    <button type="button" @click="qty++; $nextTick(() => { document.getElementById('product-qty').dispatchEvent(new Event('change', { bubbles: true })); });" class="px-4 py-2 text-brand font-bold text-lg hover:bg-border rounded-lg transition">+</button>
                                </div>
                            </div>

                            <div class="pt-10">
                                <button type="submit" class="w-full flex items-center justify-center bg-brand text-white font-medium tracking-wide text-lg py-4 px-8 rounded-xl hover:bg-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-brand transition-all duration-500">
                                    Add to Bag
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AJAX Pricing Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('customization-form');
            const inputs = document.querySelectorAll('.customization-input');
            const priceDisplay = document.getElementById('dynamic-price');
            let timeoutId;

            function calculatePrice() {
                const formData = new FormData(form);
                const data = {};
                formData.forEach((value, key) => {
                    const match = key.match(/customization\[(.*?)\]/);
                    if (match && value) { // Only add if value is not empty
                        data[match[1]] = value;
                    }
                });

                // Subtle fade effect
                priceDisplay.style.opacity = '0.5';

                fetch('{{ url('/api/calculate-price') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: {{ $product->id }},
                        customization: data
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.price !== undefined) {
                        const qtyInput = document.getElementById('product-qty');
                        const qty = qtyInput ? parseInt(qtyInput.value) || 1 : 1;
                        const totalPrice = parseFloat(result.price) * qty;
                        priceDisplay.innerText = '₹' + totalPrice.toLocaleString('en-IN', { minimumFractionDigits: 2 });
                        priceDisplay.style.opacity = '1';
                    }
                })
                .catch(error => {
                    console.error('Error calculating price:', error);
                    priceDisplay.style.opacity = '1';
                });
            }



            // Intercept Form Submission (AJAX Add to Bag)
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Dispatch Toast
                        window.dispatchEvent(new CustomEvent('show-toast', {
                            detail: { message: data.message, type: 'success' }
                        }));

                        // Update Navigation Cart Badge
                        const badgeContainer = document.getElementById('cart-badge-container');
                        if (badgeContainer && data.cart_count !== undefined) {
                            if (data.cart_count > 0) {
                                badgeContainer.innerHTML = `<span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-brand rounded-full shadow-sm">${data.cart_count}</span>`;
                            } else {
                                badgeContainer.innerHTML = '';
                            }
                        }
                    }
                })
                .catch(error => {
                    console.error('Error adding to cart:', error);
                    window.dispatchEvent(new CustomEvent('show-toast', {
                        detail: { message: 'Something went wrong. Please try again.', type: 'error' }
                    }));
                });
            });

            // Listen for changes on all types of inputs
            form.addEventListener('change', (e) => {
                if (e.target.classList.contains('customization-input')) {
                    calculatePrice();
                }
            });

            form.addEventListener('input', (e) => {
                if (e.target.classList.contains('customization-input') && e.target.type !== 'radio') {
                    clearTimeout(timeoutId);
                    timeoutId = setTimeout(() => {
                        calculatePrice();
                    }, 300);
                }
            });
        });
    </script>

    <!-- Product Specifications Section -->
    @if($product->specifications && count($product->specifications) > 0)
    <div class="py-24 bg-surface border-t border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <h3 class="text-4xl font-serif font-medium text-brand mb-12 tracking-tight text-center">Product Specifications</h3>
                <div class="bg-white rounded-[2rem] shadow-sm border border-border overflow-hidden">
                    <dl class="divide-y divide-border">
                        @foreach($product->specifications as $key => $value)
                            <div class="px-8 py-6 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-surface transition-colors duration-500">
                                <dt class="text-xs font-semibold text-muted uppercase tracking-[0.2em]">{{ str_replace('_', ' ', $key) }}</dt>
                                <dd class="mt-1 text-lg text-brand sm:mt-0 sm:col-span-2 font-medium tracking-wide">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Similar Products Section -->
    @if(isset($similarProducts) && $similarProducts->count() > 0)
    <div class="py-24 bg-surface border-t border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-[10px] font-semibold text-accent uppercase tracking-[0.2em] mb-4 block">Recommended for you</span>
                <h3 class="text-4xl font-serif font-medium text-brand tracking-tight">You May Also Like</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($similarProducts as $similar)
                    <div class="group relative bg-white rounded-[2rem] border border-black/5 hover:border-black/10 hover:shadow-xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                        <div class="relative aspect-[4/5] overflow-hidden bg-surface flex items-center justify-center">
                            <!-- Wishlist Toggle -->
                            <form action="{{ route('wishlist.toggle', $similar) }}" method="POST" class="wishlist-form absolute top-6 right-6 z-10">
                                @csrf
                                <button type="submit" class="p-3 bg-white/70 backdrop-blur-md rounded-full text-muted hover:text-brand transition duration-500 shadow-sm border border-white/20" title="{{ in_array($similar->id, $wishlistedIds) ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                    <svg class="w-5 h-5 {{ in_array($similar->id, $wishlistedIds) ? 'text-brand fill-current' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </form>

                            @if($similar->image_url)
                                <img src="{{ asset($similar->image_url) }}" alt="{{ $similar->name }}" class="w-[85%] h-[85%] object-contain transition-transform duration-700 ease-out group-hover:scale-110 mix-blend-multiply">
                            @else
                                <div class="h-full w-full flex items-center justify-center text-muted font-light uppercase tracking-widest text-sm">Preview</div>
                            @endif
                        </div>
                        
                        <div class="p-8 flex flex-col flex-grow bg-white">
                            <span class="text-[10px] font-semibold text-accent uppercase tracking-[0.2em] mb-3">{{ $similar->category }}</span>
                            <h4 class="text-xl font-serif font-medium text-brand mb-2 leading-tight tracking-tight">{{ $similar->name }}</h4>
                            
                            <!-- Ratings -->
                            <div class="flex items-center mb-4">
                                <div class="flex text-accent">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($similar->rating))
                                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @elseif($i == ceil($similar->rating) && $similar->rating - floor($similar->rating) >= 0.5)
                                            <svg class="w-3.5 h-3.5 fill-current text-accent" viewBox="0 0 20 20">
                                                <defs>
                                                    <linearGradient id="half-{{$similar->id}}-{{$i}}">
                                                        <stop offset="50%" stop-color="currentColor"/>
                                                        <stop offset="50%" stop-color="#E5E7EB" stop-opacity="1"/>
                                                    </linearGradient>
                                                </defs>
                                                <path fill="url(#half-{{$similar->id}}-{{$i}})" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3.5 h-3.5 fill-current text-border" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-[11px] text-muted ml-2 font-medium tracking-wide">{{ number_format($similar->rating, 1) }}</span>
                            </div>

                            <p class="text-muted text-xs leading-relaxed flex-grow font-light">{{ Str::limit($similar->description, 60) }}</p>
                            
                            <div class="mt-6 flex flex-col pt-4 border-t border-border">
                                <span class="text-lg font-serif text-brand mb-4">From ₹{{ number_format($similar->base_price, 2) }}</span>
                                <a href="{{ route('products.show', $similar) }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-xs font-medium tracking-wide rounded-xl text-white bg-brand hover:bg-black focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-brand transition-all duration-500 ease-out">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Ratings & Reviews Section -->
    <div class="py-24 bg-white border-t border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
                
                <!-- Review Summary -->
                <div class="lg:col-span-1">
                    <h3 class="text-4xl font-serif font-medium text-brand mb-8 tracking-tight">Customer Reviews</h3>
                    <div class="flex items-center mb-4">
                        <div class="flex text-accent">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= round($product->rating) ? 'fill-current' : 'text-border' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <span class="ml-4 text-4xl font-serif font-medium text-brand">{{ number_format($product->rating, 1) }}</span>
                        <span class="ml-3 text-muted tracking-wide mt-2">out of 5</span>
                    </div>
                    <p class="text-muted font-light tracking-wide mb-12 block">Based on {{ $product->reviews_count }} reviews</p>

                    @auth
                        <div class="bg-surface p-10 rounded-[2rem] border border-border">
                            <h4 class="text-2xl font-serif font-medium text-brand mb-8">Write a Review</h4>
                            <form action="{{ route('reviews.store', $product) }}" method="POST" class="space-y-8">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium tracking-wide text-brand mb-4">Your Rating</label>
                                    <div class="flex flex-row-reverse justify-end gap-2" x-data="{ rating: 0 }">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required>
                                            <label for="star{{ $i }}" class="cursor-pointer text-border hover:text-accent peer-checked:text-accent transition-colors duration-500">
                                                <svg class="w-8 h-8 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            </label>
                                        @endfor
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium tracking-wide text-brand mb-3">Your Feedback</label>
                                    <textarea name="comment" rows="4" class="block w-full px-4 py-4 border-border rounded-xl shadow-sm focus:ring-1 focus:ring-accent focus:border-accent sm:text-sm bg-white tracking-wide transition-all duration-500" placeholder="Tell us what you think..." required></textarea>
                                </div>
                                <button type="submit" class="w-full bg-brand text-white font-medium tracking-wide py-4 px-6 rounded-xl hover:bg-black transition duration-500">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="bg-gray-50 p-6 rounded-2xl border border-dashed border-gray-300 text-center">
                            <p class="text-gray-600 mb-4 font-light">Please log in to share your thoughts.</p>
                            <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">Log In</a>
                        </div>
                    @endauth
                </div>

                <!-- Reviews List -->
                <div class="lg:col-span-2">
                    <div class="space-y-12">
                        @forelse($product->reviews as $review)
                            <div class="border-b border-border pb-12 last:border-0">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center">
                                        <div class="h-12 w-12 rounded-full bg-surface border border-border flex items-center justify-center text-brand font-serif font-medium uppercase text-lg">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-5">
                                            <p class="text-sm font-medium tracking-wide text-brand">{{ $review->user->name }}</p>
                                            <p class="text-xs text-muted tracking-wide mt-1">{{ $review->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-accent">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-border' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-muted leading-relaxed font-light tracking-wide">"{{ $review->comment }}"</p>
                            </div>
                        @empty
                            <div class="text-center py-24 bg-surface rounded-[2rem] border border-border">
                                <svg class="mx-auto h-12 w-12 text-muted/50 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <p class="text-lg text-muted font-light tracking-wide">No reviews yet. Be the first to share your experience.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
