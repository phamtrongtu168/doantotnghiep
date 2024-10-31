<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Room</title>
</head>

<body>


    <!-- resources/views/rooms/edit.blade.php -->

    @extends('layouts.app')

    @section('content')
    <h1>Cập nhật phòng</h1>

    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Tên phòng:</label>
            <input type="text" name="name" id="name" value="{{ $room->name }}" required>
        </div>

        <div>
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description">{{ $room->description }}</textarea>
        </div>

        <div>
            <label for="price">Giá:</label>
            <input type="number" name="price" id="price" value="{{ $room->price }}" required>
        </div>

        <div>
            <label for="image">Ảnh:</label>
            <input type="file" name="image" id="image">
        </div>

        <button type="submit">Cập nhật phòng</button>
    </form>
    @endsection


</body>

</html>