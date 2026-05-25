<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 leading-tight tracking-tight">
            {{ __('Your Shopping Bag') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-surface min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-4 rounded-2xl relative mb-6 shadow-sm flex items-center justify-between transition-all" role="alert">
                    <span class="block sm:inline font-medium tracking-wide text-sm">{{ session('success') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-800 px-6 py-4 rounded-2xl relative mb-6 shadow-sm flex items-center justify-between transition-all" role="alert">
                    <span class="block sm:inline font-medium tracking-wide text-sm">{{ session('error') }}</span>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-[2rem] border border-border">
                <div class="p-8 sm:p-12 text-brand">
                    @if(empty($cart))
                        <div class="text-center py-16">
                            <svg class="mx-auto h-16 w-16 text-muted mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            <p class="text-muted text-xl mb-6 font-light tracking-wide">Your bag is currently empty.</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium tracking-wide rounded-xl text-white bg-brand hover:bg-black transition duration-500">Continue Shopping</a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="border-b border-border">
                                        <th class="py-4 px-4 text-left text-xs font-semibold text-muted uppercase tracking-[0.2em]">Product</th>
                                        <th class="py-4 px-4 text-left text-xs font-semibold text-muted uppercase tracking-[0.2em]">Customization</th>
                                        <th class="py-4 px-4 text-left text-xs font-semibold text-muted uppercase tracking-[0.2em]">Quantity</th>
                                        <th class="py-4 px-4 text-left text-xs font-semibold text-muted uppercase tracking-[0.2em]">Unit Price</th>
                                        <th class="py-4 px-4 text-left text-xs font-semibold text-muted uppercase tracking-[0.2em]">Subtotal</th>
                                        <th class="py-4 px-4 text-left text-xs font-semibold text-muted uppercase tracking-[0.2em]">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border">
                                    @php $total = 0; @endphp
                                    @foreach($cart as $id => $item)
                                        @php 
                                            $qty = $item['quantity'] ?? 1;
                                            $itemSubtotal = $item['price'] * $qty;
                                            $total += $itemSubtotal; 
                                        @endphp
                                        <tr class="hover:bg-surface/30 transition duration-300">
                                            <td class="py-6 px-4 font-semibold">
                                                <div class="flex items-center space-x-4">
                                                    @if(isset($item['image_url']) && $item['image_url'])
                                                        <div class="w-16 h-16 bg-surface rounded-xl p-1 border border-border flex items-center justify-center overflow-hidden">
                                                            <img src="{{ asset($item['image_url']) }}" alt="{{ $item['name'] }}" class="w-[90%] h-[90%] object-contain mix-blend-multiply">
                                                        </div>
                                                    @endif
                                                    <span class="font-serif text-lg tracking-tight text-brand">{{ $item['name'] }}</span>
                                                </div>
                                            </td>
                                            <td class="py-6 px-4 text-sm text-muted">
                                                <ul class="space-y-1 bg-surface/50 p-4 rounded-xl border border-border/50 max-w-xs">
                                                    @forelse($item['customization'] as $key => $value)
                                                        @if($value)
                                                            <li class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                                                <strong class="text-brand font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                                                @if(filter_var($value, FILTER_VALIDATE_URL) && preg_match('/\.(jpeg|jpg|gif|png|webp)/i', $value))
                                                                    <a href="{{ $value }}" target="_blank" class="inline-block mt-1">
                                                                        <img src="{{ $value }}" class="w-12 h-12 object-cover rounded-lg border border-border hover:scale-105 transition-all duration-300" alt="Uploaded custom design">
                                                                    </a>
                                                                @else
                                                                    <span class="text-right truncate max-w-[150px] font-light">{{ $value }}</span>
                                                                @endif
                                                            </li>
                                                        @endif
                                                    @empty
                                                        <li class="text-xs text-muted/65 italic">No customization selected</li>
                                                    @endforelse
                                                </ul>
                                            </td>
                                            <td class="py-6 px-4">
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center space-x-1" x-data="{ qty: {{ $qty }} }">
                                                    @csrf
                                                    <div class="flex items-center border border-border rounded-xl bg-surface p-1 max-w-[120px]">
                                                        <button type="button" @click="if(qty > 1) { qty--; $nextTick(() => $el.form.submit()); }" class="px-3 py-1.5 text-brand font-bold text-sm hover:bg-border rounded-lg transition">-</button>
                                                        <input type="number" name="quantity" x-model="qty" readonly class="w-8 text-center bg-transparent border-none focus:ring-0 text-brand font-medium text-sm p-0">
                                                        <button type="button" @click="qty++; $nextTick(() => $el.form.submit());" class="px-3 py-1.5 text-brand font-bold text-sm hover:bg-border rounded-lg transition">+</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="py-6 px-4 font-medium text-muted">₹{{ number_format($item['price'], 2) }}</td>
                                            <td class="py-6 px-4 font-bold text-brand text-lg">₹{{ number_format($itemSubtotal, 2) }}</td>
                                            <td class="py-6 px-4">
                                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="text-rose-500 hover:text-rose-700 text-sm font-semibold tracking-wide transition duration-300">Remove</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-12 flex justify-end">
                            <div class="w-full md:w-1/2 bg-surface p-8 rounded-[2rem] border border-border/80 shadow-sm">
                                <h3 class="text-2xl font-serif font-medium mb-6 text-brand border-b border-border pb-4">Order Summary</h3>
                                
                                <form action="{{ route('checkout') }}" method="POST" id="checkout-form" class="space-y-6">
                                    @csrf

                                    <!-- Delivery Date -->
                                    <div>
                                        <label class="block text-sm font-medium tracking-wide text-brand mb-3">Delivery Date</label>
                                        <input type="date" name="delivery_date" required min="{{ date('Y-m-d') }}" class="block w-full px-4 py-3.5 border-border rounded-xl shadow-sm focus:ring-1 focus:ring-accent focus:bg-white transition-all bg-white text-brand font-medium tracking-wide">
                                        <p class="text-xs text-muted mt-2 italic">When should we deliver this customized gift?</p>
                                    </div>

                                    <!-- Premium Gift Wrap -->
                                    <div class="bg-white p-6 rounded-xl border border-border shadow-sm">
                                        <label class="flex items-center space-x-3 cursor-pointer">
                                            <input type="checkbox" name="gift_wrap" id="gift-wrap-toggle" value="1" class="form-checkbox h-5 w-5 text-brand rounded focus:ring-brand border-border">
                                            <span class="text-brand font-medium tracking-wide text-sm">Add Premium Gift Wrap (+₹150)</span>
                                        </label>
                                        <div id="gift-message-container" class="hidden mt-6 pt-6 border-t border-border">
                                            <label class="block text-sm font-medium tracking-wide text-brand mb-3">Greeting Card Message</label>
                                            <textarea name="gift_message" rows="3" class="block w-full px-4 py-3.5 border-border rounded-xl shadow-sm focus:ring-1 focus:ring-accent focus:bg-white transition-all bg-surface text-brand placeholder-muted" placeholder="Write your warm wishes here..."></textarea>
                                        </div>
                                    </div>

                                    <!-- Totals -->
                                    <div class="pt-6 border-t border-border space-y-3">
                                        <div class="flex justify-between text-muted font-light tracking-wide text-sm">
                                            <span>Subtotal</span>
                                            <span>₹{{ number_format($total, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between text-muted font-light tracking-wide text-sm hidden" id="gift-fee-display">
                                            <span>Gift Wrapping</span>
                                            <span>₹150.00</span>
                                        </div>
                                        <div class="flex justify-between text-brand font-serif font-medium text-3xl pt-4 border-t border-border/50">
                                            <span>Total</span>
                                            <span id="final-total">₹{{ number_format($total, 2) }}</span>
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full bg-brand text-white font-medium tracking-wide text-lg py-4 px-6 rounded-xl hover:bg-black transition duration-500 shadow-md">
                                        Proceed to Secure Checkout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Secure Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 z-50 overflow-y-auto hidden animate-fade-in" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background overlay -->
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/60 backdrop-blur-md transition-opacity" aria-hidden="true" onclick="closePaymentModal()"></div>

            <!-- Center modal content -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-middle bg-white rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-border p-8 relative">
                
                <!-- Close Button -->
                <button onclick="closePaymentModal()" class="absolute top-6 right-6 text-muted hover:text-brand transition duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Title -->
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-serif font-medium text-brand">Secure Payment</h3>
                    <p class="text-[10px] text-muted mt-1 uppercase tracking-[0.2em] font-semibold">Simulated Gateway</p>
                </div>

                <!-- Interactive Credit Card Visual -->
                <div class="relative w-full aspect-[1.586/1] mb-6 perspective-1000">
                    <div id="payment-card-inner" class="relative w-full h-full transition-transform duration-700 transform-style-3d shadow-md rounded-2xl text-white p-6 flex flex-col justify-between overflow-hidden">
                        
                        <!-- Card Front -->
                        <div class="absolute inset-0 backface-hidden p-6 flex flex-col justify-between bg-gradient-to-tr from-brand to-zinc-800 rounded-2xl">
                            <div class="flex justify-between items-start">
                                <!-- Chip & Contactless -->
                                <div class="flex space-x-3 items-center">
                                    <div class="w-10 h-7 bg-yellow-500/20 border border-yellow-500/30 rounded-md flex items-center justify-center overflow-hidden">
                                        <div class="grid grid-cols-3 gap-0.5 w-7 h-5 bg-yellow-500/60 rounded"></div>
                                    </div>
                                    <svg class="w-5 h-5 text-white/40 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <!-- Brand Logo -->
                                <div id="card-brand-logo" class="text-lg font-bold italic tracking-wide text-white/80">VISA</div>
                            </div>
                            
                            <!-- Card Number -->
                            <div id="card-number-display" class="text-xl font-mono tracking-widest text-center py-2">•••• •••• •••• ••••</div>
                            
                            <!-- Card Details -->
                            <div class="flex justify-between items-end">
                                <div class="max-w-[70%]">
                                    <span class="text-[8px] uppercase tracking-wider text-white/45 block">Cardholder</span>
                                    <span id="card-name-display" class="text-xs font-medium tracking-wide uppercase block truncate">Your Name</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[8px] uppercase tracking-wider text-white/45 block">Expires</span>
                                    <span id="card-expiry-display" class="text-xs font-mono block">MM/YY</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Back -->
                        <div class="absolute inset-0 backface-hidden rotate-y-180 p-6 flex flex-col justify-between bg-gradient-to-tr from-zinc-850 to-zinc-950 rounded-2xl">
                            <div class="w-full h-8 bg-black/90 -mx-6 mt-1"></div>
                            <div>
                                <div class="text-right pr-2">
                                    <span class="text-[8px] uppercase tracking-wider text-white/45 block">CVV</span>
                                </div>
                                <div class="w-full bg-white h-8 rounded flex items-center justify-end px-3">
                                    <span id="card-cvv-display" class="text-brand font-mono tracking-widest font-bold text-sm">•••</span>
                                </div>
                            </div>
                            <div class="text-[8px] text-white/30 text-center leading-normal">
                                Testing simulated payment portal. Do not insert actual sensitive details.
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Payment Form -->
                <div id="payment-form-container" class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-brand mb-1.5">Cardholder Name</label>
                        <input type="text" id="pay-name" placeholder="John Doe" class="block w-full px-4 py-3 bg-surface border-border rounded-xl text-brand text-sm focus:ring-1 focus:ring-accent focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-brand mb-1.5">Card Number</label>
                        <input type="text" id="pay-number" maxlength="19" placeholder="4111 1111 1111 1111" class="block w-full px-4 py-3 bg-surface border-border rounded-xl text-brand text-sm font-mono focus:ring-1 focus:ring-accent focus:bg-white transition-all">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-brand mb-1.5">Expiry Date</label>
                            <input type="text" id="pay-expiry" maxlength="5" placeholder="MM/YY" class="block w-full px-4 py-3 bg-surface border-border rounded-xl text-brand text-sm font-mono focus:ring-1 focus:ring-accent focus:bg-white transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-brand mb-1.5">CVV</label>
                            <input type="password" id="pay-cvv" maxlength="3" placeholder="123" class="block w-full px-4 py-3 bg-surface border-border rounded-xl text-brand text-sm font-mono focus:ring-1 focus:ring-accent focus:bg-white transition-all">
                        </div>
                    </div>

                    <!-- Error Message -->
                    <div id="payment-error" class="text-rose-500 text-xs font-medium hidden"></div>

                    <button onclick="processSimulatedPayment()" class="w-full bg-brand text-white font-medium tracking-wide text-md py-4 px-4 rounded-xl hover:bg-black transition duration-300 mt-4 shadow-md">
                        Authorize Payment of <span id="payment-total-amount">₹0.00</span>
                    </button>
                </div>

                <!-- Loading Spinner Overlay -->
                <div id="payment-loading-container" class="hidden flex-col items-center justify-center py-10 space-y-6">
                    <div class="relative w-16 h-16">
                        <div class="absolute inset-0 rounded-full border-4 border-surface"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-brand border-t-transparent animate-spin"></div>
                    </div>
                    <div class="text-center">
                        <h4 id="payment-loading-title" class="text-lg font-medium text-brand font-serif">Contacting Gateway...</h4>
                        <p id="payment-loading-subtitle" class="text-xs text-muted mt-2">Securing handshake with Ardent Vault</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Style definition for CC Flip -->
    <style>
        .perspective-1000 {
            perspective: 1000px;
        }
        .transform-style-3d {
            transform-style: preserve-3d;
        }
        .backface-hidden {
            backface-visibility: hidden;
        }
        .rotate-y-180 {
            transform: rotateY(180deg);
        }
        .flipped {
            transform: rotateY(180deg);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('gift-wrap-toggle');
            const msgContainer = document.getElementById('gift-message-container');
            const feeDisplay = document.getElementById('gift-fee-display');
            const finalTotal = document.getElementById('final-total');
            const baseTotal = {{ $total ?? 0 }};

            if (toggle) {
                toggle.addEventListener('change', function() {
                    updateTotals();
                });
            }

            function updateTotals() {
                let total = baseTotal;
                if (toggle && toggle.checked) {
                    total += 150;
                    msgContainer.classList.remove('hidden');
                    feeDisplay.classList.remove('hidden');
                } else {
                    if (msgContainer) msgContainer.classList.add('hidden');
                    if (feeDisplay) feeDisplay.classList.add('hidden');
                }
                if (finalTotal) {
                    finalTotal.innerText = '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 2 });
                }
                const paymentTotal = document.getElementById('payment-total-amount');
                if (paymentTotal) {
                    paymentTotal.innerText = '₹' + total.toLocaleString('en-IN', { minimumFractionDigits: 2 });
                }
            }
            updateTotals();

            // Intercept Checkout Form Submit
            const checkoutForm = document.getElementById('checkout-form');
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Validate delivery date
                    const deliveryInput = checkoutForm.querySelector('input[name="delivery_date"]');
                    if (!deliveryInput || !deliveryInput.value) {
                        alert('Please select a delivery date.');
                        return;
                    }
                    
                    // Open payment modal
                    openPaymentModal();
                });
            }

            // Live card number typing format
            const payNum = document.getElementById('pay-number');
            if (payNum) {
                payNum.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let formatted = '';
                    for (let i = 0; i < value.length; i++) {
                        if (i > 0 && i % 4 === 0) {
                            formatted += ' ';
                        }
                        formatted += value[i];
                    }
                    e.target.value = formatted;
                    
                    // Update display
                    const numDisplay = document.getElementById('card-number-display');
                    if (numDisplay) {
                        numDisplay.innerText = formatted || '•••• •••• •••• ••••';
                    }

                    // Detect card brand
                    const brandLogo = document.getElementById('card-brand-logo');
                    if (brandLogo) {
                        if (value.startsWith('4')) {
                            brandLogo.innerText = 'VISA';
                        } else if (value.startsWith('5')) {
                            brandLogo.innerText = 'MASTERCARD';
                        } else if (value.startsWith('3')) {
                            brandLogo.innerText = 'AMEX';
                        } else {
                            brandLogo.innerText = 'CARD';
                        }
                    }
                });
            }

            // Live cardholder name typing
            const payName = document.getElementById('pay-name');
            if (payName) {
                payName.addEventListener('input', function(e) {
                    const nameDisplay = document.getElementById('card-name-display');
                    if (nameDisplay) {
                        nameDisplay.innerText = e.target.value || 'Your Name';
                    }
                });
            }

            // Live expiry typing
            const payExpiry = document.getElementById('pay-expiry');
            if (payExpiry) {
                payExpiry.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/[^0-9]/g, '');
                    if (value.length > 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                    const expiryDisplay = document.getElementById('card-expiry-display');
                    if (expiryDisplay) {
                        expiryDisplay.innerText = value || 'MM/YY';
                    }
                });
            }

            // Card flip on CVV focus
            const payCvv = document.getElementById('pay-cvv');
            const cardInner = document.getElementById('payment-card-inner');
            if (payCvv && cardInner) {
                payCvv.addEventListener('focus', function() {
                    cardInner.classList.add('flipped');
                });
                payCvv.addEventListener('blur', function() {
                    cardInner.classList.remove('flipped');
                });
                payCvv.addEventListener('input', function(e) {
                    const cvvDisplay = document.getElementById('card-cvv-display');
                    if (cvvDisplay) {
                        cvvDisplay.innerText = '•'.repeat(e.target.value.length) || '•••';
                    }
                });
            }
        });

        function openPaymentModal() {
            const modal = document.getElementById('payment-modal');
            if (modal) modal.classList.remove('hidden');
        }

        function closePaymentModal() {
            const modal = document.getElementById('payment-modal');
            if (modal) modal.classList.add('hidden');
        }

        function processSimulatedPayment() {
            const name = document.getElementById('pay-name').value.trim();
            const number = document.getElementById('pay-number').value.replace(/\s+/g, '');
            const expiry = document.getElementById('pay-expiry').value.trim();
            const cvv = document.getElementById('pay-cvv').value.trim();
            const errorDiv = document.getElementById('payment-error');

            if (!name || number.length < 16 || expiry.length < 5 || cvv.length < 3) {
                errorDiv.innerText = 'Please fill out all card details correctly.';
                errorDiv.classList.remove('hidden');
                return;
            }
            errorDiv.classList.add('hidden');

            // Start animation
            const formContainer = document.getElementById('payment-form-container');
            const loadingContainer = document.getElementById('payment-loading-container');
            
            formContainer.classList.add('hidden');
            loadingContainer.classList.remove('hidden');

            const title = document.getElementById('payment-loading-title');
            const subtitle = document.getElementById('payment-loading-subtitle');

            setTimeout(() => {
                title.innerText = 'Validating Card...';
                subtitle.innerText = 'Checking credentials against simulated core...';
            }, 1200);

            setTimeout(() => {
                title.innerText = 'Authorizing Funds...';
                subtitle.innerText = 'Capturing total amount and booking transaction...';
            }, 2400);

            setTimeout(() => {
                title.innerText = 'Payment Approved!';
                subtitle.innerText = 'Finalizing your order placement...';
            }, 3600);

            setTimeout(() => {
                // Submit form
                document.getElementById('checkout-form').submit();
            }, 4500);
        }
    </script>
</x-app-layout>
