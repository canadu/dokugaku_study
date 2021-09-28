<!-- <h1 class="h2 text-dark mt-4 mb-4">読書ログの一覧</h1> -->
<!-- <a href="new.php" class="btn btn-info mb-4">読書ログを登録する</a> -->
<a href="../new.php" class="btn btn-info mb-4">登録する</a>
<main>
    <?php if (count($reviews) > 0) : ?>
        <?php foreach ($reviews as $review) : ?>
            <section class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title">
                        タイトル：<?php echo escape($review['title']); ?>
                    </h4>
                    <p class="card-text">
                    著者：<?php echo escape($review['author']); ?>&nbsp;|&nbsp;
                    状況：<?php echo escape($review['status']); ?>&nbsp;|&nbsp;
                    評価：<?php echo escape($review['score']); ?>&nbsp;|&nbsp;</p>
                    <p class="card-text">感想：<?php echo escape($review['summary']); ?></p>
                </div>
            </section>
        <?php endforeach; ?>
    <?php else : ?>
        <p>読書ログが登録されていません</p>
    <?php endif; ?>
</main>