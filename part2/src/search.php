<?php
require_once __DIR__ . '/lib/mysqli.php';

function getSearchReviews($link, $book) {
    $reviews = [];
    $buf = '';
    $sql = 'SELECT * FROM reviews';
    $src = $sql;

    // 検索条件を設定
    // if (strlen($book['bookName'])) {
    //     $buf = "title LIKE '%{$book['bookName']}%'"; 
    //     $sql = $sql . ($sql = $src) ? ' WHERE ': ' AND ' . $buf;
    // }
    // if (strlen($book['authorName'])) {
    //     $buf = "author LIKE '%{$book['authorName']}%'"; 
    //     $sql = $sql . ($sql = $src) ? ' WHERE ': ' AND ' . $buf;
    // }
    // if (strlen($book['status'])) {
    //     $buf = "status = '{$book['status']}'"; 
    //     $sql = $sql . ($sql = $src) ? ' WHERE ': ' AND ' . $buf;
    // }
    // if (strlen($book['evaluation'])) {
    //     $buf = "score = {$book['evaluation']}"; 
    //     $sql = $sql . ($sql = $src) ? ' WHERE ': ' AND ' . $buf;
    // }
    // if (strlen($book['thoughts'])) {
    //     $buf = "summary LIKE '%{$book['thoughts']}%'"; 
    //     $sql = $sql . ($sql = $src) ? ' WHERE ': ' AND ' . $buf;
    // }

    $sql .=  " WHERE title LIKE '%{$book['bookName']}%'";
    $results = mysqli_query($link, $sql);
    while ($book = mysqli_fetch_assoc($results)) {
        $reviews[] = $book;
    }
    mysqli_free_result($results);
    return $reviews;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    header("Location:index.php");
}

$title = '読書ログの一覧';
$content = __DIR__ . '/views/search.php';
include __DIR__ . '/views/layout.php';
