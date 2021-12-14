<?php

require_once __DIR__ . '/lib/DataSource.php';

function updateMemo(array $memoInfo) {
    $db = new DataSource();
    $sql = "UPDATE memos SET title = :title, memo = :memo WHERE id = :id AND userId = :userId";
    $db->execute($sql, [
        ':title' => $memoInfo['memoTitle'],
        ':memo' => $memoInfo['memo'],
        ':id' => $memoInfo['id'],
        ':userId' => $memoInfo['userId']
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memoInfo = [
        'userId' => $_POST['userId'],
        'id' => $_POST['id'],
        'memoTitle' => $_POST['title'],
        'memo' => $_POST['memo']
    ];
    // $errors = validate($book);
    // if (!count($errors)) {
    //     $link = dbConnect();
    //     createBooklog($link, $book);
    //     mysqli_close($link);
    updateMemo($memoInfo);
    header("Location:index.php");
    // }
}
$title = '編集';
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';