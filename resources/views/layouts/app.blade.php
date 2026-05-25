<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-brand selection:bg-accent selection:text-white">
        <div class="min-h-screen bg-surface flex flex-col justify-between">
            <div class="flex-grow">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>

            <!-- Footer -->
            <footer class="bg-brand text-white/90 border-t border-white/5 font-sans">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8">
                        
                        <!-- Column 1: Brand -->
                        <div class="space-y-6">
                            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                                <span class="font-serif text-3xl font-medium tracking-tight text-white hover:text-accent transition-colors duration-300">GiftStore.</span>
                            </a>
                            <p class="text-sm font-light leading-relaxed text-white/60 tracking-wide">
                                Curated objects of intention, crafted for elegance and designed to celebrate life's most meaningful moments.
                            </p>
                            <div class="flex space-x-4 pt-2">
                                <a href="#" class="p-2.5 bg-white/5 hover:bg-accent hover:text-white rounded-full text-white/60 transition-all duration-500 hover:-translate-y-1" title="Instagram">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </a>
                                <a href="#" class="p-2.5 bg-white/5 hover:bg-accent hover:text-white rounded-full text-white/60 transition-all duration-500 hover:-translate-y-1" title="Pinterest">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.684 10.742a3 3 0 111.12-1.12m0 0a3 3 0 11-1.12 1.12m1.12-1.12L12 9m0 0a3 3 0 11-1.12 1.12m1.12-1.12l-1.12 1.12"></path></svg>
                                </a>
                                <a href="#" class="p-2.5 bg-white/5 hover:bg-accent hover:text-white rounded-full text-white/60 transition-all duration-500 hover:-translate-y-1" title="Facebook">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                                </a>
                            </div>
                        </div>

                        <!-- Column 2: Collections -->
                        <div class="space-y-6 lg:pl-6">
                            <h4 class="text-xs font-semibold text-accent uppercase tracking-[0.2em]">Collections</h4>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('home', ['category' => 'Mugs & Drinkware']) }}" class="text-sm font-light text-white/60 hover:text-white transition-colors duration-300 flex items-center group">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                        Mugs & Drinkware
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home', ['category' => 'Notebooks & Journals']) }}" class="text-sm font-light text-white/60 hover:text-white transition-colors duration-300 flex items-center group">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                        Notebooks & Journals
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home', ['category' => 'Custom Apparel']) }}" class="text-sm font-light text-white/60 hover:text-white transition-colors duration-300 flex items-center group">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                        Custom Apparel
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('home', ['category' => 'Home Accessories']) }}" class="text-sm font-light text-white/60 hover:text-white transition-colors duration-300 flex items-center group">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                        Home Accessories
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Column 3: Support & Concierge -->
                        <div class="space-y-6 lg:pl-6">
                            <h4 class="text-xs font-semibold text-accent uppercase tracking-[0.2em]">Concierge & Help</h4>
                            <ul class="space-y-3">
                                <li>
                                    <button onclick="const chatBtn = document.querySelector('[x-data=\'chatWidget()\'] button'); if (chatBtn) chatBtn.click();" class="text-sm font-light text-white/60 hover:text-white transition-colors duration-300 flex items-center group text-left">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                        Live Concierge Chat
                                    </button>
                                </li>
                                <li>
                                    <a href="#" class="text-sm font-light text-white/60 hover:text-white transition-colors duration-300 flex items-center group">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                        Track Your Order
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm font-light text-white/60 hover:text-white transition-colors duration-300 flex items-center group">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                        Shipping & Returns
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="text-sm font-light text-white/60 hover:text-white transition-colors duration-300 flex items-center group">
                                        <span class="w-1.5 h-1.5 bg-accent rounded-full mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                                        Privacy Policy
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Column 4: Newsletter -->
                        <div class="space-y-6">
                            <h4 class="text-xs font-semibold text-accent uppercase tracking-[0.2em]">Journal Subscription</h4>
                            <p class="text-sm font-light leading-relaxed text-white/60 tracking-wide">
                                Subscribe to receive early previews, exclusive collections, and studio updates.
                            </p>
                            <form @submit.prevent="window.dispatchEvent(new CustomEvent('show-toast', { detail: { message: 'Thank you for subscribing!', type: 'success' } })); $el.reset();" class="flex flex-col space-y-3">
                                <div class="relative">
                                    <input type="email" placeholder="Your email address" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3.5 text-sm text-white placeholder-white/40 focus:ring-1 focus:ring-accent focus:border-accent focus:bg-white/10 transition-all duration-300 outline-none">
                                </div>
                                <button type="submit" class="w-full bg-accent hover:bg-white hover:text-brand text-white font-medium text-sm tracking-wide py-3.5 px-4 rounded-xl transition-all duration-500 shadow-md">
                                    Subscribe
                                </button>
                            </form>
                        </div>

                    </div>

                    <!-- Divider -->
                    <div class="border-t border-white/5 mt-16 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-xs font-light text-white/40 tracking-wide">
                            &copy; {{ date('Y') }} GiftStore Inc. All rights reserved.
                        </span>
                        <div class="flex items-center space-x-6">
                            <span class="text-xs font-light text-white/40 tracking-wide">
                                Designed with passion
                            </span>
                            <span class="text-xs font-light text-white/40 tracking-wide">
                                Premium Gift Experience
                            </span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        @if(!Auth::check() || Auth::user()->role !== 'admin')
            <!-- Live Chat Widget -->
            <div x-data="chatWidget()" class="fixed bottom-8 right-8 z-50">
                <!-- Chat Toggle Button -->
                <button @click="toggle()" class="bg-brand hover:bg-black text-white rounded-full p-4 shadow-xl focus:outline-none transition-all duration-500 ease-out hover:-translate-y-1">
                    <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Chat Window -->
                <div x-show="open" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="absolute bottom-20 right-0 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-black/5 flex flex-col overflow-hidden" style="display: none; height: 500px; max-height: 80vh;">
                    <div class="bg-brand p-5 text-white">
                        <h3 class="font-serif tracking-wide text-lg">Concierge Service</h3>
                        <p class="text-white/70 text-xs font-light tracking-wide mt-1">We typically reply in a few minutes.</p>
                    </div>
                    
                    @guest
                        <div class="flex-1 p-8 flex flex-col justify-center items-center text-center bg-surface space-y-6">
                            <div class="w-16 h-16 bg-brand/5 text-brand rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-serif text-xl font-medium text-brand">Connect with Support</h4>
                                <p class="text-xs text-muted mt-2 font-light leading-relaxed">Log in or create an account to start a secure live chat session with our team.</p>
                            </div>
                            <div class="w-full space-y-3">
                                <a href="{{ route('login') }}" class="block w-full text-center bg-brand text-white font-medium text-sm py-3 px-4 rounded-xl hover:bg-black transition duration-300">Log In</a>
                                <a href="{{ route('register') }}" class="block w-full text-center bg-white border border-border text-brand font-medium text-sm py-3 px-4 rounded-xl hover:bg-surface transition duration-300">Create Account</a>
                            </div>
                        </div>
                    @else
                        <div id="chat-messages" class="flex-1 p-5 overflow-y-auto space-y-4 bg-surface">
                            <template x-for="msg in messages" :key="msg.id">
                                <div :class="msg.is_admin ? 'text-left' : 'text-right'">
                                    <div :class="msg.is_admin ? 'bg-white border border-border text-brand' : 'bg-brand text-white'" class="inline-block px-5 py-3 rounded-2xl max-w-[85%] text-sm shadow-sm break-words leading-relaxed" x-text="msg.content"></div>
                                </div>
                            </template>
                        </div>

                        <div class="p-4 bg-white border-t border-border">
                            <form @submit.prevent="sendMessage" class="flex space-x-3">
                                <input x-model="newMessage" type="text" class="flex-1 border-border rounded-xl px-4 py-2.5 text-sm focus:ring-accent focus:border-accent bg-surface placeholder-muted" placeholder="Type a message...">
                                <button type="submit" class="bg-brand text-white rounded-xl px-4 hover:bg-black transition-colors duration-300" :disabled="!newMessage.trim()">
                                    <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                </button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>

            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('chatWidget', () => ({
                        open: false,
                        messages: [],
                        newMessage: '',
                        userId: {{ Auth::id() ?? 'null' }},
                        
                        init() {
                            if (!this.userId) return;

                            axios.get('/messages').then(res => {
                                this.messages = res.data;
                                this.scrollToBottom();
                            });

                            if (window.Echo) {
                                window.Echo.private(`chat.${this.userId}`)
                                    .listen('MessageSent', (e) => {
                                        if (e.message.is_admin) {
                                            this.messages.push(e.message);
                                            this.scrollToBottom();
                                        }
                                    });
                            }
                        },

                        toggle() {
                            this.open = !this.open;
                            if (this.open) this.scrollToBottom();
                        },

                        sendMessage() {
                            if (!this.newMessage.trim() || !this.userId) return;
                            
                            const content = this.newMessage;
                            this.newMessage = '';
                            
                            // Optimistic UI
                            const tempId = Date.now();
                            this.messages.push({ id: tempId, content: content, is_admin: false });
                            this.scrollToBottom();

                            axios.post('/messages', { content: content }).then(res => {
                                const idx = this.messages.findIndex(m => m.id === tempId);
                                if (idx !== -1) this.messages[idx] = res.data;
                            });
                        },

                        scrollToBottom() {
                            setTimeout(() => {
                                const container = document.getElementById('chat-messages');
                                if (container) container.scrollTop = container.scrollHeight;
                            }, 100);
                        }
                    }));
                });
            </script>
        @endif

        <!-- Toast Notifications Container -->
        <div x-data="toastManager()" 
             @show-toast.window="add($event.detail)" 
             class="fixed top-8 right-8 z-[100] space-y-3 pointer-events-none w-80 sm:w-96">
            <template x-for="toast in toasts" :key="toast.id">
                <div x-show="toast.show"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-2 translate-x-4"
                     x-transition:enter-end="opacity-100 translate-y-0 translate-x-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 translate-x-0"
                     x-transition:leave-end="opacity-0 translate-y-2 translate-x-4"
                     :class="toast.type === 'error' ? 'bg-rose-50 border-rose-200 text-rose-800' : 'bg-emerald-50 border-emerald-200 text-emerald-800'"
                     class="p-4 rounded-2xl border shadow-lg flex items-start space-x-3 pointer-events-auto bg-white/90 backdrop-blur-md">
                    <!-- Icon -->
                    <div class="mt-0.5">
                        <template x-if="toast.type === 'success'">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </template>
                        <template x-if="toast.type === 'error'">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </template>
                    </div>
                    <!-- Text -->
                    <div class="flex-1">
                        <p class="text-sm font-medium" x-text="toast.message"></p>
                    </div>
                    <!-- Close Button -->
                    <button @click="remove(toast.id)" class="text-muted hover:text-brand transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </template>
        </div>

        <script>
            document.addEventListener('alpine:init', () => {
                if (!Alpine.store('toastStoreInitialized')) {
                    Alpine.store('toastStoreInitialized', true);
                    Alpine.data('toastManager', () => ({
                        toasts: [],
                        add(detail) {
                            const id = Date.now();
                            const toast = {
                                id: id,
                                message: detail.message,
                                type: detail.type || 'success',
                                show: true
                            };
                            this.toasts.push(toast);
                            setTimeout(() => {
                                this.remove(id);
                            }, 4000);
                        },
                        remove(id) {
                            const idx = this.toasts.findIndex(t => t.id === id);
                            if (idx !== -1) {
                                this.toasts[idx].show = false;
                                setTimeout(() => {
                                    this.toasts = this.toasts.filter(t => t.id !== id);
                                }, 300);
                            }
                        }
                    }));
                }
            });

            document.addEventListener('DOMContentLoaded', () => {
                // Check for server session flash success/error and dispatch toast
                @if(session('success'))
                    window.dispatchEvent(new CustomEvent('show-toast', {
                        detail: { message: '{{ session('success') }}', type: 'success' }
                    }));
                @endif
                @if(session('error'))
                    window.dispatchEvent(new CustomEvent('show-toast', {
                        detail: { message: '{{ session('error') }}', type: 'error' }
                    }));
                @endif

                // Intercept Wishlist Toggle
                document.addEventListener('submit', function(e) {
                    const form = e.target.closest('.wishlist-form');
                    if (form) {
                        e.preventDefault();
                        
                        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
                        if (!isAuthenticated) {
                            window.dispatchEvent(new CustomEvent('show-toast', {
                                detail: { message: 'Please log in to manage your wishlist.', type: 'error' }
                            }));
                            return;
                        }

                        const button = form.querySelector('button');
                        const svg = button.querySelector('svg');

                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                window.dispatchEvent(new CustomEvent('show-toast', {
                                    detail: { message: data.message, type: 'success' }
                                }));

                                if (data.added) {
                                    svg.classList.add('text-brand', 'fill-current');
                                    button.setAttribute('title', 'Remove from Wishlist');
                                } else {
                                    svg.classList.remove('text-brand', 'fill-current');
                                    button.setAttribute('title', 'Add to Wishlist');
                                }
                            }
                        })
                        .catch(err => {
                            console.error('Error toggling wishlist:', err);
                        });
                    }
                });

                // Intercept Wishlist Remove on wishlist page
                document.addEventListener('submit', function(e) {
                    const form = e.target.closest('.wishlist-remove-form');
                    if (form) {
                        e.preventDefault();
                        const card = form.closest('.group');

                        const formData = new FormData(form);

                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                window.dispatchEvent(new CustomEvent('show-toast', {
                                    detail: { message: data.message, type: 'success' }
                                }));

                                if (card) {
                                    card.style.transition = 'all 0.5s ease';
                                    card.style.opacity = '0';
                                    card.style.transform = 'scale(0.9)';
                                    setTimeout(() => {
                                        card.remove();
                                        const grid = document.querySelector('.grid');
                                        if (grid && grid.children.length === 0) {
                                            window.location.reload();
                                        }
                                    }, 500);
                                }
                            }
                        })
                        .catch(err => {
                            console.error('Error removing wishlist item:', err);
                        });
                    }
                });
            });
        </script>
    </body>
</html>
