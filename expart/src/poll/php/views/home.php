<?php

namespace view\home;

function index($topics)
{
    // 配列の先頭から要素を一つ切り出す
    $topic = array_shift($topics);
    \partials\topic_header_item($topic, true);
?>
    <ul class="container">
        <?php
        foreach ($topics as $topic) {
            $url = get_url('topic/detail?topic_id=' . $topic->id);
            \partials\topic_list_item($topic, $url, false);
        }
        ?>
    </ul>
<?php } ?>