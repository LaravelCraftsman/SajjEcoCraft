<!DOCTYPE html>
<html>

<head>
    <title>Image Upload</title>
</head>

<body>
    <h1>Upload an Image</h1>
    <form action="{{ url('/api/upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" required>
        <button type="submit">Upload</button>
    </form>
</body>

</html>
