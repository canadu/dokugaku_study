<?php

namespace view\login;

/**
 * ログインページを表示する
 */
function index(): void
{
    //phpここまで==============================================
?>
    <!-- sr-onlyは画面上には表示されない -->
    <h1 class="sr-only">ログイン</h1>
    <div class="mt-5">
        <div class="text-center mb-4">
            <img width="65" src="images/logo.svg" alt="みんなのアンケート サイトロゴ">
        </div>
        <div class="login-form bg-white p-4 shadow-sm mx-auto rounded">
            <form class="validate-form" action="<?php echo CURRENT_URI; ?>" method="POST" novalidate autocomplete="off">
                <div class="form-group">
                    <label for="">ユーザーID</label>
                    <input type="text" required name="id" class="form-control validate-target" pattern="[a-zA-Z0-9]+" minLength="4" maxLength="10" autofocus>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="form-group">
                    <label for="">パスワード</label>
                    <input type="password" required name="pwd" class="form-control validate-target" minLength="4">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <a href="<?php the_url('register'); ?>">アカウント登録</a>
                    </div>
                    <div>
                        <input type="submit" disabled value="ログイン" class="btn btn-primary shadow-sm">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
}
