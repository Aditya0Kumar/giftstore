<x-app-layout>
    <div class="py-12 bg-[#FBFBFD] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Back navigation -->
            <div class="mb-6">
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-sm font-medium text-muted hover:text-brand transition duration-300">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Back to Products
                </a>
            </div>

            <!-- Header Section -->
            <div class="mb-10 flex justify-between items-start">
                <div>
                    <h2 class="text-4xl font-semibold text-gray-900 tracking-tight">Edit Product: {{ $product->name }}</h2>
                    <p class="mt-2 text-lg text-gray-500 font-light">Update basic information, specs, dynamic customization fields, and pricing rules.</p>
                </div>
                <div class="w-24 h-24 bg-gray-50 border border-gray-100 rounded-2xl overflow-hidden flex-shrink-0 flex items-center justify-center shadow-md">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover w-full h-full">
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                @if(session('error'))
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Section 1: Basic Information -->
                <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 p-8 space-y-6">
                    <h3 class="text-xl font-semibold text-gray-900 border-b border-gray-100 pb-4">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-brand mb-2">Product Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required 
                                   class="w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none">
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div>
                            <label for="category" class="block text-xs font-semibold uppercase tracking-wider text-brand mb-2">Category</label>
                            <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" required list="category-list"
                                   class="w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none">
                            <datalist id="category-list">
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">
                                @endforeach
                            </datalist>
                            <x-input-error :messages="$errors->get('category')" class="mt-1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="base_price" class="block text-xs font-semibold uppercase tracking-wider text-brand mb-2">Base Price (₹)</label>
                            <input type="number" step="0.01" name="base_price" id="base_price" value="{{ old('base_price', $product->base_price) }}" required 
                                   class="w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none">
                            <x-input-error :messages="$errors->get('base_price')" class="mt-1" />
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-brand mb-2">Product Image Source</label>
                            <div class="space-y-3">
                                <div>
                                    <input type="file" name="image" id="image" accept="image/*"
                                           class="text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-brand hover:file:bg-gray-200 file:cursor-pointer transition">
                                </div>
                                <div class="flex items-center text-xs text-gray-400">
                                    <span class="border-t border-gray-200 flex-grow h-px mr-3"></span>
                                    <span>OR</span>
                                    <span class="border-t border-gray-200 flex-grow h-px ml-3"></span>
                                </div>
                                <div>
                                    <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $product->image_url) }}" placeholder="External Image URL (e.g. /images/products/mug.png)"
                                           class="w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none">
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('image')" class="mt-1" />
                            <x-input-error :messages="$errors->get('image_url')" class="mt-1" />
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-semibold uppercase tracking-wider text-brand mb-2">Description</label>
                        <textarea name="description" id="description" rows="4" required 
                                  class="w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none">{{ old('description', $product->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1" />
                    </div>
                </div>

                <!-- Section 2: Technical Specifications -->
                <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 p-8 space-y-6"
                     x-data="{ specs: {{ json_encode(old('spec_keys') ? array_map(function($k, $v) { return ['key' => $k, 'value' => $v]; }, old('spec_keys'), old('spec_values')) : (array_map(function($k, $v) { return ['key' => $k, 'value' => $v]; }, array_keys($product->specifications ?? []), array_values($product->specifications ?? [])))) }} }">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Specifications</h3>
                        <button type="button" @click="specs.push({ key: '', value: '' })" 
                                class="text-xs font-semibold text-accent hover:text-brand transition flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Specification
                        </button>
                    </div>

                    <p class="text-xs text-gray-400 font-light">Key-value characteristics shown on the product page (e.g. Material: Ceramic, Weight: 300g).</p>

                    <div class="space-y-3">
                        <template x-for="(spec, index) in specs" :key="index">
                            <div class="flex items-center space-x-4 animate-fade-in">
                                <div class="flex-1">
                                    <input type="text" name="spec_keys[]" x-model="spec.key" required placeholder="Label (e.g. Dimensions)"
                                           class="w-full bg-surface border border-border rounded-xl px-4 py-3.5 text-xs text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none">
                                </div>
                                <div class="flex-1">
                                    <input type="text" name="spec_values[]" x-model="spec.value" required placeholder="Value (e.g. 10 x 15 cm)"
                                           class="w-full bg-surface border border-border rounded-xl px-4 py-3.5 text-xs text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none">
                                </div>
                                <button type="button" @click="specs.splice(index, 1)" class="p-2 text-gray-400 hover:text-red-500 rounded-lg hover:bg-gray-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Section 3: Customization Options -->
                <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 p-8 space-y-6"
                     x-data="{ options: {{ json_encode(old('options') ?? array_map(function($opt) { return ['name' => $opt['name'], 'type' => $opt['type'], 'values' => is_array($opt['values']) ? implode(', ', $opt['values']) : ($opt['values'] ?? '')]; }, $product->customizationOptions->toArray())) }} }">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Customization Fields</h3>
                        <button type="button" @click="options.push({ name: '', type: 'text', values: '' })" 
                                class="text-xs font-semibold text-accent hover:text-brand transition flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Custom Field
                        </button>
                    </div>

                    <p class="text-xs text-gray-400 font-light">Fields the customer must complete to personalize their item. For dropdown selections, provide comma-separated values.</p>

                    <div class="space-y-4">
                        <template x-for="(opt, index) in options" :key="index">
                            <div class="border border-border p-5 rounded-2xl bg-surface relative animate-fade-in">
                                <button type="button" @click="options.splice(index, 1)" class="absolute top-4 right-4 p-1.5 text-gray-400 hover:text-red-500 rounded-lg hover:bg-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-brand mb-1">Option Name (e.g. Choose Color)</label>
                                        <input type="text" :name="'options['+index+'][name]'" x-model="opt.name" required placeholder="Option Name"
                                               class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-xs text-brand focus:ring-1 focus:ring-accent focus:border-accent transition outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-brand mb-1">Field Type</label>
                                        <select :name="'options['+index+'][type]'" x-model="opt.type"
                                                class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-xs text-brand focus:ring-1 focus:ring-accent focus:border-accent transition outline-none">
                                            <option value="text">Single Line Text</option>
                                            <option value="material">Material Selection</option>
                                            <option value="color">Color Swatch</option>
                                            <option value="size">Size Selection</option>
                                            <option value="finish">Finish Selection</option>
                                            <option value="image">Photo Upload</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-4" x-show="opt.type !== 'text' && opt.type !== 'image'">
                                    <label class="block text-[10px] font-bold uppercase tracking-wider text-brand mb-1">Allowed Choices (comma-separated values)</label>
                                    <input type="text" :name="'options['+index+'][values]'" x-model="opt.values" placeholder="e.g. Red, Blue, White, Black"
                                           class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-xs text-brand focus:ring-1 focus:ring-accent focus:border-accent transition outline-none">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Section 4: Dynamic Pricing Rules -->
                <div class="bg-white overflow-hidden shadow-sm rounded-[2rem] border border-gray-100 p-8 space-y-6"
                     x-data="{ rules: {{ json_encode(old('rules') ?? $product->pricingRules->toArray()) }} }">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                        <h3 class="text-xl font-semibold text-gray-900">Dynamic Pricing Rules</h3>
                        <button type="button" @click="rules.push({ condition_key: '', operator: '=', condition_value: '', price_adjustment: 0.0, type: 'fixed' })" 
                                class="text-xs font-semibold text-accent hover:text-brand transition flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Add Pricing Rule
                        </button>
                    </div>

                    <p class="text-xs text-gray-400 font-light">Alter base price based on options filled by user (e.g. if Material = metal, add ₹100; if text length > 10, add ₹50).</p>

                    <div class="space-y-4">
                        <template x-for="(rule, index) in rules" :key="index">
                            <div class="border border-border p-5 rounded-2xl bg-surface relative animate-fade-in">
                                <button type="button" @click="rules.splice(index, 1)" class="absolute top-4 right-4 p-1.5 text-gray-400 hover:text-red-500 rounded-lg hover:bg-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-brand mb-1">Condition Option Name</label>
                                        <input type="text" :name="'rules['+index+'][condition_key]'" x-model="rule.condition_key" required placeholder="e.g. material / Custom Text"
                                               class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-xs text-brand focus:ring-1 focus:ring-accent focus:border-accent transition outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-brand mb-1">Operator</label>
                                        <select :name="'rules['+index+'][operator]'" x-model="rule.operator"
                                                class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-xs text-brand focus:ring-1 focus:ring-accent focus:border-accent transition outline-none">
                                            <option value="=">Equals (=)</option>
                                            <option value=">">Greater than (&gt;)</option>
                                            <option value="<">Less than (&lt;)</option>
                                            <option value="text_length>">Text Length Greater than (text_length &gt;)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-brand mb-1">Condition Target Value</label>
                                        <input type="text" :name="'rules['+index+'][condition_value]'" x-model="rule.condition_value" required placeholder="e.g. steel / 10"
                                               class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-xs text-brand focus:ring-1 focus:ring-accent focus:border-accent transition outline-none">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-brand mb-1">Price Adjustment</label>
                                        <input type="number" step="0.01" :name="'rules['+index+'][price_adjustment]'" x-model="rule.price_adjustment" required placeholder="e.g. 150"
                                               class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-xs text-brand focus:ring-1 focus:ring-accent focus:border-accent transition outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold uppercase tracking-wider text-brand mb-1">Adjustment Type</label>
                                        <select :name="'rules['+index+'][type]'" x-model="rule.type"
                                                class="w-full bg-white border border-border rounded-xl px-4 py-2.5 text-xs text-brand focus:ring-1 focus:ring-accent focus:border-accent transition outline-none">
                                            <option value="fixed">Fixed Price Adjustment</option>
                                            <option value="percentage">Percentage adjustment</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.products.index') }}" class="bg-white border border-border text-brand font-medium text-sm px-6 py-3.5 rounded-xl hover:bg-surface transition duration-300">
                        Cancel
                    </a>
                    <button type="submit" class="bg-brand hover:bg-black text-white font-medium text-sm px-8 py-3.5 rounded-xl transition duration-300 shadow-md">
                        Update Product
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
