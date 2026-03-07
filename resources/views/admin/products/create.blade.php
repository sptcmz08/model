@extends('admin.layouts.app')

@section('title', 'สร้างสินค้าใหม่')
@section('page-title', 'สร้างสินค้าใหม่')

@section('content')
    <div class="card" style="max-width: 900px;">
        <div class="card-header">
            <h3 class="card-title">เพิ่มสินค้าใหม่</h3>
            <a href="{{ route('admin.products.index') }}" class="btn btn-sm"
                style="background: var(--primary-dark); color: var(--text-secondary);">
                <i class="fas fa-arrow-left"></i> ย้อนกลับ
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="name">ชื่อสินค้า *</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_id">หมวดหมู่ *</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">เลือกหมวดหมู่</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">รายละเอียดสินค้า</label>
                <textarea id="description" name="description" class="form-control"
                    rows="5">{{ old('description') }}</textarea>
                @error('description')
                    <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label for="price">ราคา (USD) *</label>
                    <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" step="0.01"
                        min="0" required>
                    @error('price')
                        <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="shipping_cost">ค่าจัดส่ง (USD) *</label>
                    <input type="number" id="shipping_cost" name="shipping_cost" class="form-control"
                        value="{{ old('shipping_cost', 0) }}" step="0.01" min="0" required>
                    @error('shipping_cost')
                        <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock">จำนวนสินค้าคงเหลือ *</label>
                    <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock', 0) }}" min="0"
                        required>
                    @error('stock')
                        <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Variants Section -->
            <hr style="border-color: var(--border-color); margin: 2rem 0;">
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <label style="margin-bottom: 0;">ตัวเลือกสินค้า / สี (Variants)</label>
                    <button type="button" class="btn btn-sm btn-outline" onclick="addVariant()">
                        <i class="fas fa-plus"></i> เพิ่มตัวเลือก
                    </button>
                </div>

                <div id="variants-container">
                    <!-- Variants will be added here -->
                </div>
            </div>
            <hr style="border-color: var(--border-color); margin: 2rem 0;">

            <div class="form-group">
                <label for="images">รูปภาพสินค้า</label>
                <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple
                    onchange="previewNewImages(this)">
                <small style="color: var(--text-muted);">สามารถเลือกได้หลายรูป</small>
                @error('images.*')
                    <span style="color: #ef4444; font-size: 0.85rem;">{{ $message }}</span>
                @enderror

                <!-- Image Preview Container -->
                <div id="new-images-preview" style="display: flex; gap: 1rem; flex-wrap: wrap; margin-top: 1rem;"></div>
            </div>

            <script>
                function previewNewImages(input) {
                    const previewContainer = document.getElementById('new-images-preview');
                    previewContainer.innerHTML = '';

                    if (input.files && input.files.length > 0) {
                        Array.from(input.files).forEach((file, index) => {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const imgWrapper = document.createElement('div');
                                imgWrapper.style.cssText = 'position: relative; border: 2px solid var(--gold-primary); border-radius: 8px; overflow: hidden;';

                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.style.cssText = 'width: 100px; height: 100px; object-fit: cover; display: block;';

                                const label = document.createElement('div');
                                label.style.cssText = 'position: absolute; bottom: 0; left: 0; right: 0; background: rgba(212, 175, 55, 0.9); color: #000; font-size: 10px; text-align: center; padding: 2px;';
                                label.textContent = 'NEW';

                                imgWrapper.appendChild(img);
                                imgWrapper.appendChild(label);
                                previewContainer.appendChild(imgWrapper);
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                }
            </script>

            <div style="display: flex; gap: 2rem; margin-bottom: 1.5rem;">
                <div class="form-check">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active">เปิดใช้งาน (Active)</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label for="is_featured">แสดงป้าย SALE (Featured)</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> บันทึกสินค้า
            </button>
        </form>
    </div>

    <script>
        let variantIndex = 0;

        function addVariant() {
            const container = document.getElementById('variants-container');
            const html = `
                        <div class="variant-item" id="variant-${variantIndex}" style="background: var(--secondary-dark); padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border: 1px solid var(--border-color);">
                            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: end;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 0.85rem;">ชื่อสี / แบบ *</label>
                                    <input type="text" name="variants[${variantIndex}][name]" class="form-control" placeholder="เช่น แดง, ไอรอนแมน Mark 85" required>
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 0.85rem;">Color Code (Hex)</label>
                                    <input type="color" name="variants[${variantIndex}][color_code]" class="form-control" style="height: 42px; padding: 4px;" value="#ff0000">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 0.85rem;">จำนวน *</label>
                                    <input type="number" name="variants[${variantIndex}][stock]" class="form-control" value="0" min="0" required>
                                </div>
                                <button type="button" class="btn btn-sm" style="background: #ef4444; color: white;" onclick="removeVariant(${variantIndex})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
            container.insertAdjacentHTML('beforeend', html);
            variantIndex++;
        }

        function removeVariant(index) {
            document.getElementById(`variant-${index}`).remove();
        }
    </script>
@endsection