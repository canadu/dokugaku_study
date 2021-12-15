<main>
    <div class="row">
        <?php if (count($results) > 0): ?>
            <?php foreach ($results as $result) : ?>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <!-- カードの本文エリア -->
                        <a href="new.php?userId=<?php echo $result['userId']; ?>&id=<?php echo $result['id']; ?>" class="card-body text-dark">
                            <!-- タイトル -->
                            <h5 class="card-title"><?php echo $result['title']; ?></h5>
                            <!-- メモ詳細 -->
                            <p class="card-text text-truncate"><?php echo $result['memo']; ?></p>
                        </a>
                        <div class="card-footer footer-container">
                            <small class="text-muted"><?php echo $result['create_at']; ?></small>
                            <div class="icon">
                                <a href="new.php?userId=<?php echo $result['userId']; ?>&id=<?php echo $result['id']; ?>" title="メモを編集"><i class="fas fa-edit"></i></a>
                                <a href="#" title="メモを削除"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <form action="new.php" method="POST">
        <button type="submit" class="btn btn-outline-secondary new-btn"><i class="fas fa-edit mr-1"></i>新規作成</button>
    </form>
</main>