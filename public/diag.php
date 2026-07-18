<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_start();
echo "PHP Version: " . phpversion() . "\n";
echo "Extensions:\n";
foreach (['pdo','pdo_mysql','mbstring','openssl','fileinfo','curl','zip','json','tokenizer','ctype','bcmath'] as $ext) {
    echo "  $ext: " . (extension_loaded($ext) ? 'OK' : 'MISSING') . "\n";
}
echo "\n--- Bootstrap test ---\n";
try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "autoload: OK\n";
} catch (\Throwable $e) {
    echo "autoload ERROR: " . $e->getMessage() . "\n";
}
try {
    $app = require __DIR__ . '/../bootstrap/app.php';
    echo "bootstrap/app.php: OK\n";
} catch (\Throwable $e) {
    echo "bootstrap ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();
    echo "env load: OK\n";
    echo "APP_KEY set: " . (env('APP_KEY') ? 'yes' : 'NO') . "\n";
    echo "DB_HOST: " . env('DB_HOST') . "\n";
    echo "APP_DEBUG: " . env('APP_DEBUG') . "\n";
} catch (\Throwable $e) {
    echo "env ERROR: " . $e->getMessage() . "\n";
}
$out = ob_get_clean();
file_put_contents(__DIR__ . '/../diag_result.txt', $out);
echo $out;
