<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Successful') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 text-center">
                    <svg class="w-20 h-20 text-green-500 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Thank you for your order!</h2>
                    <p class="text-lg text-gray-600 mb-8">Your order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} has been placed successfully.</p>
                    
                    <div class="bg-gray-50 rounded-lg p-6 text-left mb-8 border">
                        <h3 class="font-bold text-lg mb-4 border-b pb-2">Order Details</h3>
                        <p class="mb-2"><strong>Total Amount:</strong> ₹{{ number_format($order->total_price, 2) }}</p>
                        <p class="mb-2"><strong>Status:</strong> <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm uppercase tracking-wide font-semibold">{{ $order->status }}</span></p>
                        <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 font-bold transition">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
