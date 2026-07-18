<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$zipPath = __DIR__ . '/../vendor.zip';
$extractTo = __DIR__ . '/../vendor';
if (!file_exists($zipPath)) { die("vendor.zip not found\n"); }
$zip = new ZipArchive();
$res = $zip->open($zipPath);
if ($res !== TRUE) { die("cannot open zip: $res\n"); }
// hapus vendor lama yang tidak lengkap
if (!is_dir($extractTo)) { mkdir($extractTo, 0755, true); }
$ok = $zip->extractTo($extractTo);
$zip->close();
if ($ok) {
    echo "EXTRACTED OK\n";
    // hapus zip setelah sukses
    @unlink($zipPath);
    echo "vendor.zip removed\n";
} else {
    echo "EXTRACT FAILED\n";
}
// verifikasi
$autoload = $extractTo . '/composer/autoload_real.php';
echo "autoload_real.php exists: " . (file_exists($autoload) ? 'YES' : 'NO') . "\n";
