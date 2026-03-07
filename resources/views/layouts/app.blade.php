<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - tattooink12studio.com</title>
    <meta name="description" content="Premium Custom Models & Figures for Collectors - tattooink12studio.com">
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
    <style>
        :root {
            /* Theme: White, Clean, Minimal */
            --primary-dark: #ffffff;
            --secondary-dark: #f5f5f5;
            --tertiary-dark: #eeeeee;

            --brand-red: #E60914;
            --brand-red-light: #ff1f1f;
            --brand-red-dark: #b30000;

            --text-primary: #111111;
            --text-secondary: #555555;
            --text-muted: #888888;

            --border-color: rgba(0, 0, 0, 0.1);
            --card-bg: #ffffff;

            --gradient-red: linear-gradient(135deg, #8a060d 0%, #E60914 100%);
            --button-radius: 0px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-dark);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .header.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 0.5rem 0;
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .logo-image-img {
            max-height: 80px;
            width: auto;
            border-radius: 5px;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
        }

        .logo-title {
            font-family: 'Inter', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            line-height: 1.2;
            color: #111;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .logo-subtitle {
            font-size: 0.7rem;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .nav-menu {
            display: flex;
            gap: 2rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-link {
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--brand-red);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--brand-red);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .cart-btn {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: var(--text-primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .cart-btn:hover {
            background: var(--brand-red);
            border-color: var(--brand-red);
            color: #fff;
        }

        .cart-icon-wrap {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--brand-red);
            color: #fff;
            font-size: 0.7rem;
            font-weight: bold;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 6px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            margin-left: 1.5rem;
        }

        .mobile-toggle span {
            width: 30px;
            height: 2px;
            background: #333;
            transition: all 0.3s ease;
        }

        .main-content {
            flex: 1;
            padding-top: 85px;
        }

        /* Footer */
        .footer {
            background: #111;
            border-top: 1px solid var(--border-color);
            padding: 5rem 0 2rem;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 4rem;
            padding: 0 2rem;
        }

        .footer-brand h3 {
            font-family: 'Inter', sans-serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .footer-links h4 {
            color: #fff;
            margin-bottom: 1.5rem;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 1rem;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            color: var(--brand-red);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-links a:hover {
            background: var(--brand-red);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 3rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #777;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .mobile-toggle {
                display: flex;
            }

            .nav-menu {
                display: none;
                position: fixed;
                top: 80px;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                padding: 2rem;
                text-align: center;
                border-top: 1px solid var(--border-color);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .nav-menu.active {
                display: flex;
            }

            .header-container {
                padding: 1rem;
            }

            .logo-image-img {
                max-height: 50px;
            }

            .logo-title {
                font-size: 1rem;
            }
        }

        /* IG Cards in Footer */
        .ig-links {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            margin-top: 1.25rem;
        }

        .ig-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.9rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .ig-card:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(225, 48, 108, 0.4);
            transform: translateX(4px);
        }

        .ig-icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .ig-icon-wrap i {
            color: #fff;
            font-size: 1rem;
        }

        .ig-info {
            display: flex;
            flex-direction: column;
        }

        .ig-handle {
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .ig-label {
            color: #888;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">
                @php
                    $siteLogo = \App\Models\Banner::where('is_active', true)->orderBy('order')->first();
                @endphp
                <img src="{{ $siteLogo ? $siteLogo->image_url : asset('images/logo_new.jpg') }}"
                    alt="tattooink12studio.com" class="logo-image-img">
                <div class="logo-text">
                    <span class="logo-title">TATTOOINK12STUDIO</span>
                </div>
            </a>

            <nav>
                <ul class="nav-menu" id="navMenu">
                    <li><a href="{{ route('home') }}"
                            class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('products.index') }}"
                            class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">{{ __('Products') }}</a>
                    </li>
                    <li><a href="{{ route('about') }}"
                            class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">{{ __('About') }}</a>
                    </li>
                    <li><a href="{{ route('contact') }}"
                            class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">{{ __('Contact') }}</a>
                    </li>
                </ul>
            </nav>

            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <!-- Language Switcher -->
                <div class="lang-switch" style="display: flex; gap: 0.8rem; align-items: center;">
                    <a href="{{ route('lang.switch', 'th') }}"
                        style="opacity: {{ App::getLocale() == 'th' ? '1' : '0.4' }}; transition: opacity 0.3s; filter: {{ App::getLocale() == 'th' ? 'none' : 'grayscale(100%)' }};">
                        <img src="https://flagcdn.com/w40/th.png" alt="TH"
                            style="width: 24px; height: auto; display: block; border-radius: 2px;">
                    </a>
                    <div style="width: 1px; height: 16px; background-color: rgba(0,0,0,0.15);"></div>
                    <a href="{{ route('lang.switch', 'en') }}"
                        style="opacity: {{ App::getLocale() == 'en' ? '1' : '0.4' }}; transition: opacity 0.3s; filter: {{ App::getLocale() == 'en' ? 'none' : 'grayscale(100%)' }};">
                        <img src="https://flagcdn.com/w40/gb.png" alt="EN"
                            style="width: 24px; height: auto; display: block; border-radius: 2px;">
                    </a>
                </div>

                <a href="{{ route('cart.index') }}" class="cart-btn">
                    <span class="cart-icon-wrap">
                        <i class="fas fa-shopping-bag"></i>
                        @php
                            $cartService = app(\App\Services\CartService::class);
                            $cartCount = $cartService->getItemCount();
                            $cartTotal = $cartService->getTotal();
                        @endphp
                        @if($cartCount > 0)
                            <span class="cart-count">{{ $cartCount }}</span>
                        @endif
                    </span>
                    <span>{{ __('CART') }}</span>
                    <span id="cart-total-header" style="font-size: 0.9rem; font-weight: 600; margin-left: 5px;">
                        ${{ number_format($cartTotal, 2) }}
                    </span>
                </a>
                <button class="mobile-toggle" id="mobileToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: "{{ session('success') }}",
                        background: '#fff',
                        color: '#111',
                        confirmButtonColor: '#E60914'
                    });
                });
            </script>
        @endif
        @if(session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: "{{ session('error') }}",
                        background: '#fff',
                        color: '#111',
                        confirmButtonColor: '#E60914'
                    });
                });
            </script>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>TATTOOINK12STUDIO</h3>
                <p style="color: #aaa;">{{ __('Painter 1/12-1/6 | PM for Commission | Shipped Worldwide') }}</p>
                <div class="ig-links">
                    <a href="https://www.instagram.com/tattoo.fett" target="_blank" class="ig-card">
                        <div class="ig-icon-wrap"><i class="fab fa-instagram"></i></div>
                        <div class="ig-info">
                            <span class="ig-handle">@tattoo.fett</span>
                            <span class="ig-label">Instagram</span>
                        </div>
                    </a>
                    <a href="https://www.facebook.com/Tattooink12studio/" target="_blank" class="ig-card">
                        <div class="ig-icon-wrap" style="background: linear-gradient(135deg, #1877F2, #0a5dc2);"><i
                                class="fab fa-facebook-f"></i></div>
                        <div class="ig-info">
                            <span class="ig-handle">Tattooink12studio</span>
                            <span class="ig-label">Facebook</span>
                        </div>
                    </a>
                    <a href="https://www.youtube.com/@tattooink12studio" target="_blank" class="ig-card">
                        <div class="ig-icon-wrap" style="background: linear-gradient(135deg, #FF0000, #cc0000);"><i
                                class="fab fa-youtube"></i></div>
                        <div class="ig-info">
                            <span class="ig-handle">Tattooink12studio</span>
                            <span class="ig-label">YouTube</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="footer-links">
                <h4>{{ __('Quick Links') }}</h4>
                <ul>
                    <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('products.index') }}">{{ __('Products') }}</a></li>
                    <li><a href="{{ route('about') }}">{{ __('About') }}</a></li>
                    <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>{{ __('Categories') }}</h4>
                <ul>
                    @php
                        $footerCategories = \App\Models\Category::active()->get();
                    @endphp
                    @foreach($footerCategories as $category)
                        <li><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-links">
                <h4>{{ __('Contact Info') }}</h4>
                <ul>
                    <li style="color: #aaa; line-height: 1.6;">
                        <i class="fas fa-map-marker-alt"
                            style="width: 20px; color: var(--brand-red); vertical-align: top;"></i>
                        Phanupong Pukcharoen<br>
                        <span style="margin-left: 20px;">Sket Town Tiwanon Rangsit</span><br>
                        <span style="margin-left: 20px;">189/76 Moo 4, Ban Klang Subdistrict</span><br>
                        <span style="margin-left: 20px;">Mueang Pathum Thani District</span><br>
                        <span style="margin-left: 20px;">Pathum Thani Province 12000</span><br>
                        <span style="margin-left: 20px;">Thailand</span>
                    </li>
                    <li style="color: #aaa; margin-top: 0.8rem;"><i class="fas fa-envelope"
                            style="width: 20px; color: var(--brand-red);"></i> <a href="mailto:nattawut4085@gmail.com"
                            style="color: #aaa;">nattawut4085@gmail.com</a></li>
                    <li style="color: #aaa;"><i class="fas fa-phone" style="width: 20px; color: var(--brand-red);"></i>
                        065-445-0919 (Film)</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} tattooink12studio.com. {{ __('All rights reserved.') }}</p>
        </div>
    </footer>

    <script>
        // Header Scroll Effect
        window.addEventListener('scroll', function () {
            const header = document.querySelector('.header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const navMenu = document.getElementById('navMenu');

        // Cookie Consent Logic
        const cookieBanner = document.getElementById('cookieDataBanner');
        const acceptCookieBtn = document.getElementById('acceptCookieBtn');

        if (cookieBanner && !localStorage.getItem('cookieConsent')) {
            setTimeout(() => {
                cookieBanner.classList.add('show');
            }, 1000);
        }

        if (acceptCookieBtn) {
            acceptCookieBtn.addEventListener('click', function () {
                localStorage.setItem('cookieConsent', 'true');
                cookieBanner.classList.remove('show');
            });
        }

        if (mobileToggle) {
            mobileToggle.addEventListener('click', function () {
                navMenu.classList.toggle('active');

                // Animate hamburger
                const spans = this.querySelectorAll('span');
                if (navMenu.classList.contains('active')) {
                    spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                    spans[1].style.opacity = '0';
                    spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
                } else {
                    spans[0].style.transform = 'none';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'none';
                }
            });
        }
    </script>

    <!-- Cookie Consent Banner -->
    <div id="cookieDataBanner" class="cookie-banner" style="
        position: fixed;
        bottom: -100%;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(10px);
        border-top: 1px solid var(--border-color);
        padding: 1.5rem 2rem;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        transition: bottom 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 -10px 40px rgba(0,0,0,0.1);
    ">
        <div
            style="max-width: 800px; display: flex; align-items: center; gap: 2rem; flex-wrap: wrap; justify-content: center;">
            <div style="flex: 1; min-width: 300px;">
                <h4 style="color: #111; margin-bottom: 0.5rem; font-family: 'Inter', sans-serif; font-weight: 600;">
                    <i class="fas fa-cookie-bite"></i> COOKIE POLICY
                </h4>
                <p style="color: var(--text-secondary); font-size: 0.9rem; line-height: 1.5;">
                    This website uses cookies to enhance your experience.
                </p>
            </div>
            <button id="acceptCookieBtn" style="
                background: var(--gradient-red);
                color: white;
                border: none;
                padding: 0.8rem 2rem;
                font-weight: 600;
                cursor: pointer;
                text-transform: uppercase;
                letter-spacing: 1px;
                transition: transform 0.2s;
            " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                ACCEPT
            </button>
        </div>
    </div>

    <style>
        .cookie-banner.show {
            bottom: 0 !important;
        }
    </style>
    @stack('scripts')
</body>

</html>