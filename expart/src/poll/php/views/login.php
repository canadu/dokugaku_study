<?php

//namespace controller\login;

?>
<!-- <h3>Loginページです</h3> -->
<!-- 自分自身のページにPOSTする -->
<!-- <form action="<?php echo CURRENT_URI; ?>" method="POST">
    <div>
        id: <input type="text" name="id" id="">
    </div>
    <div>
        password: <input type="password" name="pwd" id="">
    </div>
    <div>
        <input type="submit" value="ログイン">
    </div>
</form> -->
<?php

// namespace 

function index()
{
?>
    <!-- sr-onlyは画面上には表示されない -->
    <h1 class="sr-only">ログイン</h1>
    <div class="mt-5">
        <div class="text-center mb-4">
            <img width="65" src="images/logo.svg" alt="みんなのアンケート サイトロゴ">
        </div>
        <div class="login-form bg-white p-4 shadow-sm mx-auto rounded">

            <form action="<?php echo CURRENT_URI; ?>" method="POST">
                <div class="form-group">
                    <label for="">ユーザーID</label>
                    <input type="text" name="id" id="" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">パスワード</label>
                    <input type="password" name="pwd" id="" class="form-control">
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <a href="<?php the_url('register'); ?>">アカウント登録</a>
                    </div>
                    <div>
                        <input type="submit" value="ログイン" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php } ?>