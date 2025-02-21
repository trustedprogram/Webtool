<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["pdfFile"])) {
    $uploadDir = "uploads/";
    $outputDir = "output/";

    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
    if (!file_exists($outputDir)) mkdir($outputDir, 0777, true);

    $pdfFile = $uploadDir . basename($_FILES["pdfFile"]["name"]);
    move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $pdfFile);

    $imagick = new Imagick();
    $imagick->setResolution(200, 200);
    $imagick->readImage($pdfFile);
    $imagick->setImageFormat("jpg");

    $outputImages = [];
    $zipFile = $outputDir . pathinfo($pdfFile, PATHINFO_FILENAME) . ".zip";
    $zip = new ZipArchive();
    $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

    foreach ($imagick as $i => $image) {
        $outputFile = $outputDir . pathinfo($pdfFile, PATHINFO_FILENAME) . "_page" . ($i + 1) . ".jpg";
        $image->writeImage($outputFile);
        $zip->addFile($outputFile, basename($outputFile));
        $outputImages[] = $outputFile;
    }

    $zip->close();
    $imagick->clear();
    $imagick->destroy();

    echo "<h5 class='text-success'>Conversion Successful!</h5>";
    foreach ($outputImages as $img) {
        echo "<img src='$img' class='img-fluid mt-2'><br>";
        echo "<a href='$img' class='btn btn-success download-btn' download>Download JPG</a><br>";
    }

    echo "<a href='$zipFile' class='btn btn-primary download-btn mt-3' download>Download All as ZIP</a>";
} else {
    echo "<p class='text-danger'>Error processing file.</p>";
}
?>
