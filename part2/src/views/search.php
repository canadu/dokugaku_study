<!-- <h2 class="h3 text-dark mb-4">読書ログの登録</h2> -->
<h2 class="h3 text-dark mb-4">検索</h2>

<form action="index.php" method="POST">

    <div class="form-group">
        <label for="bookName">書籍名</label>
        <input type="text" id="bookName" class="form-control" name="bookName" value="<?php echo $book['bookName']; ?>">
        <!-- <input type="text" id="bookName" class="form-control" name="bookName" value=""> -->
    </div>

    <div class="form-group">
        <label for="authorName">著者名</label>
        <!-- <input type="text" id="authorName" class="form-control" name="authorName" value="<?php echo $book['authorName']; ?>"> -->
        <input type="text" id="authorName" class="form-control" name="authorName" value="">
    </div>
    <!-- ラジオボタン -->
    <div class="form-group">
        <label>読書状況</label>
        <div>
            <div class="form-check form-check-inline">
                <input type="radio" name="status" class="form-check-input" id="unRead" value="unRead" <?php echo ($book['status'] === 'unRead') ? ('checked') : (''); ?>>
                <!-- <input type="radio" name="status" class="form-check-input" id="unRead" value="unRead" checked> -->
                <label for="unRead" class="form-check-label">未読</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="status" class="form-check-input" id="Reading" value="Reading" <?php echo ($book['status'] === 'Reading') ? ('checked') : (''); ?>>
                <!-- <input type="radio" name="status" class="form-check-input" id="Reading" value="Reading"> -->
                <label for="Reading" class="form-check-label">読んでいる</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" name="status" class="form-check-input" id="Read" value="Read" <?php echo ($book['status'] === 'Read') ? ('checked') : (''); ?>>
                <!-- <input type="radio" name="status" class="form-check-input" id="Read" value="Read"> -->
                <label for="Read" class="form-check-label">読了</label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="evaluation">評価（５点満点の整数）</label>
        <input type="text" id="evaluation" class="form-control" name="evaluation" value="<?php echo $book['evaluation']; ?>">
        <!-- <input type="text" id="evaluation" class="form-control" name="evaluation" value=""> -->
    </div>
    <div class="form-group">
        <label for="thoughts">感想</label>
        <textarea name="thoughts" id="thoughts" class="form-control" rows="10" value="<?php echo $book['thoughts']; ?>"></textarea>
        <!-- <textarea name="thoughts" id="thoughts" class="form-control" rows="10" value=""></textarea> -->
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-success">検索する</button>
        <a href="index.php" class="btn btn-secondary">戻る</a>
    </div>

</form>