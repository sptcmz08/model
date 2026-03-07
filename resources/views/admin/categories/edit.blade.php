@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
    <div class="card" style="max-width: 800px;">
        <div class="card-header">
            <h3 class="card-title">Edit: {{ $category->name }}</h3>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm"
                style="background: var(--primary-dark); color: var(--text-secondary);">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category Name *</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}"
                    required>
                @error('name')
                    <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                    class="form-control">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            @if($category->image)
                <div class="form-group">
                    <label>Current Image</label>
                    <div>
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}"
                            style="max-width: 200px; border-radius: 8px;">
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="image">{{ $category->image ? 'Change Image' : 'Image' }}</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                @error('image')
                    <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                    <label for="is_active">Active</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Category
            </button>
        </form>
    </div>
@endsection