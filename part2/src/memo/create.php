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

function insertMemo(array $memoInfo) {
    $db = new DataSource();
    $sql = "INSERT INTO memos (title, memo, userId) VALUES(:title, :memo, :userId)";
    $db->execute($sql, [
        ':title' => $memoInfo['memoTitle'],
        ':memo' => $memoInfo['memo'],
        ':userId' => $memoInfo['userId']
    ]);
}

$titleCaption = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memoInfo = [
        'userId' => $_POST['userId'],
        'id' => $_POST['id'],
        'memoTitle' => $_POST['title'],
        'memo' => $_POST['memo']
    ];
    if ($_POST['displayMode'] === 'new') {
        //新規の場合
        insertMemo($memoInfo);
        $titleCaption = '新規';
    } elseif ($_POST['displayMode'] === 'edit') {
        //編集の場合
        $titleCaption = '編集';
        updateMemo($memoInfo);
    } 
    header("Location:index.php");
    // }
}
$title = $titleCaption;
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';