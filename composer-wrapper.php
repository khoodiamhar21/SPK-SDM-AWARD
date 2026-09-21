<?php
// Composer wrapper that disables SSL verification for PHP's stream/curl
$context = stream_context_set_default([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

// Set curl to not verify SSL
\Composer\CaBundle\CaBundle::ignoreEnv();

$_SERVER['argv'] = array_merge(['composer'], array_slice($argv, 1));
$_SERVER['argc'] = count($_SERVER['argv']);

require 'phar://' . $argv[0] . '/bin/composer';
