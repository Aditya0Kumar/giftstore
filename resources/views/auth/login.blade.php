<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6 text-center">
        <h2 class="font-serif text-2xl font-medium text-brand">Welcome Back</h2>
        <p class="text-xs text-muted mt-1 font-light">Please enter your details to sign in</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-brand">Email Address</label>
            <input id="email" 
                   type="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="username"
                   class="block mt-1.5 w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none shadow-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-brand">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-accent hover:text-brand transition duration-300" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" 
                   type="password" 
                   name="password" 
                   required 
                   autocomplete="current-password"
                   class="block mt-1.5 w-full bg-surface border border-border rounded-xl px-4 py-3 text-sm text-brand placeholder-muted focus:ring-1 focus:ring-accent focus:border-accent transition duration-300 outline-none shadow-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                       type="checkbox" 
                       name="remember"
                       class="rounded border-border text-accent focus:ring-accent shadow-sm">
                <span class="ms-2 text-xs text-muted font-light">Remember me</span>
            </label>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full bg-brand hover:bg-black text-white font-medium text-sm py-3 px-4 rounded-xl transition-all duration-300 shadow-md hover:-translate-y-0.5 active:translate-y-0">
                Sign In
            </button>
        </div>

        <div class="text-center pt-2">
            <p class="text-xs text-muted font-light">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-accent hover:text-brand font-medium transition duration-300">
                    Create an account
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>

