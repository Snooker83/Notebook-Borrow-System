<?php

date_default_timezone_set('Asia/Bangkok');

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

/*
|--------------------------------------------------------------------------
| Project
|--------------------------------------------------------------------------
*/

define('APP_NAME', $_ENV['APP_NAME'] ?? 'Notebook Borrow System');

define('APP_VERSION', '2.0.0');

define('BASE_URL', $_ENV['BASE_URL'] ?? 'http://localhost:8080');

/*
|--------------------------------------------------------------------------
| Security
|--------------------------------------------------------------------------
*/

define('PASSWORD_ALGO', PASSWORD_DEFAULT);

/*
|--------------------------------------------------------------------------
| OTP
|--------------------------------------------------------------------------
*/

define('OTP_LENGTH', (int)($_ENV['OTP_LENGTH'] ?? 6));

define('OTP_EXPIRE_MINUTES', (int)($_ENV['OTP_EXPIRE_MINUTES'] ?? 5));

/*
|--------------------------------------------------------------------------
| Upload
|--------------------------------------------------------------------------
*/

define(
    'UPLOAD_PATH',
    dirname(__DIR__) . '/public/uploads/notebook/'
);