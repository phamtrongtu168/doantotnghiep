<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Room</title>
    <script>
    async function storeRoom(event) {
        event.preventDefault();

        const token = document.getElementById('token').value;
        const formElement = document.getElementById('roomForm');
        const formData = new FormData(formElement);

        try {
            const response = await fetch("http://127.0.0.1:8000/rooms", {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${"36|zKN4ykvyGZaG3FC9X8Ys0W6zC47n8UDggf7OYRLG02636006"}`,
                    "Accept": "application/json"
                },
                body: formData
            });

            const result = await response.json();
            if (response.ok) {
                alert("Room created successfully!");
                console.log(result);
            } else {
                console.error(result);
                alert("Error: " + (result.error || "Failed to create room"));
            }
        } catch (error) {
            console.error('Request failed', error);
            alert("Request failed. Please check console for details.");
        }
    }
    </script>
</head>

<body>
    <h2>Create a New Room</h2>
    <form id="roomForm" onsubmit="storeRoom(event)" enctype="multipart/form-data">
        <input type="hidden" id="token" value="YOUR_BEARER_TOKEN_HERE">

        <div>
            <label for="name">Room Name:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>
        </div>

        <div>
            <label for="area">Area (sqm):</label>
            <input type="number" id="area" name="area" required>
        </div>

        <div>
            <label for="max_occupants">Max Occupants:</label>
            <input type="number" id="max_occupants" name="max_occupants" required>
        </div>

        <div>
            <label for="air_conditioners">Air Conditioners:</label>
            <input type="number" id="air_conditioners" name="air_conditioners" min="0" required>
        </div>

        <div>
            <label for="kitchens">Kitchens:</label>
            <input type="number" id="kitchens" name="kitchens" min="0" required>
        </div>

        <div>
            <label for="refrigerators">Refrigerators:</label>
            <input type="number" id="refrigerators" name="refrigerators" min="0" required>
        </div>

        <div>
            <label for="washing_machines">Washing Machines:</label>
            <input type="number" id="washing_machines" name="washing_machines" min="0" required>
        </div>

        <div>
            <label for="toilets">Toilets:</label>
            <input type="number" id="toilets" name="toilets" min="0" required>
        </div>

        <div>
            <label for="bathrooms">Bathrooms:</label>
            <input type="number" id="bathrooms" name="bathrooms" min="0" required>
        </div>

        <div>
            <label for="bedrooms">Bedrooms:</label>
            <input type="number" id="bedrooms" name="bedrooms" min="0" required>
        </div>

        <div>
            <label for="images">Room Images:</label>
            <input type="file" id="images.*" name="images[]" accept="image/*" multiple>
        </div>

        <div>
            <button type="submit">Create Room</button>
        </div>
    </form>
</body>

</html>