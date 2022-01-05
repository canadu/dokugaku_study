<?php

namespace view\register;
// namespace controller\register;
?>
<!-- <h3>Registerページです</h3>
自分自身のページにPOSTする
<form action="<?php echo CURRENT_URI; ?>" method="POST">
    <div>
        id: <input type="text" name="id" id="">
    </div>
    <div>
        pw: <input type="password" name="pwd" id="">
    </div>
    <div>
        nickname: <input type="text" name="nickname" id="">
    </div>
    <div>
        <input type="submit" value="登録">
    </div>
</form> -->
<?php
function register()
{
?>
<h1 class="sr-only">登録</h1>
    <div class="mt-5">
        <div class="text-center mb-4">
            <img width="65" src="images/logo.svg" alt="みんなのアンケート サイトロゴ">
        </div>
        <div class="bg-white p-4 shadow-sm mx-auto rounded">
            <form action="<?php echo CURRENT_URI; ?>" method="POST">
                <div class="form-group">
                    <label for="id">ユーザーID</label>
                    <input type="text" name="id" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="pwd">パスワード</label>
                    <input type="password" name="pwd" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="nickname">ニックネーム</label>
                    <input type="text" name="nickname" id="" class="form-control">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <input type="submit" value="登録" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } ?>