<?php

require_once __DIR__ . '/lib/myDb.php';

// db接続
function getMemoData() {
    $clsDb = new myDb();
    $stmt = $clsDb->query('SELECT * FROM memos');
    $results = [];
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $results[] = $result;
    }
    return $results;
}
$results = getMemoData();
$title = '一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ . '/views/layout.php';

