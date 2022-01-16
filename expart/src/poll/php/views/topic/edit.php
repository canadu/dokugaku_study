<?php

namespace view\topic\edit;

function index($topic, $is_edit)
{
    $header_title = $is_edit ? 'トピックの編集' : 'トピックの作成';
    $submit_title = $is_edit ? '編集' : '作成';
?>
    <h1 class="h2 mb-3"><?php echo $header_title; ?></h1>
    <div class="bg-white p-4 shadow-sm mx-auto rounded">
        <form action="<?php echo CURRENT_URI; ?>" method="POST">
            <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
            <div class="form-group">
                <label for="title">タイトル</label>
                <input type="text" name="title" id="title" value="<?php echo $topic->title; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="published">ステータス</label>
                <select name="published" id="published" class="form-control">
                    <option value="1" <?php echo $topic->published ? 'selected' : ''; ?>>公開</option>
                    <option value="0" <?php echo $topic->published ? '' : 'selected'; ?>>非公開</option>
                </select>
            </div>
            <div class="d-flex align-items-center">
                <div>
                    <input type="submit" value="<?php echo $submit_title; ?>" class="btn btn-primary mr-3">
                </div>
                <div>
                    <a href=<?php the_url('topic/archive'); ?>>戻る</a>
                </div>
            </div>
        </form>
    </div>
<?php
}
