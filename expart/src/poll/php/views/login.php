<?php

namespace controller\login;
?>
<h1>Loginページです</h1>
<form action="<? echo CURRENT_URI; ?>" method="POST">
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