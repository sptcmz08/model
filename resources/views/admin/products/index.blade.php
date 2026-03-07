@extends('admin.layouts.app')

@section('title', 'สินค้า')
@section('page-title', 'รายการสินค้า')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">สินค้าทั้งหมด</h3>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> เพิ่มสินค้า
            </a>
        </div>

        @if($products->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>รูปภาพ</th>
                        <th>ชื่อสินค้า</th>
                        <th>หมวดหมู่</th>
                        <th>ราคา</th>
                        <th>คลัง</th>
                        <th>สถานะ</th>
                        <th>จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="product-thumb">
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->is_featured)
                                    <span class="badge bg-warning" style="margin-left: 0.5rem;">แนะนำ</span>
                                @endif
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td style="color: var(--gold-primary);">${{ number_format($product->price, 2) }}</td>
                            <td>
                                @if($product->stock > 0)
                                    <span style="color: var(--success);">{{ $product->stock }}</span>
                                @else
                                    <span class="badge bg-danger">สินค้าหมด</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">ใช้งาน</span>
                                @else
                                    <span class="badge bg-secondary">ซ่อน</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    style="display: inline;" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบสินค้านี้?')">
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
                {{ $products->links() }}
            </div>
        @else
            <p style="text-align: center; color: var(--text-muted); padding: 3rem;">ยังไม่มีสินค้า <a
                    href="{{ route('admin.products.create') }}" style="color: var(--gold-primary);">เพิ่มสินค้าใหม่</a></p>
        @endif
    </div>
@endsection