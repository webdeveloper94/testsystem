<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoTest - Haydovchilik Guvohnomasi Imtihoniga Tayyorgarlik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <style>
        .gradient-text {
            background: linear-gradient(45deg, #3b82f6, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        .bg-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239BA6B1' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-gray-900 bg-pattern min-h-screen">
    <div class="relative">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 bg-gray-900 bg-opacity-90 backdrop-blur-md border-b border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <i class="fas fa-car-alt text-blue-500 text-2xl mr-2"></i>
                        <span class="text-white text-xl font-bold">AutoTest</span>
                    </div>
                    <div class="flex items-center">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-300 ease-in-out transform hover:scale-105">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Kirish
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 sm:pt-40 sm:pb-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                    <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left" data-aos="fade-right">
                        <h1>
                            <span class="block text-sm font-semibold uppercase tracking-wide text-gray-500 sm:text-base lg:text-sm xl:text-base">
                                Haydovchilik Guvohnomasi
                            </span>
                            <span class="mt-1 block text-4xl tracking-tight font-extrabold sm:text-5xl xl:text-6xl">
                                <span class="block gradient-text">Imtihonga</span>
                                <span class="block text-blue-500">Tayyormisiz?</span>
                            </span>
                        </h1>
                        <p class="mt-3 text-base text-gray-400 sm:mt-5 sm:text-xl lg:text-lg xl:text-xl">
                            Bizning platforma orqali haydovchilik guvohnomasi imtihoniga mukammal tayyorlaning. 
                            Real imtihon sharoitiga maksimal yaqinlashtirilgan testlar, video darslar va amaliy mashg'ulotlar sizni kutmoqda.
                        </p>
                        <div class="mt-8 sm:max-w-lg sm:mx-auto sm:text-center lg:text-left">
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                                    <div class="bg-gray-800 p-4 rounded-lg">
                                        <i class="fas fa-book text-blue-500 text-2xl mb-2"></i>
                                        <p class="text-gray-300 text-sm">1000+ Testlar</p>
                                    </div>
                                </div>
                                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                                    <div class="bg-gray-800 p-4 rounded-lg">
                                        <i class="fas fa-video text-blue-500 text-2xl mb-2"></i>
                                        <p class="text-gray-300 text-sm">Video Darslar</p>
                                    </div>
                                </div>
                                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                                    <div class="bg-gray-800 p-4 rounded-lg">
                                        <i class="fas fa-certificate text-blue-500 text-2xl mb-2"></i>
                                        <p class="text-gray-300 text-sm">Sertifikat</p>
                                    </div>
                                </div>
                                <div class="text-center" data-aos="fade-up" data-aos-delay="400">
                                    <div class="bg-gray-800 p-4 rounded-lg">
                                        <i class="fas fa-mobile-alt text-blue-500 text-2xl mb-2"></i>
                                        <p class="text-gray-300 text-sm">Mobile</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                        <div class="relative mx-auto w-full rounded-lg lg:max-w-md">
                            <div class="relative block w-full bg-gray-800 rounded-lg overflow-hidden animate-float" data-aos="fade-left">
                                <img class="w-full" src="https://img.freepik.com/free-vector/driving-school-concept-illustration_114360-6288.jpg" alt="Driving School">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 bg-gray-800 bg-opacity-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl" data-aos="fade-up">
                        Nima uchun aynan bizni tanlaysiz?
                    </h2>
                </div>
                <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-gray-900 rounded-xl p-8 transform hover:scale-105 transition duration-300" data-aos="fade-up" data-aos-delay="100">
                        <div class="text-blue-500 text-4xl mb-4">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">24/7 Mavjud</h3>
                        <p class="text-gray-400">Istalgan vaqtda, istalgan joyda o'zingizga qulay tarzda mashg'ulotlarni davom ettiring.</p>
                    </div>
                    <div class="bg-gray-900 rounded-xl p-8 transform hover:scale-105 transition duration-300" data-aos="fade-up" data-aos-delay="200">
                        <div class="text-blue-500 text-4xl mb-4">
                            <i class="fas fa-sync"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Doimiy Yangilanish</h3>
                        <p class="text-gray-400">Bazamiz muntazam yangilanib turadi va eng so'nggi qoidalar bilan boyitiladi.</p>
                    </div>
                    <div class="bg-gray-900 rounded-xl p-8 transform hover:scale-105 transition duration-300" data-aos="fade-up" data-aos-delay="300">
                        <div class="text-blue-500 text-4xl mb-4">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Progress Analizi</h3>
                        <p class="text-gray-400">O'z bilimingizni kuzatib boring va tahlil qiling.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-900 border-t border-gray-800">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-gray-400 text-sm">
                        © 2024 AutoTest. Barcha huquqlar himoyalangan.
                    </p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
</body>
</html>
