<?php
$errors = [];
$book = [
    'bookName' => '',
    'authorName' => '',
    'status' => 'unRead',
    'evaluation' => '',
    'thoughts' => '',
];
$title = '検索';
$content = __DIR__ . '/views/search.php';
include __DIR__ . '/views/layout.php';