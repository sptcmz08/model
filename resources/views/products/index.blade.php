@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <!-- Hero Banner -->
    <section class="page-hero-sm">
        <div class="page-hero-content">
            <h1>{{ __('Our Products') }}</h1>
            <p>{{ __('Discover Premium Custom Models') }}</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-page">
        <div class="container">
            <!-- Top Bar: Categories (Left) + Search (Right) -->
            <div class="top-filter-bar">
                <div class="categories-horizontal">
                    <h3>Categories</h3>
                    <ul class="category-list-horizontal">
                        <li>
                            <a href="{{ route('products.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                                {{ __('All Products') }}
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                    class="{{ request('category') == $category->slug ? 'active' : '' }}">
                                    {{ $category->name }} ({{ $category->products_count }})
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="search-bar-top">
                    <form action="{{ route('products.index') }}" method="GET" class="search-form">
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif
                        @if(request('min_price'))
                            <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                        @endif
                        @if(request('max_price'))
                            <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                        @endif
                        <input type="text" name="search" placeholder="{{ __('Search products...') }}"
                            value="{{ request('search') }}">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <span class="results-count">{{ $products->total() }} products found</span>
                </div>
            </div>

            <div class="products-layout">
                <!-- Sidebar Filters -->
                <aside class="filters-sidebar">
                    <div class="filter-section">
                        <h3>Price Range</h3>
                        <div class="price-slider-container">
                            <div class="price-values">
                                <span id="price-min-display">${{ request('min_price', 0) }}</span>
                                <span id="price-max-display">${{ request('max_price', 1000) }}</span>
                            </div>
                            <div class="range-slider">
                                <input type="range" class="min-price" min="0" max="1000"
                                    value="{{ request('min_price', 0) }}" id="min-price" oninput="updatePriceLabels()">
                                <input type="range" class="max-price" min="0" max="1000"
                                    value="{{ request('max_price', 1000) }}" id="max-price" oninput="updatePriceLabels()">
                                <div class="slider-track"></div>
                            </div>
                            <button type="button" class="btn-filter-price" onclick="applyPriceFilter()">Filter</button>
                        </div>
                    </div>

                    <div class="filter-section">
                        <h3>Sort By</h3>
                        <select id="sortSelect" class="sort-select" onchange="sortProducts()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to
                                High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to
                                Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                        </select>
                    </div>
                </aside>

                <!-- Products Grid -->
                <div class="products-main">

                    @if($products->count() > 0)
                        <div class="products-grid">
                            @foreach($products as $product)
                                <div class="product-card">
                                    <a href="{{ route('products.show', $product->slug) }}" class="product-image">
                                        <img src="{{ $product->main_image }}" alt="{{ $product->name }}">

                                        <!-- Badges Container -->
                                        <div class="product-badges">
                                            @if($product->is_featured)
                                                <span class="product-badge badge-sale">SALE!</span>
                                            @endif
                                            <!-- NEW Badge: Created within 30 days -->
                                            @if($product->created_at->diffInDays(now()) < 30)
                                                <span class="product-badge badge-new">NEW</span>
                                            @endif
                                        </div>

                                        @if($product->stock <= 0)
                                            <div class="out-of-stock-overlay">{{ __('Out of Stock') }}</div>
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

                        <!-- Pagination -->
                        <div class="pagination-wrapper">
                            {{ $products->links() }}
                        </div>
                    @else
                        <div class="no-products">
                            <i class="fas fa-box-open"></i>
                            <h3>No Products Found</h3>
                            <p>Try adjusting your search or filter criteria</p>
                            <a href="{{ route('products.index') }}" class="btn btn-outline">Clear Filters</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .page-hero-sm {
            height: 25vh;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: var(--secondary-dark);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .page-hero-sm .page-hero-content h1 {
            font-family: 'Inter', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .page-hero-sm .page-hero-content p {
            color: var(--text-secondary);
        }

        .products-page {
            padding: 4rem 0;
        }

        .products-page {
            padding: 4rem 0;
        }

        /* Top Filter Bar - Categories + Search */
        .top-filter-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .categories-horizontal {
            flex: 1;
        }

        .categories-horizontal h3 {
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
            color: #111;
            font-weight: 600;
        }

        .category-list-horizontal {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            padding: 0;
            margin: 0;
        }

        .category-list-horizontal li a {
            display: inline-block;
            padding: 0.5rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            background: #fff;
            border: 1px solid var(--border-color);
        }

        .category-list-horizontal li a:hover,
        .category-list-horizontal li a.active {
            background: rgba(230, 9, 20, 0.2);
            border-color: var(--brand-red);
            color: var(--brand-red);
        }

        .search-bar-top {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 0.5rem;
            min-width: 280px;
        }

        .search-bar-top .search-form {
            display: flex;
            width: 100%;
        }

        .search-bar-top .results-count {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .top-filter-bar {
                flex-direction: column;
            }

            .search-bar-top {
                width: 100%;
                align-items: flex-start;
                min-width: unset;
            }

            .categories-horizontal {
                width: 100%;
            }
        }

        .products-layout {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 2rem;
        }

        @media (max-width: 992px) {
            .products-layout {
                grid-template-columns: 1fr;
            }

            .filters-sidebar {
                position: relative;
                top: 0;
                margin-bottom: 2rem;
                padding: 1.5rem;
                background: var(--card-bg);
                border: 1px solid var(--border-color);
            }
        }

        .filters-sidebar {
            position: sticky;
            top: 100px;
            height: fit-content;
        }

        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-section h3 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #111;
            font-weight: 600;
        }

        .category-list {
            list-style: none;
        }

        .category-list li {
            margin-bottom: 0.5rem;
        }

        .category-list a {
            display: block;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .category-list a:hover,
        .category-list a.active {
            background: rgba(230, 9, 20, 0.1);
            color: var(--brand-red);
        }

        /* Price Slider Styles */
        .price-slider-container {
            padding: 0 0.5rem;
        }

        .price-values {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: var(--text-primary);
            font-weight: 600;
            font-family: 'Inter', sans-serif;
        }

        .range-slider {
            position: relative;
            height: 5px;
            background: var(--border-color);
            border-radius: 5px;
            margin-bottom: 1.5rem;
        }

        .range-slider input[type="range"] {
            position: absolute;
            width: 100%;
            height: 5px;
            background: none;
            pointer-events: none;
            -webkit-appearance: none;
            left: 0;
        }

        .range-slider input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 18px;
            width: 18px;
            border-radius: 50%;
            background: var(--brand-red);
            pointer-events: auto;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        .btn-filter-price {
            width: 100%;
            padding: 0.75rem;
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            text-transform: uppercase;
        }

        .btn-filter-price:hover {
            border-color: var(--brand-red);
            color: var(--brand-red);
        }

        .sort-select {
            width: 100%;
            padding: 0.75rem 1rem;
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            color: var(--text-primary);
            font-size: 0.95rem;
            cursor: pointer;
        }

        .sort-select:focus {
            outline: none;
            border-color: var(--brand-red);
        }

        .search-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-form {
            display: flex;
            flex: 1;
            max-width: 400px;
        }

        .search-form input {
            flex: 1;
            padding: 0.75rem 1rem;
            background: #fff;
            border: 1px solid var(--border-color);
            border-right: none;
            border-radius: 4px 0 0 4px;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .search-form input:focus {
            outline: none;
            border-color: var(--brand-red);
        }

        .search-form button {
            padding: 0 1.25rem;
            background: var(--brand-red);
            border: 1px solid var(--brand-red);
            border-radius: 0 4px 4px 0;
            color: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-form button:hover {
            background: var(--brand-red-light);
        }

        .results-count {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* Products Grid Update */
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

        /* Updated Badge Styles */
        .product-badges {
            position: absolute;
            top: 10px;
            left: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: flex-start;
            z-index: 10;
        }

        .product-badge {
            padding: 4px 10px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.15);
            border-radius: 0;
        }

        .badge-sale {
            background: var(--brand-red);
            color: #fff;
        }

        .badge-new {
            background: #111;
            color: #fff;
        }

        .out-of-stock-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
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
            font-size: 1.2rem;
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

        .pagination-wrapper {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper nav {
            display: flex;
            gap: 0.5rem;
        }

        .pagination-wrapper a,
        .pagination-wrapper span {
            padding: 0.5rem 1rem;
            background: var(--secondary-dark);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .pagination-wrapper a:hover {
            border-color: var(--brand-red);
            color: var(--brand-red);
        }

        .pagination-wrapper span[aria-current="page"] span {
            background: var(--brand-red);
            color: #fff;
            border-color: var(--brand-red);
        }

        .no-products {
            text-align: center;
            padding: 4rem 2rem;
        }

        .no-products i {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .no-products h3 {
            margin-bottom: 0.5rem;
        }

        .no-products p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function updatePriceLabels() {
            const minPrice = document.getElementById('min-price').value;
            const maxPrice = document.getElementById('max-price').value;

            // Ensure min doesn't cross max
            if (parseInt(minPrice) > parseInt(maxPrice)) {
                const temp = minPrice;
                document.getElementById('min-price').value = maxPrice;
                document.getElementById('max-price').value = temp;
            }

            document.getElementById('price-min-display').textContent = '$' + Math.min(minPrice, maxPrice);
            document.getElementById('price-max-display').textContent = '$' + Math.max(minPrice, maxPrice);
        }

        function applyPriceFilter() {
            const minPrice = Math.min(document.getElementById('min-price').value, document.getElementById('max-price').value);
            const maxPrice = Math.max(document.getElementById('min-price').value, document.getElementById('max-price').value);

            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('min_price', minPrice);
            urlParams.set('max_price', maxPrice);
            urlParams.set('page', 1); // Reset to page 1

            window.location.search = urlParams.toString();
        }

        function sortProducts() {
            const sortValue = document.getElementById('sortSelect').value;
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('sort', sortValue);
            window.location.search = urlParams.toString();
        }
    </script>
@endpush