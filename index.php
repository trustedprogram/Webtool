<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF to JPG Converter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .preview img {
            max-width: 100%;
            margin-top: 10px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .download-btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">PDF to JPG Converter</h2>
    <form id="uploadForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="pdfFile" class="form-label">Choose a PDF file</label>
            <input type="file" class="form-control" id="pdfFile" name="pdfFile" accept="application/pdf" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Convert to JPG</button>
    </form>
    <div class="preview mt-4 text-center"></div>
</div>

<script>
$(document).ready(function () {
    $("#uploadForm").on("submit", function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: "upload.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $(".preview").html("<p class='text-center text-primary'>Processing...</p>");
            },
            success: function (response) {
                $(".preview").html(response);
            }
        });
    });
});
</script>

</body>
</html>
