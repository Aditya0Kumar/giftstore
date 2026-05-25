<x-app-layout>
    <div class="py-12 bg-[#FBFBFD] min-h-screen">
        <div class="max-w-[90rem] mx-auto sm:px-6 lg:px-8">
            <!-- Admin Navigation Tabs -->
            <div class="mb-8 border-b border-gray-200 pb-px flex space-x-8">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold tracking-wide text-brand border-b-2 border-brand pb-4 -mb-[1px]">Overview</a>
                <a href="{{ route('admin.products.index') }}" class="text-sm font-medium tracking-wide text-muted hover:text-brand pb-4 transition">Products</a>
            </div>

            <div class="mb-10 flex justify-between items-end">
                <div>
                    <h2 class="text-4xl font-semibold text-gray-900 tracking-tight">Command Center</h2>
                    <p class="mt-2 text-lg text-gray-500 font-light">Overview of your premium store performance and live support.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 uppercase tracking-widest font-semibold mb-1">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900">₹{{ number_format($revenue, 2) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Orders -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 p-8">
                        <h3 class="text-2xl font-semibold text-gray-900 mb-6 border-b border-gray-100 pb-4">Recent Orders</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50 rounded-t-xl">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date & Delivery</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($orders->take(10) as $order)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                <div>{{ $order->created_at->format('M d, Y') }}</div>
                                                @if($order->delivery_date)
                                                    <div class="text-xs text-blue-600 font-medium mt-1">Delivery: {{ \Carbon\Carbon::parse($order->delivery_date)->format('M d') }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 capitalize">
                                                    {{ $order->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Live Chat Inbox -->
                <div class="lg:col-span-1">
                    <div x-data="adminChat()" class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 flex flex-col h-[800px]">
                        <div class="p-6 bg-blue-600 text-white rounded-t-[2rem]">
                            <h3 class="text-xl font-bold flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                                Support Inbox
                            </h3>
                            <p class="text-blue-100 text-sm mt-1">Live customer conversations</p>
                        </div>

                        <!-- Active Users List -->
                        <div class="flex-1 overflow-y-auto" x-show="!selectedUser">
                            @foreach($users->where('role', '!=', 'admin') as $user)
                                <button @click="selectUser({{ $user->id }}, '{{ $user->name }}')" class="w-full text-left p-4 border-b border-gray-100 hover:bg-gray-50 transition flex items-center justify-between animate-fade-in">
                                    <div class="flex items-center">
                                        <div class="relative mr-4">
                                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <span x-show="unreadUsers[{{ $user->id }}] > 0" class="absolute -top-1 -right-1 w-3 h-3 bg-orange-500 rounded-full border-2 border-white animate-ping"></span>
                                            <span x-show="unreadUsers[{{ $user->id }}] > 0" class="absolute -top-1 -right-1 w-3 h-3 bg-orange-500 rounded-full border-2 border-white"></span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span x-show="unreadUsers[{{ $user->id }}] > 0" x-text="unreadUsers[{{ $user->id }}]" class="bg-orange-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full"></span>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </button>
                            @endforeach
                        </div>

                        <!-- Chat with Specific User -->
                        <div class="flex-1 flex flex-col hidden" x-show="selectedUser" :class="selectedUser ? '!flex' : 'hidden'">
                            <div class="bg-gray-50 p-4 border-b border-gray-100 flex items-center">
                                <button @click="selectedUser = null" class="text-gray-500 hover:text-gray-900 mr-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                                <div class="font-semibold text-gray-900" x-text="'Chatting with ' + selectedUserName"></div>
                            </div>
                            
                            <div id="admin-chat-messages" class="flex-1 p-4 overflow-y-auto space-y-4 bg-white">
                                <template x-for="msg in messages" :key="msg.id">
                                    <div :class="msg.is_admin ? 'text-right' : 'text-left'">
                                        <div :class="msg.is_admin ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-800'" class="inline-block px-4 py-2 rounded-2xl max-w-[85%] text-sm shadow-sm break-words" x-text="msg.content"></div>
                                    </div>
                                </template>
                            </div>

                            <div class="p-4 bg-gray-50 border-t border-gray-100">
                                <form @submit.prevent="sendMessage" class="flex space-x-2">
                                    <input x-model="newMessage" type="text" class="flex-1 border-gray-200 rounded-full px-4 py-3 text-sm focus:ring-blue-500 focus:border-blue-500 bg-white shadow-sm" placeholder="Reply to customer...">
                                    <button type="submit" class="bg-blue-600 text-white rounded-full p-3 hover:bg-blue-700 transition" :disabled="!newMessage.trim()">
                                        <svg class="w-5 h-5 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.addEventListener('alpine:init', () => {
                            Alpine.data('adminChat', () => ({
                                selectedUser: null,
                                selectedUserName: '',
                                messages: [],
                                newMessage: '',
                                adminId: {{ Auth::id() }},
                                unreadUsers: {},
                                
                                init() {
                                    this.unreadUsers = {};
                                    // Subscribe to global admin chat notifications
                                    if (window.Echo) {
                                        window.Echo.private('admin.chat')
                                            .listen('MessageSent', (e) => {
                                                if (!e.message.is_admin) {
                                                    // If we are currently chatting with this user:
                                                    if (this.selectedUser === e.message.user_id) {
                                                        this.messages.push(e.message);
                                                        this.scrollToBottom();
                                                    } else {
                                                        // Increment unread count
                                                        this.unreadUsers[e.message.user_id] = (this.unreadUsers[e.message.user_id] || 0) + 1;
                                                    }
                                                }
                                            });
                                    }
                                },

                                selectUser(id, name) {
                                    this.selectedUser = id;
                                    this.selectedUserName = name;
                                    this.messages = [];
                                    this.unreadUsers[id] = 0; // Clear unread!
                                    
                                    axios.get('/messages/' + id).then(res => {
                                        this.messages = res.data;
                                        this.scrollToBottom();
                                    });
                                },

                                sendMessage() {
                                    if (!this.newMessage.trim() || !this.selectedUser) return;
                                    
                                    const content = this.newMessage;
                                    this.newMessage = '';
                                    
                                    const tempId = Date.now();
                                    this.messages.push({ id: tempId, content: content, is_admin: true });
                                    this.scrollToBottom();

                                    axios.post('/messages', { user_id: this.selectedUser, content: content }).then(res => {
                                        const idx = this.messages.findIndex(m => m.id === tempId);
                                        if (idx !== -1) this.messages[idx] = res.data;
                                    });
                                },

                                scrollToBottom() {
                                    setTimeout(() => {
                                        const container = document.getElementById('admin-chat-messages');
                                        if (container) container.scrollTop = container.scrollHeight;
                                    }, 100);
                                }
                            }));
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
