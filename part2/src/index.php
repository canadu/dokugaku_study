<?php

require_once __DIR__ . '/lib/mysqli.php';
require_once __DIR__ . '/lib/commom.php';

$book = [
    'bookName' => '',
    'authorName' => '',
    'status' => 'unRead',
    'evaluation' => '',
    'thoughts' => '',
];

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

function searchWhere($str){
    return strpos($str, "WHERE");
}

function getSearchReviews($link, $book) {
    $reviews = [];
    $buf = '';
    $sql = 'SELECT * FROM reviews';
    
    // 検索条件を設定
    if (strlen($book['bookName'])) {
        $buf = "title LIKE '%{$book['bookName']}%'"; 
        $sql = $sql . ((searchWhere($sql) === false) ? ' WHERE ' . $buf : ' AND ' . $buf);
    }
    if (strlen($book['authorName'])) {
        $buf = "author LIKE '%{$book['authorName']}%'"; 
        $sql = $sql . ((searchWhere($sql) === false) ? ' WHERE ' . $buf : ' AND ' . $buf);
    }

    if (strlen($book['status'])) {
        $buf = "status = '{$book['status']}'"; 
        $sql = $sql . ((searchWhere($sql) === false) ? ' WHERE ' . $buf : ' AND ' . $buf);
    }
    if (strlen($book['evaluation'])) {
        $buf = "score = {$book['evaluation']}"; 
        $sql = $sql . ((searchWhere($sql) === false) ? ' WHERE ' . $buf : ' AND ' . $buf);
    }
    if (strlen($book['thoughts'])) {
        $buf = "summary LIKE '%{$book['thoughts']}%'"; 
        $sql = $sql . ((searchWhere($sql) === false) ? ' WHERE ' . $buf : ' AND ' . $buf);
    }

    $results = mysqli_query($link, $sql);
    while ($book = mysqli_fetch_assoc($results)) {
        $reviews[] = $book;
    }
    mysqli_free_result($results);
    return $reviews;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 検索ボタンが押された場合の処理
    $book = [
        'bookName' => $_POST['bookName'],
        'authorName' => $_POST['authorName'],
        'status' => $_POST['status'],
        'evaluation' => $_POST['evaluation'],
        'thoughts' => $_POST['thoughts']
    ];

    // dbの接続
    $link = dbConnect();
    //レビュー情報を取得
    $reviews = getSearchReviews($link, $book);
    mysqli_close($link);

} else {
    //db接続
    $link = dbConnect();
    $reviews = listBooklog($link);
    mysqli_close($link);
}

$title = '読書ログの一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';
