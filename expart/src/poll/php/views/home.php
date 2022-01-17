<?php

namespace view\home;

/**
 * homeページを出力する
 * @param array<mixed> $topics
*/
function index(array $topics) : void
{
    $topics = escape($topics);
    // 配列の先頭から要素を一つ切り出す
    $topic = array_shift($topics);
    \partials\topic_header_item($topic, true);
    //phpここまで==============================================
    ?>
    <ul class="container">
        <?php
        foreach ($topics as $topic) {
            $url = get_url('topic/detail?topic_id=' . $topic->id);
            \partials\topic_list_item($topic, $url, false);
        }
        ?>
    </ul>
    <?php
}