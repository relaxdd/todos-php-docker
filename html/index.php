<?php

declare(strict_types=1);

const ABS_PATH = __DIR__;
const AUTOLOAD = ABS_PATH . '/vendor/autoload.php';

if (file_exists(AUTOLOAD)) require AUTOLOAD;
else die("The file 'vendor/autoload.php ' not found in the catalog");

$request_uri =  $_SERVER['REQUEST_URI'];
$request_uri = '/' . trim($request_uri, '/');

if (in_array($request_uri, ['/', '/index.php'])) {
  require ABS_PATH . '/pages/home.php';
  exit;
}

$pages = [
  '/todos' => [
    'template' => '/pages/todos.php'
  ],
  '/posts' => [
    'template' => '/pages/posts.php'
  ]
];

if (!array_key_exists($request_uri, $pages)) {
  http_response_code(404);
  die;
}

require ABS_PATH . $pages[$request_uri]['template'];
exit;
