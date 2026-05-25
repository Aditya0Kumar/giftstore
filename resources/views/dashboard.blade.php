<x-app-layout>
    <div class="py-12 bg-[#FBFBFD] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10 text-center sm:text-left">
                <h2 class="text-4xl font-semibold text-gray-900 tracking-tight">Welcome back, {{ Auth::user()->name }}</h2>
                <p class="mt-2 text-lg text-gray-500 font-light">Here is a summary of your recent gifts and orders.</p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 p-8">
                <h3 class="text-2xl font-semibold text-gray-900 mb-8 border-b border-gray-100 pb-4">Order History</h3>
                
                @if($orders->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <p class="mt-4 text-lg text-gray-500 font-medium">You haven't placed any orders yet.</p>
                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 transition duration-300 shadow-md hover:shadow-lg">
                                Start Gifting
                            </a>
                        </div>
                    </div>
                @else
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="border border-gray-100 rounded-2xl p-6 hover:shadow-md transition duration-300 bg-gray-50">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h4>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('F d, Y') }}</p>
                                    </div>
                                    <div class="mt-4 sm:mt-0 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 capitalize">
                                            {{ $order->status }}
                                        </span>
                                        <p class="text-lg font-bold text-gray-900 mt-2">₹{{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                </div>
                                
                                @if($order->delivery_date)
                                    <div class="mt-2 text-sm text-gray-600 bg-white p-3 rounded-xl border border-gray-100 flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Requested Delivery: <strong class="ml-1">{{ \Carbon\Carbon::parse($order->delivery_date)->format('M d, Y') }}</strong>
                                    </div>
                                @endif

                                <!-- Order Items List -->
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <h5 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Items in this Order</h5>
                                    <div class="space-y-4">
                                        @foreach($order->items as $item)
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                                                <div class="flex items-center space-x-4">
                                                    @if($item->product && $item->product->image_url)
                                                        <div class="w-12 h-12 bg-gray-50 rounded-lg p-1 border border-gray-100 flex items-center justify-center overflow-hidden">
                                                            <img src="{{ asset($item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-[90%] h-[90%] object-contain mix-blend-multiply">
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="font-semibold text-gray-900">{{ $item->product->name ?? 'Custom Product' }}</p>
                                                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} • ₹{{ number_format($item->calculated_price, 2) }} each</p>
                                                    </div>
                                                </div>

                                                <!-- Customization Info -->
                                                <div class="text-left sm:text-right">
                                                    @if(!empty($item->customization_json))
                                                        <div class="inline-block text-left text-xs bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                                            @foreach($item->customization_json as $key => $value)
                                                                @if($value)
                                                                    <div class="flex items-center space-x-1 py-0.5">
                                                                        <span class="font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                                        @if(filter_var($value, FILTER_VALIDATE_URL) && preg_match('/\.(jpeg|jpg|gif|png|webp)/i', $value))
                                                                            <a href="{{ $value }}" target="_blank" class="inline-block align-middle">
                                                                                <img src="{{ $value }}" class="w-8 h-8 object-cover rounded border border-gray-200" alt="custom design">
                                                                            </a>
                                                                        @else
                                                                            <span class="text-gray-600">{{ $value }}</span>
                                                                        @endif
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
