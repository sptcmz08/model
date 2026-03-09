@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Settings')

@section('content')
    <!-- Logo Upload -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-image"></i> Logo</h3>
        </div>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="logo">

            <div style="display: grid; grid-template-columns: 200px 1fr; gap: 2rem; align-items: start;">
                <!-- Current Logo Preview -->
                <div style="text-align: center;">
                    <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 0.75rem;">Current Logo</p>
                    @php
                        $logo = \App\Models\Banner::where('is_active', true)->orderBy('order')->first();
                    @endphp
                    @if($logo)
                        <img src="{{ $logo->image_url }}" alt="Current Logo"
                            style="max-width: 150px; max-height: 150px; border: 1px solid var(--border-color); border-radius: 8px; background: #fff; padding: 0.5rem;">
                    @else
                        <div
                            style="width: 150px; height: 150px; border: 2px dashed var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-muted);">
                            <i class="fas fa-image" style="font-size: 2rem;"></i>
                        </div>
                    @endif
                </div>

                <!-- Upload Form -->
                <div>
                    <div class="form-group">
                        <label>Upload New Logo</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">
                            Recommended: PNG/SVG with transparent background, max 2MB
                        </small>
                    </div>
                    <div class="form-group">
                        <label>Title (optional)</label>
                        <input type="text" name="title" class="form-control" value="Logo" placeholder="Logo title">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Logo
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Existing Logos -->
    @if(isset($banners) && $banners->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Uploaded Logos</h3>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th width="80">Preview</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                        <tr>
                            <td>
                                <img src="{{ $banner->image_url }}" alt="Logo"
                                    style="height: 40px; width: auto; border-radius: 4px; background: #fff; padding: 2px;">
                            </td>
                            <td>{{ $banner->title ?? '-' }}</td>
                            <td>
                                @if($banner->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Delete this logo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Shipping Rates -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-shipping-fast"></i> Shipping Rates by Continent</h3>
        </div>
        <form action="{{ route('admin.shipping-rates.update') }}" method="POST">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th>Continent</th>
                        <th width="180">Rate (USD)</th>
                        <th width="100">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\ShippingRate::orderBy('id')->get() as $rate)
                        <tr>
                            <td>
                                <i class="fas fa-globe" style="color: var(--gold-primary); margin-right: 0.5rem;"></i>
                                {{ $rate->label }}
                                <input type="hidden" name="rates[{{ $rate->id }}][id]" value="{{ $rate->id }}">
                            </td>
                            <td>
                                <div style="position: relative;">
                                    <span
                                        style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted);">$</span>
                                    <input type="number" name="rates[{{ $rate->id }}][rate]" value="{{ $rate->rate }}"
                                        step="0.01" min="0" class="form-control" style="padding-left: 28px; max-width: 160px;">
                                </div>
                            </td>
                            <td>
                                @if($rate->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="margin-top: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Shipping Rates
                </button>
            </div>
        </form>
    </div>

    <!-- Store Info -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-info-circle"></i> Store Information</h3>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Store Name</p>
                <p style="font-weight: 600;">tattooink12studio.com</p>
            </div>
            <div>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Contact Email</p>
                <p style="font-weight: 600;">nattawutkongyod@hotmail.com</p>
            </div>
            <div>
                <p style="color: var(--text-muted); font-size: 0.85rem;">PayPal Email</p>
                <p style="font-weight: 600;">nattawutkongyod@hotmail.com</p>
            </div>
            <div>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Instagram</p>
                <p style="font-weight: 600;">@tattoo.fett</p>
            </div>
        </div>
    </div>
@endsection