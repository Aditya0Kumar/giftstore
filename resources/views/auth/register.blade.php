<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="font-serif text-2xl font-medium text-brand">Create Account</h2>
        <p class="text-xs text-muted mt-1 font-light">Join GiftStore to personalize your shopping experience</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-brand">Name</label>
            <input id="name" 
                   type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autofocus 
                   autocomplete="name"
                   class="block mt-1.5 w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none shadow-sm">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-brand">Email Address</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="username"
                   class="block mt-1.5 w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none shadow-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-brand">Password</label>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="new-password"
                   class="block mt-1.5 w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none shadow-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-brand">Confirm Password</label>
            <input id="password_confirmation" 
                   type="password" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password"
                   class="block mt-1.5 w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none shadow-sm">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit" class="w-full bg-brand hover:bg-black text-white font-medium text-sm py-3 px-4 rounded-xl transition-all duration-300 shadow-md hover:-translate-y-0.5 active:translate-y-0">
                Register
            </button>
        </div>

        <div class="text-center pt-2">
            <p class="text-xs text-muted font-light">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-accent hover:text-brand font-medium transition duration-300">
                    Sign in instead
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

