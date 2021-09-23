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
    <form action="create.php" method="POST">
        <?php if (count($errors)) : ?>
            <?php foreach ($errors as $error) : ?>
                <li>
                    <?php echo ($error); ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
        <div>
            <label for="bookName">書籍名</label>
            <input type="text" id="bookName" name="bookName" value="<?php echo $book['bookName']; ?>">
        </div>
        <div>
            <label for="authorName">著者名</label>
            <input type="text" id="authorName" name="authorName" value="<?php echo $book['authorName']; ?>">
        </div>
        <div>
            <input type="radio" name="status" id="unRead" value="unRead" <?php echo ($book['status'] === 'unRead') ? ('checked') : (''); ?>>
            <label for="unRead">未読</label>
        </div>
        <div>
            <input type="radio" name="status" id="Reading" value="Reading" <?php echo ($book['status'] === 'Reading') ? ('checked') : (''); ?>>
            <label for="Reading">読んでいる</label>
        </div>
        <div>
            <input type="radio" name="status" id="Read" value="Read" <?php echo ($book['status'] === 'Read') ? ('checked') : (''); ?>>
            <label for="Read">読了</label>
        </div>
        <div>
            <label for="evaluation">評価（５点満点の整数）</label>
            <input type="text" id="evaluation" name="evaluation" value="<?php echo $book['evaluation']; ?>">
        </div>
        <div>
            <label for="thoughts">感想</label>
            <textarea name="thoughts" id="thoughts" rows="10" value="<?php echo $book['thoughts']; ?>"></textarea>
        </div>
        <button type="submit">登録する</button>
    </form>
</body>

</html>