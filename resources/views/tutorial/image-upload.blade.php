<!DOCTYPE html>
<html>

<head>
    <title>Image Upload</title>
</head>

<body>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
        <img src="{{ asset(session('imagePath')) }}" width="200" alt="Uploaded Image">
    @endif

    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('image.upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Choose image:</label>
        <input type="file" name="image" id="image" required>
        <button type="submit">Upload</button>
    </form>

</body>

</html>
