<?php

namespace partials;

use lib\Auth;
use model\TopicModel;
use model\UserModel;
/**
 * homeページ上部のトピックを出力する
 * @param TopicModel $topic
 * @param bool $from_top_page
*/
function topic_header_item(TopicModel $topic, bool $from_top_page) : void
{
    //phpここまで==============================================
    ?>
    <div class="row">
        <div class="col">
            <!-- 左側 -->
            <?php chart($topic) ?>
        </div>
        <div class="col my-5">
            <!-- 右側 -->
            <?php topic_main($topic, $from_top_page) ?>
            <?php comment_form($topic) ?>
        </div>
    </div>
    <?php
    //phpここから==============================================
}
/**
 * homeページ上部のグラフを出力
 * @param TopicModel $topic
*/
function chart(TopicModel $topic) : void
{
    //phpここまで==============================================
    ?>
    <canvas id="chart" width="400" height="400" data-likes="<?php echo $topic->likes; ?>" data-dislikes="<?php echo $topic->dislikes; ?>">
        <style>
            #chart {
                background-color: gray;
            }
        </style>
    </canvas>
    <?php
    //phpここから==============================================
}
/**
 * homeページ上部のアンケートの投票結果を出力
 * @param TopicModel|UserModel $topic nicknameはTopicModelにはない
 * @param bool $from_top_page
*/
function topic_main(TopicModel|UserModel $topic, bool $from_top_page) : void
{
    //phpここまで==============================================
    ?>
    <div>
        <?php if ($from_top_page) : ?>
            <!-- トップページから遷移してきた場合 -->
            <h1 class="sr-only">みんなのアンケート</h1>
            <h2 class="h1">
                <a class="text-body" href="<?php the_url('topic/detail?topic_id=' . $topic->id); ?>">
                    <?php echo $topic->title; ?>
                </a>
            </h2>
        <?php else : ?>
            <!-- トップページ以外から遷移された場合 -->
            <h1><?php echo $topic->title; ?></h1>
        <?php endif; ?>
        <span class="mr-1 h5">Posted by <?php echo $topic->nickname; ?></span>
        <span class="mr-1 h5">&bull;</span>
        <span class="h5"><?php echo $topic->views; ?>views</span>
    </div>
    <div class="container text-center my-4">
        <div class="row justify-content-around">
            <div class="likes-green col-auto">
                <div class="display-1"><?php echo $topic->likes; ?></div>
                <div class="h4 mb-0">賛成</div>
            </div>
            <div class="dislikes-red col-auto">
                <div class="display-1"><?php echo $topic->dislikes; ?></div>
                <div class="h4 mb-0">反対</div>
            </div>
        </div>
    </div>
    <?php
    //phpここから==============================================
}

/**
 * homeページ上部のアンケート部分を出力
 * @param TopicModel $topic
*/
function comment_form(TopicModel $topic) : void
{
    //phpここまで==============================================
    ?>
    <?php if (Auth::isLogin()) : ?>
        <form action="<?php the_url('topic/detail'); ?>" method="POST">
            <span class="h4">あなたは賛成？それとも反対？</span>
            <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
            <div class="form-group">
                <textarea class="w-100 border-light" name="body" id="body" rows="5"></textarea>
            </div>
            <div class="container">
                <div class="row h4 form-group">
                    <div class="col-auto d-flex align-items-center pl-0">
                        <!-- コントロールを横並びにする場合 -->
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" id="agree" name="agree" value=1 checked>
                            <label for="agree" class="form-check-label">賛成</label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input" type="radio" id="disagree" name="agree" value=0>
                            <label for="disagree" class="form-check-label">反対</label>
                        </div>
                    </div>
                    <input type="submit" value="送信" class="col btn btn-success shadow-sm">
                </div>

            </div>
        </form>
    <?php else : ?>
        <div class="text-center mt-5">
            <div class="mb-2">ログインしてアンケートに参加しよう!</div>
            <a href="<?php the_url('login'); ?>" class="btn btn-lg btn-success">ログインはこちら</a>
        </div>
    <?php endif; ?>
    <?php
}