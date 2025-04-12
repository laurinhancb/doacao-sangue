<?php
// init.php
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400, // 1 dia
        'read_and_close'  => false,
        'use_strict_mode' => true
    ]);
}