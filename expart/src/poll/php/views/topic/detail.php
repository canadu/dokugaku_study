<?php

namespace view\topic\detail;

use model\TopicModel;

/**
* 投稿ページの詳細を表示する
*@param TopicModel $topic
*@param array<mixed> $comments
*/
function index(TopicModel $topic, array $comments) : void
{
    $topic = escape($topic);
    $comments = escape($comments);
    \partials\topic_header_item($topic, false);
    //phpここまで==============================================
    ?>
    <ul class="list-unstyled my-5">
        <?php foreach ($comments as $comment) : ?>
            <?php
            $agree_label = $comment->agree ? '賛成' : '反対';
            $agree_cls = $comment->agree ? 'badge-success' : 'badge-danger';
            ?>
            <li class="bg-white shadow-sm mb-3 rounded p-3">
                <h2 class="h4 mb-2">
                    <span class="badge badge-success mr-1 align-bottom <?php echo $agree_cls; ?>">
                        <?php echo $agree_label ?></span>
                    <span><?php echo $comment->body; ?></span>
                </h2>
                <span>Commented by <?php echo $comment->nickname; ?></span>
                <div class="col-auto mx-auto">
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php
}
