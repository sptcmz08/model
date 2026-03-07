@extends('admin.layouts.app')

@section('title', 'แก้ไขแบนเนอร์')

@section('header', 'แก้ไขแบนเนอร์')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white border-secondary">
                <div class="card-header border-secondary">
                    <h4 class="mb-0">แก้ไขแบนเนอร์</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">รูปภาพปัจจุบัน</label>
                            <div class="mb-2">
                                <img src="{{ $banner->image_url }}" alt="Current Banner" class="img-fluid rounded"
                                    style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">เปลี่ยนรูปภาพ (เว้นว่างหากไม่ต้องการเปลี่ยน)</label>
                            <input type="file" class="form-control bg-dark text-white border-secondary" id="image"
                                name="image" accept="image/*">
                            <div class="form-text text-muted">รองรับไฟล์: jpeg, png, jpg, gif (ขนาดไม่เกิน 2MB)</div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">หัวข้อ (ไม่บังคับ)</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" id="title"
                                name="title" value="{{ old('title', $banner->title) }}" placeholder="ใส่ข้อความหัวข้อ">
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">ลิ้งก์ (ไม่บังคับ)</label>
                            <input type="url" class="form-control bg-dark text-white border-secondary" id="link" name="link"
                                value="{{ old('link', $banner->link) }}" placeholder="https://example.com">
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">ลำดับการแสดงผล</label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" id="order"
                                name="order" value="{{ old('order', $banner->order) }}">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ $banner->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">เปิดใช้งาน</label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">ยกเลิก</a>
                            <button type="submit" class="btn btn-primary">อัปเดตข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection