<?php
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>読書ログの登録</title>
</head>

<body>
    <h1>読書ログ</h1>
    <h3>読書ログの記録</h3>
    <form action="" method="post">
        <div>
            <label for="bookName">書籍名</label>
            <input type="text" id="bookName" name="bookName">
        </div>
        <div>
            <label for="authorName">著者名</label>
            <input type="text" id="authorName" name="authorName">
        </div>
        <div>
            <input type="radio" name="status" id="unRead" value="unRead">
            <label for="unRead">未読</label>
        </div>
        <div>
            <input type="radio" name="status" id="Reading" value="Reading">
            <label for="Reading">読んでいる</label>
        </div>
        <div>
            <input type="radio" name="status" id="Read" value="Read">
            <label for="Read">読了</label>
        </div>
        <div>
            <label for="evaluation">評価（５点満点の整数）</label>
            <input type="text" id="evaluation" name="evaluation">
        </div>
        <div>
            <label for="thoughts">感想</label>
            <textarea name="textarea" id="thoughts" rows="10"></textarea>
        </div>
        <button type="submit">登録する</button>
    </form>


</body>

</html>