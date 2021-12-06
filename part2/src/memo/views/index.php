<main>
    <div class="row">
        <!-- 新規作成用 -->
        <div class="col-md-4">
            <!-- カードが入ります01 -->
            <div class="card mb-3">
                <!-- カードの本文エリア -->
                <div class="card-body d-flex justify-content-between">
                    <!-- <h4 class="cartd-title class="btn btn-secondary"">てすてす１</h4> -->
                    <a class="btn btn-primary" href="#">新規追加</a>
                </div>
                <div class="card-footer footer-container">
                    <span>2021年12月3日12:00</span>
                    <div class="icon">
                        <a href="#" title="メモを編集"><i class="fas fa-edit"></i></a>
                        <a href="#" title="メモを削除"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <?php if (count($results) > 0): ?>
            <?php foreach ($results as $result) : ?>
                <div class="col-md-4">
                    <!-- カードが入ります01 -->
                    <div class="card mb-3">
                        <!-- カードの本文エリア -->
                        <div class="card-body d-flex justify-content-between">
                            <h4 class="cartd-title class="btn btn-secondary""><?php echo $result['title']; ?></h4>
                            <a class="btn btn-secondary" href="#">詳しく見る</a>
                        </div>
                        <div class="card-footer footer-container">
                            <span><?php echo $result['create_at']; ?></span>
                            <div class="icon">
                                <a href="#" title="メモを編集"><i class="fas fa-edit"></i></a>
                                <a href="#" title="メモを削除"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>