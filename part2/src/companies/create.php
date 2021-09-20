<?php
require __DIR__ . '/lib/mysql.php';

function createCompany($link, $company)
{
    $sql = <<<EOT
    INSERT INTO companies (
        name,
        establishment_date,
        founder
    ) VALUES (
        "{$company['name']}",
        "{$company['establishment_date']}",
        "{$company['founder']}"
    )
EOT;
    $result = mysqli_query($link, $sql);
    if ($result) {
        echo '登録が完了しました。' . PHP_EOL;
    } else {
        echo '登録が失敗しました。' . PHP_EOL;
        echo 'Debugging error: ' . mysqli_connect_errno() . PHP_EOL;
    }
}
//HTTPメソッドがPOSTだったら

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //POSTされた会社情報を変数に格納する
    $company =  [
        'name' => $_POST['name'],
        'establishment_date' => $_POST['establishment_date'],
        'founder' => $_POST['founder']
    ];
    //バリデーションする

    //データベースにデータを接続する
    $link = dbConnect();

    //データベースにデータを登録する
    createCompany($link, $company);
    //データベースとの接続を切断する
    mysqli_close($link);
}
