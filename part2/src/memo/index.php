<?php

require_once __DIR__ . '/lib/DataSource.php';

// db接続
function getMemoData() {
    try {
        $db = new DataSource();
        $results = $db->select('SELECT * FROM memos ORDER BY create_at DESC');
    } catch(PDOException $e) {
        echo 'エラーが発生しました。<br>';
        die();
    }
    return $results;
}
$results = getMemoData();
$title = '一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';