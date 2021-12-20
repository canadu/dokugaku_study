<?php

namespace controller\register;
?>
<h1>Registerページです</h1>
<!-- 自分自身のページにPOSTする -->
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
</form>