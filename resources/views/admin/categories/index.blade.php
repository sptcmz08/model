@extends('admin.layouts.app')

@section('title', 'หมวดหมู่สินค้า')
@section('page-title', 'หมวดหมู่สินค้า')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">หมวดหมู่ทั้งหมด</h3>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> เพิ่มหมวดหมู่
            </a>
        </div>

        @if($categories->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>ไอดี</th>
                        <th>ชื่อหมวดหมู่</th>
                        <th>Slug</th>
                        <th>จำนวนสินค้า</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>{{ $category->products_count }}</td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">ใช้งาน</span>
                                @else
                                    <span class="badge bg-secondary">ซ่อน</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    style="display: inline;" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบหมวดหมู่นี้?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="padding: 1rem;">
                {{ $categories->links() }}
            </div>
        @else
            <p style="text-align: center; color: var(--text-muted); padding: 3rem;">ยังไม่มีหมวดหมู่ <a
                    href="{{ route('admin.categories.create') }}" style="color: var(--gold-primary);">เพิ่มหมวดหมู่ใหม่</a></p>
        @endif
    </div>
@endsection