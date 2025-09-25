<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 via-white to-gray-100 px-4">
        <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md text-center">
            
            <!-- User Icon -->
            <div class="flex justify-center mb-6">
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-blue-600 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A9 9 0 1117.804 5.121M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-900">Welcome Back</h2>
            <p class="mt-1 text-sm text-gray-500">Sign in to your account</p>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5 text-left">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12H8m8 0a8 8 0 11-16 0 8 8 0 0116 0z" />
                        </svg>
                    </span>
                    <input id="email" type="email" name="email" required autofocus
                        class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-md placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your email">
                    <!-- Right Icon -->
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                            viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="2" />
                            <circle cx="4" cy="10" r="2" />
                            <circle cx="16" cy="10" r="2" />
                        </svg>
                    </span>
                </div>

                <!-- Password -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0-1.105-.895-2-2-2s-2 .895-2 2v1h4v-1zM6 20h12V10H6v10z" />
                        </svg>
                    </span>
                    <input id="password" type="password" name="password" required
                        class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-md placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Enter your password">
                    <!-- Eye Icon -->
                    <button type="button" onclick="togglePassword()" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <!-- Sign In Button -->
                <button type="submit"
                    class="w-full py-3 rounded-md font-medium text-white shadow-md bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Sign In
                </button>
            </form>

            <!-- Sign Up Link -->
            <p class="mt-6 text-sm text-gray-600 text-center">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-500 font-medium">Sign up</a>
            </p>

            <!-- Footer -->
            <p class="mt-6 text-xs text-gray-500 text-center">
                By signing in, you agree to our
                <a href="#" class="text-blue-500 hover:underline">Terms of Service</a>
                and
                <a href="#" class="text-blue-500 hover:underline">Privacy Policy</a>.
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = document.getElementById("eyeIcon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.418 0-8.268-2.943-9.542-7a9.96 9.96 0 012.624-4.45M15 12a3 3 0 11-6 0 3 3 0 016 0z" />`;
            } else {
                passwordInput.type = "password";
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.522 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z" />`;
            }
        }
    </script>
</x-guest-layout>
