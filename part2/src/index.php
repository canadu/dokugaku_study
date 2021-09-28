<?php

require_once __DIR__ . '/lib/mysqli.php';
require_once __DIR__ . '/lib/commom.php';

function listBooklog($link)
{
    $reviews = [];

    $sql = 'SELECT title,author,status,score,summary FROM reviews';
    $results = mysqli_query($link, $sql);

    while ($book = mysqli_fetch_assoc($results)) {
        $reviews[] = $book;
    }
    mysqli_free_result($results);
    return $reviews;
}

//db接続
$link = dbConnect();
$reviews = listBooklog($link);
mysqli_close($link);

$title = '読書ログの一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';
