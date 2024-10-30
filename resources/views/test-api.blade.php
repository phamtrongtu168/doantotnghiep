<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Phòng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1>Tạo Phòng Mới</h1>
    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Tên Phòng</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="price">Giá</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="area">Diện Tích (m²)</label>
            <input type="number" name="area" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="max_occupants">Số Người Tối Đa</label>
            <input type="number" name="max_occupants" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Hình Ảnh</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
            <label for="air_conditioners">Số Điều Hòa</label>
            <input type="number" name="air_conditioners" class="form-control" required min="0">
        </div>
        <div class="form-group">
            <label for="kitchens">Số Bếp</label>
            <input type="number" name="kitchens" class="form-control" required min="0">
        </div>
        <div class="form-group">
            <label for="refrigerators">Số Tủ Lạnh</label>
            <input type="number" name="refrigerators" class="form-control" required min="0">
        </div>
        <div class="form-group">
            <label for="washing_machines">Số Máy Giặt</label>
            <input type="number" name="washing_machines" class="form-control" required min="0">
        </div>
        <div class="form-group">
            <label for="toilets">Số Nhà Vệ Sinh</label>
            <input type="number" name="toilets" class="form-control" required min="0">
        </div>
        <div class="form-group">
            <label for="bathrooms">Số Phòng Tắm</label>
            <input type="number" name="bathrooms" class="form-control" required min="0">
        </div>
        <div class="form-group">
            <label for="bedrooms">Số Phòng Ngủ</label>
            <input type="number" name="bedrooms" class="form-control" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Tạo Phòng</button>
    </form>
</div>
</body>
</html>
