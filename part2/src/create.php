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
    var_dump($result);
    if (!$result) {
        error_log('Error: fail to create review');
        error_log('Debugging error:' . mysqli_error($link));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book = [
        'bookName' => $_POST['bookName'],
        'authorName' => $_POST['authorName'],
        'status' => $_POST['status'],
        'evaluation' => $_POST['evaluation'],
        'thoughts' => $_POST['thoughts']
    ];
    
    $link = dbConnect();
    createBooklog($link, $book);
    mysqli_close($link);
}

header("Location:index.php");
