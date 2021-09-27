<h2 class="h3 text-dark mb-4">読書ログの登録</h2>

<form action="create.php" method="POST">
    <?php if (count($errors)) : ?>
        <ul class="text-danger">
            <?php foreach ($errors as $error) : ?>
                <li><?php echo ($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <div class="form-group">
        <label for="bookName">書籍名</label>
        <input type="text" id="bookName" class="form-control" name="bookName" value="<?php echo $book['bookName']; ?>">
    </div>

    <div class="form-group">
        <label for="authorName">著者名</label>
        <input type="text" id="authorName" class="form-control" name="authorName" value="<?php echo $book['authorName']; ?>">
    </div>

    <!-- ラジオボタン -->
    <div class="form-group">
        <label>読書状況</label>
        <div>
            <div class="form-check form-check-inline">
                <input type="radio" name="status" class="form-check-input" id="unRead" value="unRead" <?php echo ($book['status'] === 'unRead') ? ('checked') : (''); ?>>
                <label for="unRead" class="form-check-label">未読</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="status" class="form-check-input" id="Reading" value="Reading" <?php echo ($book['status'] === 'Reading') ? ('checked') : (''); ?>>
                <label for="Reading" class="form-check-label">読んでいる</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="status" class="form-check-input" id="Read" value="Read" <?php echo ($book['status'] === 'Read') ? ('checked') : (''); ?>>
                <label for="Read" class="form-check-label">読了</label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="evaluation">評価（５点満点の整数）</label>
        <input type="text" id="evaluation" class="form-control" name="evaluation" value="<?php echo $book['evaluation']; ?>">
    </div>

    <div class="form-group">
        <label for="thoughts">感想</label>
        <textarea name="thoughts" id="thoughts" class="form-control" rows="10" value="<?php echo $book['thoughts']; ?>"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">登録する</button>
</form>