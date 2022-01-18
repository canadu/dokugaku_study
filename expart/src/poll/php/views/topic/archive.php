<?php

namespace view\topic\archive;

/**
* 過去の投稿ページを表示する
*@param array<mixed> $topics
*/
function index(array $topics): void
{
    $topics = escape($topics);
    //phpここまで==============================================
    ?>
    <h1 class="h2 mb-3">過去の投稿</h1>
    <ul class="container">
        <?php
        foreach ($topics as $topic) {
            $url = get_url('topic/edit?topic_id=' . $topic->id);
            \partials\topic_list_item($topic, $url, true);
        }
        ?>
    </ul>
    <?php
}