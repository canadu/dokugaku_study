<?php

use function PHPUnit\Framework\isEmpty;
require_once __DIR__ . '/../lib/Common.php';

if (count($results) > 0) {
    $title = !empty($results['title']) ? h($results['title']) : '';
    $memo = !empty($results['memo']) ? h($results['memo']) : '';
} else {
    $title = '';
    $memo = '';
}
?>
<form action="create.php" method="POST">
    <div class="form-group">
        <label for="title">title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>">
    </div>
    <div class="form-group">
        <label for="memo">memo</label>
        <textarea class="form-control" id="memo" name="memo" rows="10"><?php echo $memo; ?></textarea>
    </div>
    <div class="text-right">
        <a class="btn btn-outline-secondary" href="index.php" role="button"><i class="fas fa-angle-left mr-1"></i>戻る</a>
        <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-edit mr-1"></i><?php echo $displayMode === 'new' ? '作成':'編集'; ?></button>
    </div>
    <input type="hidden" name="userId" value=<?php echo $userMemoId['userId']; ?>>
    <input type="hidden" name="id" value=<?php echo $userMemoId['id']; ?>>
    <input type="hidden" name="displayMode" value=<?php echo $displayMode ;?>>
</form>
