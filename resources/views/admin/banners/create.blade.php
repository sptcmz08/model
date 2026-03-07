@extends('admin.layouts.app')

@section('title', 'เพิ่มแบนเนอร์ใหม่')

@section('header', 'เพิ่มแบนเนอร์')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-dark text-white border-secondary">
                <div class="card-header border-secondary">
                    <h4 class="mb-0">เพิ่มแบนเนอร์ใหม่</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="image" class="form-label">รูปภาพแบนเนอร์ <span class="text-danger">*</span></label>
                            <input type="file" class="form-control bg-dark text-white border-secondary" id="image"
                                name="image" required accept="image/*">
                            <div class="form-text text-muted">รองรับไฟล์: jpeg, png, jpg, gif (ขนาดไม่เกิน 2MB)</div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">หัวข้อ (ไม่บังคับ)</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" id="title"
                                name="title" value="{{ old('title') }}" placeholder="ใส่ข้อความหัวข้อ">
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">ลิ้งก์ (ไม่บังคับ)</label>
                            <input type="url" class="form-control bg-dark text-white border-secondary" id="link" name="link"
                                value="{{ old('link') }}" placeholder="https://example.com">
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">ลำดับการแสดงผล</label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" id="order"
                                name="order" value="{{ old('order', 0) }}">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" checked>
                            <label class="form-check-label" for="is_active">เปิดใช้งานทันที</label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">ยกเลิก</a>
                            <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection