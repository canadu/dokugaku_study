<?php

namespace view\register;

/**
 * アカウントを登録する
 */
function index(): void
{
    //phpここまで==============================================
?>
    <h1 class="sr-only">登録</h1>
    <div class="mt-5">
        <div class="text-center mb-4">
            <img width="65" src="images/logo.svg" alt="みんなのアンケート サイトロゴ">
        </div>
        <div class="login-form bg-white p-4 shadow-sm mx-auto rounded">
            <form class="validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate autocomplete="off">
                <div class="form-group">
                    <label for="id">ユーザーID</label>
                    <input type="text" required name="id" class="form-control validate-target" pattern="[a-zA-Z0-9]+" minLength="4" maxLength="10" autofocus>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="pwd">パスワード</label>
                    <input type="password" required name="pwd" class="form-control validate-target" minLength="4">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="nickname">ニックネーム</label>
                    <input type="text" required name="nickname" id="nickname" class="form-control validate-target" maxLength="10">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <a href="<?php the_url('login'); ?>">ログインへ</a>
                    </div>
                    <div>
                        <input disabled type="submit" value="登録" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
}
