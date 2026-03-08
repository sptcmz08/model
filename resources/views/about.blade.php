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
                    @if(isset($aboutImages) && $aboutImages->count() >= 2)
                        <div class="dual-image-stack">
                            <div class="stack-img stack-img-1">
                                <img src="{{ $aboutImages[0]->image_url }}" alt="Our Work 1">
                            </div>
                            <div class="stack-img stack-img-2">
                                <img src="{{ $aboutImages[1]->image_url }}" alt="Our Work 2">
                            </div>
                        </div>
                    @elseif(isset($aboutImages) && $aboutImages->count() == 1)
                        <div class="image-frame">
                            <img src="{{ $aboutImages[0]->image_url }}" alt="Our Work">
                        </div>
                    @else
                        <div class="image-frame">
                            <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600" alt="Workshop">
                        </div>
                    @endif

                </div>
                <div class="about-content">
                    <h2>{{ __('Our Story') }}</h2>
                    <div class="gold-line" style="margin: 1rem 0 2rem;"></div>
                    <p>Welcome to <strong>tattooink12studio.com</strong>, your destination for custom-painted
                        collectible figures in scales 1/12 and 1/6. We specialize in hand-painted head sculpts,
                        part kits, art toys, and 3D printed collectibles.</p>


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

        /* Dual Overlapping Images */
        .dual-image-stack {
            position: relative;
            width: 100%;
            height: 520px;
        }

        .stack-img {
            position: absolute;
            border-radius: 16px;
            overflow: hidden;
            border: 4px solid #fff;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .stack-img:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
        }

        .stack-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .stack-img-1 {
            top: 0;
            left: 0;
            width: 65%;
            height: 340px;
            z-index: 2;
        }

        .stack-img-2 {
            bottom: 0;
            right: 0;
            width: 65%;
            height: 340px;
            z-index: 1;
        }

        /* Single Image Fallback */
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



        @media (max-width: 992px) {
            .about-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .dual-image-stack {
                height: 420px;
            }

            .stack-img-1 {
                height: 280px;
            }

            .stack-img-2 {
                height: 280px;
            }


        }

        @media (max-width: 768px) {
            .page-hero-content h1 {
                font-size: 2rem;
            }

            .dual-image-stack {
                height: 350px;
            }

            .stack-img-1 {
                height: 230px;
            }

            .stack-img-2 {
                height: 230px;
            }
        }
    </style>
@endpush