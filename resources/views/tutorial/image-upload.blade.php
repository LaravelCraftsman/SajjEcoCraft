<!DOCTYPE html>
<html>

<head>
    <title>Image Upload via API</title>
    <style>
        /* same styling as before */
    </style>
</head>

<body>
    <div class="container">
        <div id="messages"></div>

        <form id="uploadForm">
            <label for="image">Choose image:</label><br>
            <input type="file" name="image" id="image" required><br><br>
            <button type="submit" id="uploadButton">Upload</button>
        </form>

        <div id="uploadedImage"></div>
    </div>

    <script>
        const form = document.getElementById('uploadForm');
        const uploadButton = document.getElementById('uploadButton');
        const messages = document.getElementById('messages');
        const uploadedImage = document.getElementById('uploadedImage');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            uploadButton.disabled = true;
            uploadButton.textContent = 'Uploading...';
            messages.innerHTML = '';
            uploadedImage.innerHTML = '';

            const fileInput = document.getElementById('image');
            const file = fileInput.files[0];

            if (!file) {
                messages.innerHTML = '<p style="color:red;">Please select an image.</p>';
                uploadButton.disabled = false;
                uploadButton.textContent = 'Upload';
                return;
            }

            const formData = new FormData();
            formData.append('image', file);

            try {
                const response = await fetch('/api/upload-image', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        // add your auth header here if needed, e.g. Authorization: Bearer token
                    },
                    body: formData,
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    messages.innerHTML = `<p style="color:green;">${data.message}</p>`;
                    uploadedImage.innerHTML =
                    `<img src="${data.image_url}" alt="Uploaded Image" width="200" />`;
                } else {
                    let errorMsg = data.message || 'Upload failed.';
                    if (data.errors) {
                        errorMsg = Object.values(data.errors).flat().join('<br>');
                    }
                    messages.innerHTML = `<p style="color:red;">${errorMsg}</p>`;
                }
            } catch (err) {
                messages.innerHTML = `<p style="color:red;">Something went wrong.</p>`;
            } finally {
                uploadButton.disabled = false;
                uploadButton.textContent = 'Upload';
            }
        });
    </script>
</body>

</html>
