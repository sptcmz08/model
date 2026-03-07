@extends('layouts.app')

@section('title', __('Contact'))

@section('content')
    <section class="contact-hero">
        <div class="hero-inner">
            <span class="hero-label">{{ __('GET IN TOUCH') }}</span>
            <h1>{{ __('Contact Us') }}</h1>
            <p class="hero-sub">
                {{ __("We'd love to hear from you. Send us a message and we'll respond as soon as possible.") }}
            </p>
        </div>
    </section>

    <section class="contact-main">
        <div class="contact-wrapper">
            {{-- Left: Form --}}
            <div class="form-side">
                @if(session('success'))
                    <div class="alert alert-ok">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-err">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="cf">
                    @csrf
                    <div class="cf-row cf-row-2">
                        <div class="cf-group">
                            <label for="name">{{ __('NAME') }}</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                placeholder="{{ __('Your name') }}" required>
                            @error('name') <span class="cf-err">{{ $message }}</span> @enderror
                        </div>
                        <div class="cf-group">
                            <label for="email">{{ __('EMAIL') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                placeholder="{{ __('your@email.com') }}" required>
                            @error('email') <span class="cf-err">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="cf-group">
                        <label for="subject">{{ __('SUBJECT') }}</label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                            placeholder="{{ __('What is this about?') }}" required>
                        @error('subject') <span class="cf-err">{{ $message }}</span> @enderror
                    </div>
                    <div class="cf-group">
                        <label for="message">{{ __('MESSAGE') }}</label>
                        <textarea id="message" name="message" rows="5" placeholder="{{ __('Tell us more...') }}"
                            required>{{ old('message') }}</textarea>
                        @error('message') <span class="cf-err">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="cf-submit">
                        <span>{{ __('SEND MESSAGE') }}</span>
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Hero */
        .contact-hero {
            background: linear-gradient(135deg, #111 0%, #1a1a2e 50%, #16213e 100%);
            padding: 5rem 2rem 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(230, 9, 20, 0.06) 0%, transparent 60%);
            animation: pulse-bg 8s ease-in-out infinite;
        }

        @keyframes pulse-bg {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }
        }

        .hero-inner {
            position: relative;
            z-index: 1;
            max-width: 600px;
            margin: 0 auto;
        }

        .hero-label {
            display: inline-block;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 4px;
            color: var(--brand-red);
            background: rgba(230, 9, 20, 0.1);
            padding: 0.4rem 1.2rem;
            border-radius: 20px;
            margin-bottom: 1.2rem;
            text-transform: uppercase;
        }

        .contact-hero h1 {
            font-family: 'Inter', sans-serif;
            font-size: 2.8rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.8rem;
            letter-spacing: -0.5px;
        }

        .hero-sub {
            color: rgba(255, 255, 255, 0.6);
            font-size: 1rem;
            line-height: 1.6;
            max-width: 480px;
            margin: 0 auto;
        }

        /* Main */
        .contact-main {
            padding: 4rem 2rem 5rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .contact-wrapper {
            max-width: 650px;
            margin: 0 auto;
        }

        /* Form */
        .form-side {}

        .cf {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .cf-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .cf-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .cf-group label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: #999;
            text-transform: uppercase;
        }

        .cf-group input,
        .cf-group textarea {
            padding: 0.9rem 1rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            background: #fafafa;
            color: #111;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 0.25s;
            outline: none;
        }

        .cf-group input:focus,
        .cf-group textarea:focus {
            border-color: #111;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .cf-group input::placeholder,
        .cf-group textarea::placeholder {
            color: #bbb;
            font-weight: 400;
        }

        .cf-group textarea {
            resize: vertical;
            min-height: 130px;
        }

        .cf-err {
            color: var(--brand-red);
            font-size: 0.78rem;
        }

        .cf-submit {
            align-self: flex-start;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #111;
            color: #fff;
            border: none;
            padding: 0.9rem 2rem;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.5rem;
        }

        .cf-submit:hover {
            background: var(--brand-red);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(230, 9, 20, 0.3);
        }

        .cf-submit i {
            transition: transform 0.3s;
        }

        .cf-submit:hover i {
            transform: translateX(4px);
        }

        /* Info cards */
        .info-side {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .info-card {
            padding: 1.5rem;
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 12px;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: var(--brand-red);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .info-card:hover {
            border-color: #ddd;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transform: translateX(4px);
        }

        .info-card:hover::before {
            opacity: 1;
        }

        .ic-icon {
            width: 36px;
            height: 36px;
            background: rgba(230, 9, 20, 0.08);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-red);
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        .info-card h3 {
            font-size: 0.85rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 0.3rem;
            letter-spacing: 0.5px;
        }

        .info-card p,
        .info-card a {
            font-size: 0.9rem;
            color: #555;
            text-decoration: none;
            word-break: break-all;
        }

        .info-card a:hover {
            color: var(--brand-red);
        }

        .ic-note {
            display: inline-block;
            margin-top: 0.4rem;
            font-size: 0.75rem;
            color: #999;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-ok {
            background: #f0fdf4;
            border: 1px solid #22c55e;
            color: #166534;
        }

        .alert-err {
            background: #fef2f2;
            border: 1px solid #ef4444;
            color: #991b1b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-hero h1 {
                font-size: 2rem;
            }

            .contact-wrapper {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .cf-row-2 {
                grid-template-columns: 1fr;
            }

            .cf-submit {
                width: 100%;
                justify-content: center;
            }

            .info-side {
                order: -1;
            }
        }
    </style>
@endpush