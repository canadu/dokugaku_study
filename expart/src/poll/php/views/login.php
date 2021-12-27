<?php

namespace controller\login;
?>
<h3>Loginページです</h3>
<!-- 自分自身のページにPOSTする -->
<form action="<?php echo CURRENT_URI; ?>" method="POST">
    <div>
        id: <input type="text" name="id" id="">
    </div>
    <div>
        password: <input type="password" name="pwd" id="">
    </div>
    <div>
        <input type="submit" value="ログイン">
    </div>
</form>