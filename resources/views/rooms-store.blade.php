<!-- resources/views/rooms/create.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room</title>
</head>

<body>
    @extends('layouts.app')

    <h1>Create Room</h1>
    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Description:</label>
        <input type="text" name="description"><br>

        <label>Price:</label>
        <input type="number" name="price" required><br>

        <label>Area:</label>
        <input type="number" name="area" required><br>

        <label>Max Occupants:</label>
        <input type="number" name="max_occupants" required><br>

        <label>Air Conditioners:</label>
        <input type="number" name="air_conditioners" required><br>

        <label>Kitchens:</label>
        <input type="number" name="kitchens" required><br>

        <label>Refrigerators:</label>
        <input type="number" name="refrigerators" required><br>

        <label>Washing Machines:</label>
        <input type="number" name="washing_machines" required><br>

        <label>Toilets:</label>
        <input type="number" name="toilets" required><br>

        <label>Bathrooms:</label>
        <input type="number" name="bathrooms" required><br>

        <label>Bedrooms:</label>
        <input type="number" name="bedrooms" required><br>

        <label>Images:</label>
        <input type="file" name="images[]" multiple><br><br>

        <button type="submit">Create Room</button>
    </form>
</body>

</html>