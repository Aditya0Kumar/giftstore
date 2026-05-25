<?php
$dirs = glob('images/products/*', GLOB_ONLYDIR);
echo "<html><body style='background: white; color: black; font-family: sans-serif;'>";
foreach ($dirs as $dir) {
    echo "<h1>" . htmlspecialchars($dir) . "</h1>";
    $files = glob($dir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    foreach ($files as $file) {
        echo "<div style='margin-bottom: 20px;'>";
        echo "<h3>" . htmlspecialchars(basename($file)) . "</h3>";
        echo "<img src='/" . htmlspecialchars($file) . "' style='max-width: 300px; max-height: 300px;' />";
        echo "</div>";
    }
}
echo "</body></html>";
