@extends('admin.layouts.app')

@section('title', 'About Images')
@section('page-title', 'About Images')

@section('content')
    <!-- Upload Form -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-images"></i> Upload About Image</h3>
            <span style="color: var(--text-muted); font-size: 0.85rem;">{{ $images->count() }} / 2 images</span>
        </div>

        @if($images->count() < 2)
            <form action="{{ route('admin.about-images.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr auto; gap: 1.5rem; align-items: end;">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Select Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <small style="color: var(--text-muted); display: block; margin-top: 0.5rem;">
                            Recommended: JPG/PNG, high quality portfolio images. Max 10MB.
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        @else
            <p style="color: var(--warning); display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-exclamation-triangle"></i>
                Maximum 2 images reached. Delete an existing image to upload a new one.
            </p>
        @endif
    </div>

    <!-- Current Images -->
    @if($images->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current About Images</h3>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                @foreach($images as $index => $image)
                    <div
                        style="background: var(--primary-dark); border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden;">
                        <img src="{{ $image->image_url }}" alt="About Image {{ $index + 1 }}"
                            style="width: 100%; height: 220px; object-fit: cover;">
                        <div style="padding: 1rem; display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: var(--text-secondary); font-size: 0.9rem;">
                                <i class="fas fa-image"></i> Image {{ $index + 1 }}
                            </span>
                            <form action="{{ route('admin.about-images.destroy', $image) }}" method="POST"
                                onsubmit="return confirm('Delete this image?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Preview -->
        @if($images->count() == 2)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-eye"></i> Preview (About Page)</h3>
                </div>
                <div style="position: relative; width: 400px; height: 420px; margin: 0 auto;">
                    <div
                        style="position: absolute; top: 0; left: 0; width: 280px; height: 320px; border-radius: 16px; overflow: hidden; border: 4px solid var(--border-color); z-index: 2; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        <img src="{{ $images[0]->image_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div
                        style="position: absolute; bottom: 0; right: 0; width: 280px; height: 320px; border-radius: 16px; overflow: hidden; border: 4px solid var(--border-color); z-index: 1; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                        <img src="{{ $images[1]->image_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection