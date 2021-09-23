<?php
require __DIR__ . '/lib/mysql.php';

function createBooklog($link, $book)
{
    $sql = <<<EOT
    INSERT INTO reviews (
        title,
        author,
        status,
        score,
        summary
    ) VALUES (
        "{$book['bookName']}",
        "{$book['authorName']}",
        "{$book['status']}",
        "{$book['evaluation']}",
        "{$book['thoughts']}"
    )
EOT;
    $result = mysqli_query($link, $sql);
    if (!$result) {
        error_log('Error: fail to create review');
        error_log('Debugging error:' . mysqli_error($link));
    }
}

function validate($book)
{
    $errors = [];

    if (!strlen($book['bookName'])) {
        $errors['bookName'] = "本の名前を入力してください。";
    } elseif (strlen($book['bookName']) > 100) {
        $errors['bookName'] = "本の名前を入力してください。";
    }
    if (!strlen($book['authorName'])) {
        $errors['authorName'] = "著者名の名前を入力してください。";
    } elseif (strlen($book['authorName']) > 100) {
        $errors['authorName'] = "著者名の名前を入力してください。";
    }

    if (!strlen($book['evaluation'])) {
        $errors['evaluation'] = "評価を入力してください。";
    } elseif (!is_numeric($book['evaluation'])) {
        $errors['evaluation'] = "数字で入力してください。";
    } elseif ((int)($book['evaluation']) <= 0 && (int)($book['evaluation']) <= 5) {
        $errors['evaluation'] = "数字は0から5の間で入力してください";
    }

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book = [
        'bookName' => $_POST['bookName'],
        'authorName' => $_POST['authorName'],
        'status' => $_POST['status'],
        'evaluation' => $_POST['evaluation'],
        'thoughts' => $_POST['thoughts']
    ];
    $errors = validate($book);
    if (!count($errors)) {
        $link = dbConnect();
        createBooklog($link, $book);
        mysqli_close($link);
        header("Location:index.php");
    }
}
include  'views/new.php';
