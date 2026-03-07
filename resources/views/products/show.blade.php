@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="container">
            <nav class="breadcrumb">
                <a href="{{ route('home') }}">{{ __('Home') }}</a>
                <span>/</span>
                <a href="{{ route('products.index') }}">{{ __('Products') }}</a>
                <span>/</span>
                <a
                    href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                <span>/</span>
                <span class="current">{{ $product->name }}</span>
            </nav>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="product-detail">
        <div class="container">
            <div class="product-detail-grid">
                <!-- Product Images -->
                <div class="product-gallery">
                    <div class="main-image">
                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}" id="mainImage">
                        @if($product->is_featured)
                            <span class="product-badge">SALE!</span>
                        @endif
                    </div>
                    @if($product->images && count($product->images) > 0)
                        <div class="thumbnail-list">
                            <!-- Main Image as first thumbnail -->
                            <div class="thumbnail active" onclick="changeImage('{{ $product->main_image }}', this)">
                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}">
                            </div>

                            @foreach($product->images as $index => $image)
                                <div class="thumbnail"
                                    onclick="changeImage('{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image) }}', this)">
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image) }}"
                                        alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="product-info-detail">
                    <span class="product-category-badge">{{ $product->category->name }}</span>
                    <h1 class="product-title">{{ $product->name }}</h1>

                    <div class="product-price-section">
                        <span class="price">{{ $product->formatted_price }}</span>
                        <span class="price-note">Price includes VAT · Free worldwide shipping</span>
                    </div>

                    <div class="product-stock">
                        @if($product->stock > 0)
                            <span class="in-stock"><i class="fas fa-check-circle"></i> In Stock ({{ $product->stock }}
                                pcs)</span>
                        @else
                            <span class="out-of-stock"><i class="fas fa-times-circle"></i> {{ __('Out of Stock') }}</span>
                        @endif
                    </div>

                    <!-- Color/Variant Selection -->
                    @if($product->variants && $product->variants->count() > 0)
                        <div class="product-variants-section">
                            <label>Select Color / Style:</label>
                            <div class="variant-list">
                                @foreach($product->variants as $variant)
                                    <button class="variant-btn"
                                        onclick="selectVariant(this, '{{ $variant->name }}', {{ $variant->stock }})">
                                        {{ $variant->name }}
                                        @if($variant->color_code)
                                            <span class="color-dot" style="background-color: {{ $variant->color_code }};"></span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" id="selectedVariant" name="variant">
                        </div>
                    @endif

                    @if($product->stock > 0)
                        <div class="add-to-cart-section">
                            <div class="quantity-selector">
                                <button type="button" onclick="decrementQty()">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock }}">
                                <button type="button" onclick="incrementQty({{ $product->stock }})">+</button>
                            </div>
                            <button class="btn btn-primary add-cart-btn" onclick="addToCartWithQty({{ $product->id }})">
                                <i class="fas fa-shopping-cart"></i> {{ __('Add to Cart') }}
                            </button>
                        </div>
                    @endif

                    <div class="product-description">
                        <h3>Product Details</h3>
                        <div class="description-content">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>

                    <div class="product-features">
                        <div class="feature">
                            <i class="fas fa-globe"></i>
                            <span>Worldwide Shipping</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-shield-alt"></i>
                            <span>Secure Payment</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-hand-sparkles"></i>
                            <span>Premium Quality</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <section class="related-products">
            <div class="container">
                <div class="section-header">
                    <h2>Related Products</h2>
                    <p>You may also like</p>
                    <div class="gold-line"></div>
                </div>
                <div class="products-grid">
                    @foreach($relatedProducts as $related)
                        <div class="product-card">
                            <a href="{{ route('products.show', $related->slug) }}" class="product-image">
                                <img src="{{ $related->main_image }}" alt="{{ $related->name }}">
                                @if($related->is_featured)
                                    <span class="product-grid-badge">SALE!</span>
                                @endif
                            </a>
                            <div class="product-info">
                                <h3 class="product-name">
                                    <a href="{{ route('products.show', $related->slug) }}">{{ $related->name }}</a>
                                </h3>
                                <div class="product-footer">
                                    <span class="product-price">{{ $related->formatted_price }}</span>
                                    <button class="btn-select-options"
                                        onclick="window.location.href='{{ route('products.show', $related->slug) }}'">
                                        <i class="fas fa-check"></i> {{ __('View Details') }}
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

        .breadcrumb-section {
            padding: 1.5rem 0;
            background: var(--secondary-dark);
            border-bottom: 1px solid var(--border-color);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb a:hover {
            color: var(--brand-red);
        }

        .breadcrumb span {
            color: var(--text-muted);
        }

        .breadcrumb .current {
            color: var(--brand-red);
        }

        .product-detail {
            padding: 4rem 0;
        }

        .product-detail-grid {
            display: grid;
            grid-template-columns: 480px 1fr;
            gap: 5rem;
            /* Increased gap for better spacing */
            align-items: start;
        }

        .product-gallery {
            position: sticky;
            top: 100px;
            width: 100%;
        }

        .main-image {
            position: relative;
            border-radius: 0;
            overflow: hidden;
            border: 1px solid var(--border-color);
            margin-bottom: 1rem;
            cursor: zoom-in;
            background: #f9f9f9;
        }

        .main-image img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: contain;
            /* Changed to contain to see full image */
            transition: transform 0.2s ease-out;
            display: block;
        }

        .main-image:hover img {
            transform: scale(2);
        }

        .main-image .product-badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.5rem 1rem;
            background: var(--brand-red);
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 0;
            z-index: 2;
            pointer-events: none;
        }

        .thumbnail-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .thumbnail {
            aspect-ratio: 1;
            border-radius: 0;
            overflow: hidden;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            background: #f9f9f9;
        }

        .thumbnail::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            /* Darker overlay for inactive */
            transition: background 0.3s ease;
        }

        .thumbnail:hover::after,
        .thumbnail.active::after {
            background: rgba(0, 0, 0, 0);
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: var(--brand-red);
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info-detail {
            padding-top: 0;
        }

        .product-category-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: rgba(230, 9, 20, 0.1);
            border: 1px solid var(--border-color);
            color: var(--brand-red);
            font-size: 0.85rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
        }

        .product-title {
            font-family: 'Inter', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #111;
        }

        .product-price-section {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .product-price-section .price {
            font-size: 3rem;
            font-weight: 700;
            color: var(--brand-red);
            display: block;
            margin-bottom: 0.5rem;
            font-family: 'Inter', sans-serif;
        }

        .product-price-section .price-note {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .product-stock {
            margin-bottom: 2rem;
        }

        .product-stock .in-stock {
            color: #22c55e;
            font-weight: 500;
        }

        .product-stock .out-of-stock {
            color: #ef4444;
            font-weight: 500;
        }

        .product-variants-section {
            margin-bottom: 2.5rem;
        }

        .product-variants-section label {
            display: block;
            margin-bottom: 1rem;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .variant-list {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .variant-btn {
            padding: 0.75rem 1.5rem;
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
        }

        .variant-btn:hover,
        .variant-btn.active {
            border-color: var(--brand-red);
            background: rgba(230, 9, 20, 0.1);
            color: var(--brand-red);
            box-shadow: 0 0 15px rgba(230, 9, 20, 0.1);
        }

        .color-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: inline-block;
            border: 1px solid rgba(0, 0, 0, 0.15);
        }

        .add-to-cart-section {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .quantity-selector {
            display: flex;
            border: 1px solid var(--border-color);
            border-radius: 0;
            overflow: hidden;
            height: 56px;
            /* Match button height */
        }

        .quantity-selector button {
            width: 50px;
            height: 100%;
            background: var(--secondary-dark);
            border: none;
            color: var(--text-primary);
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-selector button:hover {
            background: var(--brand-red);
            color: #fff;
        }

        .quantity-selector input {
            width: 60px;
            height: 100%;
            text-align: center;
            background: #fff;
            border: none;
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
        }

        .quantity-selector input::-webkit-outer-spin-button,
        .quantity-selector input::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .add-cart-btn {
            /* Removed flex: 1 to prevent full width */
            padding: 0 4rem;
            /* Wide padding for premium look */
            height: 56px;
            background: var(--brand-red);
            color: #fff;
            border: none;
            text-transform: uppercase;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            border-radius: 0;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .add-cart-btn:hover {
            background: #cc0812;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(230, 9, 20, 0.3);
        }

        .product-description {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .product-description h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: #111;
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .description-content {
            color: var(--text-secondary);
            line-height: 1.8;
            font-family: 'Inter', sans-serif;
            font-size: 1.05rem;
        }

        .product-features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .feature {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 2rem;
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .feature:hover {
            border-color: var(--brand-red);
            transform: translateY(-5px);
        }

        .feature i {
            font-size: 2rem;
            color: var(--brand-red);
            margin-bottom: 1rem;
        }

        .feature span {
            font-size: 0.9rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .related-products {
            padding: 6rem 0;
            background: var(--secondary-dark);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2.5rem;
        }

        /* Product Card Styles */
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
            transform: scale(1.1);
        }

        .product-grid-badge {
            position: absolute;
            top: 10px;
            left: 0;
            padding: 6px 12px;
            background: var(--brand-red);
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
        }

        .product-info {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex-grow: 1;
        }

        .product-name {
            margin: 0 0 1rem;
            font-size: 1rem;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            line-height: 1.4;
            color: #111;
            text-transform: uppercase;
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
            font-weight: 700;
            color: var(--brand-red);
            font-family: 'Inter', sans-serif;
        }

        .btn-select-options {
            width: 100%;
            padding: 12px;
            background: transparent;
            color: #111;
            border: 1px solid #ddd;
            border-radius: 0;
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
        }

        .btn-select-options:hover {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
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
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
        }

        .gold-line {
            width: 80px;
            height: 4px;
            background: var(--brand-red);
            margin: 0 auto;
        }

        @media (max-width: 992px) {
            .product-detail-grid {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .product-gallery {
                position: static;
                width: 100%;
            }

            .product-gallery .main-image {
                max-width: 500px;
                margin: 0 auto 1rem;
            }

            .product-gallery .thumbnail-list {
                max-width: 500px;
                margin: 0 auto;
            }

            .product-title {
                font-size: 2.5rem;
            }

            .product-features {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainImageContainer = document.querySelector('.main-image');
            const mainImage = document.getElementById('mainImage');

            if (mainImageContainer && mainImage) {
                mainImageContainer.addEventListener('mousemove', function (e) {
                    const { left, top, width, height } = this.getBoundingClientRect();
                    const x = (e.clientX - left) / width * 100;
                    const y = (e.clientY - top) / height * 100;

                    mainImage.style.transformOrigin = `${x}% ${y}%`;
                });

                mainImageContainer.addEventListener('mouseleave', function () {
                    mainImage.style.transformOrigin = 'center center';
                });
            }
        });

        function changeImage(src, element) {
            const mainImage = document.getElementById('mainImage');

            // Simple source change for reliability
            mainImage.src = src;

            document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
            element.classList.add('active');
        }

        function incrementQty(max) {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) < max) {
                input.value = parseInt(input.value) + 1;
            }
        }

        function decrementQty() {
            const input = document.getElementById('quantity');
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function addToCartWithQty(productId) {
            const quantity = parseInt(document.getElementById('quantity').value);
            addToCart(productId, quantity);
        }

        function addToCart(productId, quantity) {
            let variant = null;
            const variantInput = document.getElementById('selectedVariant');
            if (variantInput) {
                variant = variantInput.value;
            }

            // Check if variant is required but not selected
            const hasVariants = document.querySelectorAll('.variant-btn').length > 0;
            if (hasVariants && !variant) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select an option',
                    text: 'Please select a variant (Color/Style) before adding to cart',
                    confirmButtonColor: '#E60914',
                    background: '#fff',
                    color: '#111'
                });
                return;
            }

            fetch(`/cart/add/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: quantity,
                    variant: variant
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update Cart Count
                        const cartCountElement = document.querySelector('.cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = data.cart_count;
                        } else {
                            // Create badge if not exists
                            const cartIconWrap = document.querySelector('.cart-icon-wrap');
                            if (cartIconWrap) {
                                const badge = document.createElement('span');
                                badge.className = 'cart-count';
                                badge.textContent = data.cart_count;
                                cartIconWrap.appendChild(badge);
                            }
                        }

                        // Update Cart Total in Header
                        const cartTotalElement = document.getElementById('cart-total-header');
                        if (cartTotalElement) {
                            cartTotalElement.textContent = '$' + data.cart_total;
                        }

                        // Show Success Message (SweetAlert2)
                        Swal.fire({
                            icon: 'success',
                            title: 'Added to Cart',
                            text: data.product_name + ' has been added to your cart',
                            showConfirmButton: false,
                            timer: 2000,
                            background: '#111',
                            color: '#fff',
                            position: 'center'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sorry',
                            text: 'An error occurred, please try again',
                            confirmButtonColor: '#E60914',
                            background: '#111',
                            color: '#fff'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Connection error occurred',
                        confirmButtonColor: '#E60914',
                        background: '#111',
                        color: '#fff'
                    });
                });
        }

        function selectVariant(btn, name, stock) {
            document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('selectedVariant').value = name;
            console.log("Selected variant: " + name);
        }
    </script>
@endpush