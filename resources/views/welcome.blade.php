<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coin Exmining - Investment Platform</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' rel='stylesheet'>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-pulse-slow {
            animation: pulse 2s ease-in-out infinite;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="bg-gray-50 antialiased">

    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-white/80 backdrop-blur-lg shadow-sm z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('/images/logo.jpg') }}" alt="Logo" class="w-10 h-10 rounded-lg">
                    <span class="text-xl font-bold text-gray-900">Coin Exmining</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="px-4 py-2 text-gray-700 hover:text-green-600 transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 text-gray-700 hover:text-green-600 transition-colors">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 bg-gradient-to-br from-green-50 via-blue-50 to-purple-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 animate-fadeInUp">
                        Invest in Your
                        <span class="bg-gradient-to-r from-green-600 to-blue-600 bg-clip-text text-transparent">
                            Digital Future
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 animate-fadeInUp delay-100">
                        Join thousands of investors earning consistent returns through our secure cryptocurrency mining
                        platform.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 animate-fadeInUp delay-200">
                        <a href="#features"
                            class="px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-semibold hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-center">
                            Learn More
                        </a>
                    </div>
                </div>

                <div class="relative animate-fadeInUp delay-300">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 rounded-3xl blur-3xl opacity-30 animate-pulse-slow">
                    </div>
                    <div class="relative bg-white rounded-3xl shadow-2xl p-8">
                        <div class="space-y-6">
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl">
                                <div>
                                    <p class="text-sm text-gray-600">Total Invested</p>
                                    <p class="text-2xl font-bold text-green-600">$2.5M+</p>
                                </div>
                                <i class="bi bi-graph-up-arrow text-3xl text-green-600"></i>
                            </div>
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl">
                                <div>
                                    <p class="text-sm text-gray-600">Active Users</p>
                                    <p class="text-2xl font-bold text-blue-600">12,500+</p>
                                </div>
                                <i class="bi bi-people text-3xl text-blue-600"></i>
                            </div>
                            <div
                                class="flex items-center justify-between p-4 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl">
                                <div>
                                    <p class="text-sm text-gray-600">Avg. Returns</p>
                                    <p class="text-2xl font-bold text-purple-600">15-25%</p>
                                </div>
                                <i class="bi bi-trophy text-3xl text-purple-600"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Animated Statistics -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center animate-fadeInUp">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full mb-4">
                        <i class="bi bi-currency-bitcoin text-3xl text-white"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2" data-count="50000">0</div>
                    <p class="text-gray-600">BTC Mined</p>
                </div>

                <div class="text-center animate-fadeInUp delay-100">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full mb-4">
                        <i class="bi bi-people-fill text-3xl text-white"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2" data-count="12500">0</div>
                    <p class="text-gray-600">Happy Users</p>
                </div>

                <div class="text-center animate-fadeInUp delay-200">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full mb-4">
                        <i class="bi bi-shield-check text-3xl text-white"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2" data-count="99">0</div>
                    <p class="text-gray-600">Uptime %</p>
                </div>

                <div class="text-center animate-fadeInUp delay-300">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full mb-4">
                        <i class="bi bi-lightning-fill text-3xl text-white"></i>
                    </div>
                    <div class="text-4xl font-bold text-gray-900 mb-2" data-count="2500">0</div>
                    <p class="text-gray-600">Daily Trades</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Us</h2>
                <p class="text-xl text-gray-600">Experience the future of cryptocurrency investment</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="bi bi-shield-lock text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Secure Platform</h3>
                    <p class="text-gray-600">Bank-level security with multi-layer encryption to protect your
                        investments.</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="bi bi-graph-up text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">High Returns</h3>
                    <p class="text-gray-600">Consistent returns of 15-25% through our advanced mining algorithms.</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="bi bi-clock-history text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">24/7 Support</h3>
                    <p class="text-gray-600">Round-the-clock customer support to assist you whenever you need.</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="bi bi-speedometer2 text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Fast Withdrawals</h3>
                    <p class="text-gray-600">Quick and easy withdrawal process with minimal fees.</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-pink-400 to-pink-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="bi bi-people text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Referral Program</h3>
                    <p class="text-gray-600">Earn extra rewards by inviting friends to join our platform.</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-xl flex items-center justify-center mb-6">
                        <i class="bi bi-phone text-2xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mobile Friendly</h3>
                    <p class="text-gray-600">Access your account anywhere, anytime from any device.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-green-600 to-blue-600">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Start Your Investment Journey?</h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Join thousands of investors who are already earning passive income through cryptocurrency mining.
            </p>
            <a href="{{ route('login') }}"
                class="inline-block px-12 py-4 bg-white text-green-600 rounded-lg font-bold text-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200">
                Login to Continue
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 bg-gray-900 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <img src="{{ asset('/images/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded">
                        <span class="text-lg font-bold">Coin Exmining</span>
                    </div>
                    <p class="text-gray-400">Your trusted cryptocurrency investment platform.</p>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Resources</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-green-600 transition-colors">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Coin Exmining. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Animated Counter
        function animateCounter(element) {
            const target = parseInt(element.getAttribute('data-count'));
            const duration = 2000;
            const increment = target / (duration / 16);
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    element.textContent = Math.floor(current).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = target.toLocaleString();
                }
            };

            updateCounter();
        }

        // Intersection Observer for counter animation
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = entry.target.querySelectorAll('[data-count]');
                    counters.forEach(counter => {
                        if (counter.textContent === '0') {
                            animateCounter(counter);
                        }
                    });
                }
            });
        }, observerOptions);

        // Observe the statistics section
        document.addEventListener('DOMContentLoaded', () => {
            const statsSection = document.querySelector('.py-16.bg-white');
            if (statsSection) {
                observer.observe(statsSection);
            }
        });
    </script>
</body>

</html>
