<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
$lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$cfg = [];
foreach ($lines as $line) {
    $line = trim($line);
    if ($line === '' || strpos($line, '#') === 0) continue;
    if (strpos($line, '=') === false) continue;
    list($k, $v) = explode('=', $line, 2);
    $cfg[trim($k)] = trim($v, '"\'');
}
extract($cfg);
echo "DB_HOST=$DB_HOST DB=$DB_DATABASE USER=$DB_USERNAME\n";
try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_DATABASE;charset=utf8mb4", $DB_USERNAME, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "DB CONNECTED OK\n";
    $cnt = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    echo "users before: $cnt\n";
    if ($cnt > 0) { echo "ALREADY IMPORTED - skip\n"; exit; }
    $sql = file_get_contents(__DIR__ . '/../spk_sdmaward_dump.sql');
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $pdo->exec($sql);
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
    echo "users after: " . $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() . "\n";
    echo "IMPORT DONE\n";
} catch (\Throwable $e) { echo "DB ERR: " . $e->getMessage() . "\n"; }
