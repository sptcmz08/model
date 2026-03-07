@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Featured Products -->
    @if($featuredProducts->count() > 0)
        <section class="products-section" style="padding-top: 3rem;">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('Featured Products') }}</h2>
                    <p>{{ __('Highly sought-after models') }}</p>
                    <div class="red-line"></div>
                </div>
                <div class="products-grid">
                    @foreach($featuredProducts as $product)
                        <div class="product-card">
                            <a href="{{ route('products.show', $product->slug) }}" class="product-image">
                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}">
                                @if($product->is_featured)
                                    <span class="product-badge">SALE!</span>
                                @endif
                            </a>
                            <div class="product-info">
                                <h3 class="product-name">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <div class="product-footer">
                                    <span class="product-price">{{ $product->formatted_price }}</span>
                                    <button class="btn-select-options"
                                        onclick="window.location.href='{{ route('products.show', $product->slug) }}'">
                                        <i class="fas fa-check"></i> SELECT OPTIONS
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="section-cta">
                    <a href="{{ route('products.index') }}" class="btn btn-outline">{{ __('View All Products') }}</a>
                </div>
            </div>
        </section>
    @endif

    <!-- Latest Products -->
    @if($latestProducts->count() > 0)
        <section class="products-section" style="background: var(--secondary-dark);">
            <div class="container">
                <div class="section-header">
                    <h2>{{ __('New Arrivals') }}</h2>
                    <p>{{ __('Latest additions to our collection') }}</p>
                    <div class="red-line"></div>
                </div>
                <div class="products-grid">
                    @foreach($latestProducts as $product)
                        <div class="product-card">
                            <a href="{{ route('products.show', $product->slug) }}" class="product-image">
                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}">
                                <span class="product-badge new">New</span>
                            </a>
                            <div class="product-info">
                                <h3 class="product-name">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <div class="product-footer">
                                    <span class="product-price">{{ $product->formatted_price }}</span>
                                    <button class="btn-select-options"
                                        onclick="window.location.href='{{ route('products.show', $product->slug) }}'">
                                        <i class="fas fa-check"></i> SELECT OPTIONS
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('styles')
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-family: 'Inter', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            color: #111;
        }

        .section-header p {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .red-line {
            width: 60px;
            height: 4px;
            background: var(--brand-red);
            margin: 0 auto;
        }

        /* Products Display */
        .products-section {
            padding: 4rem 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: #fff;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .product-image {
            display: block;
            position: relative;
            aspect-ratio: 1;
            overflow: hidden;
            background: #f9f9f9;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-badge {
            position: absolute;
            top: 10px;
            left: 0;
            padding: 5px 12px;
            background: var(--brand-red);
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
            letter-spacing: 1px;
        }

        .product-badge.new {
            background: #111;
            color: #fff;
        }

        .product-info {
            padding: 1.5rem 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex-grow: 1;
        }

        .product-name {
            margin: 0 0 0.5rem;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            line-height: 1.4;
            color: #111;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-name a {
            color: #111;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .product-name a:hover {
            color: var(--brand-red);
        }

        .product-footer {
            margin-top: auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .product-price {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--brand-red);
            font-family: 'Inter', sans-serif;
        }

        .btn-select-options {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #111;
            border: 1px solid #ddd;
            font-weight: 600;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: 0.5px;
        }

        .btn-select-options:hover {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        .btn-outline {
            padding: 12px 30px;
            border: 1px solid #ccc;
            color: #555;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            font-size: 0.9rem;
        }

        .btn-outline:hover {
            border-color: #111;
            color: #111;
        }

        .section-cta {
            text-align: center;
            margin-top: 3rem;
        }
    </style>
@endpush