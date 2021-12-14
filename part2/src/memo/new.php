<?php

require_once __DIR__ . '/lib/DataSource.php';
use function PHPUnit\Framework\isEmpty;

$userMemoId = [];

//会員登録機能が出来たら、見直す！
if (!isset($_GET['userId']) || !isset($_GET['id'])) {
    header('Location: index.php');
} else {
    $userMemoId['userId'] = $_GET['userId'];
    $userMemoId['id'] = $_GET['id'];
}

/**
 * メモの情報を取得する関数
 * @param array $userMemoId ユーザーとメモのIDを保持する配列
 * @return array SQLの結果
 */
function getUserMemo(array $userMemoId): array 
{
    try {
        $db = new DataSource();
        $results = $db->select('SELECT * FROM memos WHERE userId=:userId AND id=:id',$userMemoId);
        return $results;
    } catch(PDOException $e) {
        echo 'エラーが発生しました。<br>';
        header('Location: indx.php');
    }
}
$results = getUserMemo($userMemoId);
$title = '追加';
$content = __DIR__ . '/views/new.php';
include __DIR__ . '/views/layout.php';