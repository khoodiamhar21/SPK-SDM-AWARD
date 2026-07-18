<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Tangkap fatal error
register_shutdown_function(function () {
    $e = error_get_last();
    if ($e && in_array($e['type'], [E_ERROR, E_PARSE, E_COMPILE_ERROR])) {
        echo "<h3>FATAL ERROR</h3><pre>";
        echo htmlspecialchars($e['message']) . "\n";
        echo "File: " . $e['file'] . " Line: " . $e['line'] . "\n";
        echo "</pre>";
    }
});

try {
    require __DIR__ . '/index.php';
} catch (\Throwable $ex) {
    echo "<h3>EXCEPTION</h3><pre>";
    echo htmlspecialchars($ex->getMessage()) . "\n\n";
    echo htmlspecialchars($ex->getTraceAsString());
    echo "</pre>";
}
