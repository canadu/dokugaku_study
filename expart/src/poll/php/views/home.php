<?php

namespace view\home;

function index($topics)
{
    $topic = array_shift($topics);
    \partials\topic_header_item($topic);
?>
    <ul class="container">
        <?php
        foreach ($topics as $topic) {
            $url = get_url('topic/edit?topic_id=' . $topic->id);
            \partials\topic_list_item($topic, $url, true);
        }
        ?>
    </ul>
<?php } ?>