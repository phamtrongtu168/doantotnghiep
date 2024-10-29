@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tạo Mới Phòng</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Tên Phòng</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô Tả</label>
            <textarea class="form-control" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Giá</label>
            <input type="number" class="form-control" name="price" required>
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Diện Tích (m²)</label>
            <input type="number" class="form-control" name="area" required>
        </div>

        <div class="mb-3">
            <label for="max_occupants" class="form-label">Số Người Tối Đa</label>
            <input type="number" class="form-control" name="max_occupants" required>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Hình Ảnh</label>
            <input type="file" class="form-control" name="image" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="province_id" class="form-label">Tỉnh/Thành Phố</label>
            <select class="form-select" name="province_id" required>
                <option value="">Chọn Tỉnh/Thành Phố</option>
                <!-- Thay thế các giá trị dưới đây bằng dữ liệu thực tế từ cơ sở dữ liệu -->
                <option value="1">TP.HCM</option>
                <option value="2">Hà Nội</option>
                <!-- Thêm các tỉnh/thành phố khác -->
            </select>
        </div>

        <div class="mb-3">
            <label for="district_id" class="form-label">Quận/Huyện</label>
            <select class="form-select" name="district_id" required>
                <option value="">Chọn Quận/Huyện</option>
                <!-- Thay thế các giá trị dưới đây bằng dữ liệu thực tế từ cơ sở dữ liệu -->
                <option value="1">Quận 1</option>
                <option value="2">Quận 2</option>
                <!-- Thêm các quận/huyện khác -->
            </select>
        </div>

        <div class="mb-3">
            <label for="air_conditioners" class="form-label">Số Điều Hòa</label>
            <input type="number" class="form-control" name="air_conditioners" required min="0">
        </div>

        <div class="mb-3">
            <label for="kitchens" class="form-label">Số Bếp</label>
            <input type="number" class="form-control" name="kitchens" required min="0">
        </div>

        <div class="mb-3">
            <label for="refrigerators" class="form-label">Số Tủ Lạnh</label>
            <input type="number" class="form-control" name="refrigerators" required min="0">
        </div>

        <div class="mb-3">
            <label for="washing_machines" class="form-label">Số Máy Giặt</label>
            <input type="number" class="form-control" name="washing_machines" required min="0">
        </div>

        <div class="mb-3">
            <label for="toilets" class="form-label">Số Toilet</label>
            <input type="number" class="form-control" name="toilets" required min="0">
        </div>

        <div class="mb-3">
            <label for="bathrooms" class="form-label">Số Phòng Tắm</label>
            <input type="number" class="form-control" name="bathrooms" required min="0">
        </div>

        <div class="mb-3">
            <label for="bedrooms" class="form-label">Số Phòng Ngủ</label>
            <input type="number" class="form-control" name="bedrooms" required min="0">
        </div>

        <button type="submit" class="btn btn-primary">Tạo Phòng</button>
    </form>
</div>
@endsection
