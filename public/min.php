<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "AUTOLOAD OK\n";
} catch (\Throwable $e) {
    echo "AUTOLOAD ERR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}
