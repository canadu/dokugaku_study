<?php
require __DIR__ . '/lib/mysql.php';
require __DIR__ . '/lib/escape.php';


function listCompanies($link)
{
    $companies = [];
    $sql = 'SELECT * FROM companies';
    $results = mysqli_query($link, $sql);
    // 結果の行を連想配列で取得する
    while ($company = mysqli_fetch_assoc($results)) {
        $companies[] = $company;
    }
    // 結果に関連付けられたメモリを開放する
    mysqli_free_result($results);
    return $companies;
}
$link = dbConnect();
$companies = listCompanies($link);

$title = '会社情報の一覧';
$content = __DIR__ . '/views/index.php';
include __DIR__ .  '/views/layout.php';
