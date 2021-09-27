<?php
$errors = [];
$book = [
    'bookName' => '',
    'authorName' => '',
    'status' => '',
    'evaluation' => '',
    'thoughts' => '',
];

$title = '読書ログの登録';
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';
