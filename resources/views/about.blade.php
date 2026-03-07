@extends('layouts.app')

@section('title', __('About'))

@section('content')
    <!-- Hero Banner -->
    <section class="page-hero">
        <div class="page-hero-content">
            <h1>{{ __('About Us') }}</h1>
            <p>{{ __('Crafting Premium Custom Models Since Day One') }}</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-image">
                    <div class="image-frame">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600" alt="Workshop">
                    </div>
                    <div class="experience-badge">
                        <span class="number">10+</span>
                        <span class="text">{{ __('Years Experience') }}</span>
                    </div>
                </div>
                <div class="about-content">
                    <h2>{{ __('Our Story') }}</h2>
                    <div class="gold-line" style="margin: 1rem 0 2rem;"></div>
                    <p>Welcome to <strong>tattooink12studio.com</strong>, your destination for custom-painted
                        collectible figures in scales 1/12 and 1/6. We specialize in hand-painted head sculpts,
                        part kits, art toys, and 3D printed collectibles.</p>
                    <p>Every piece is meticulously hand-painted with attention to every detail by our skilled artist.
                        We accept commissions — just PM us on Instagram
                        <a href="https://www.instagram.com/tattoo.fett" target="_blank"
                            style="color: var(--brand-red); font-weight: 700; text-decoration: none;">@tattoo.fett</a>
                        to discuss your project.
                    </p>
                    <p>We ship worldwide via PayPal (Goods and Services) with secure packaging and full tracking.
                        Follow our backup accounts
                        <a href="https://www.instagram.com/custom_cry12" target="_blank"
                            style="color: var(--brand-red); font-weight: 700; text-decoration: none;">@custom_cry12</a> and
                        <a href="https://www.instagram.com/tattoo.collectibles" target="_blank"
                            style="color: var(--brand-red); font-weight: 700; text-decoration: none;">@tattoo.collectibles</a>
                        for more updates and exclusive content.
                    </p>

                    <div class="about-stats">
                        <div class="stat">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">{{ __('Custom Models Created') }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">50+</span>
                            <span class="stat-label">{{ __('Countries Shipped') }}</span>
                        </div>
                        <div class="stat">
                            <span class="stat-number">100%</span>
                            <span class="stat-label">{{ __('Customer Satisfaction') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .page-hero {
            height: 40vh;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: var(--secondary-dark);
            position: relative;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .page-hero-content h1 {
            font-family: 'Inter', sans-serif;
            font-size: 3rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 1rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .page-hero-content p {
            color: var(--text-secondary);
            font-size: 1.2rem;
        }

        .about-section {
            padding: 6rem 0;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-image {
            position: relative;
        }

        .image-frame {
            border-radius: 20px;
            overflow: hidden;
            border: 3px solid var(--border-color);
        }

        .image-frame img {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }

        .experience-badge {
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 150px;
            height: 150px;
            background: var(--gradient-red);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .experience-badge .number {
            font-family: 'Inter', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .experience-badge .text {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #fff;
        }

        .about-content h2 {
            font-family: 'Inter', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #111;
        }

        .about-content p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2.5rem;
            padding-top: 2.5rem;
            border-top: 1px solid var(--border-color);
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--brand-red);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        @media (max-width: 992px) {
            .about-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .experience-badge {
                right: 10px;
                bottom: -20px;
                width: 120px;
                height: 120px;
            }

            .experience-badge .number {
                font-size: 2rem;
            }

            .about-stats {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
        }

        @media (max-width: 768px) {
            .page-hero-content h1 {
                font-size: 2rem;
            }
        }
    </style>
@endpush