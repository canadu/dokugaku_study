<?php
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
session_start();

//カートに追加
if (isset($_POST['add_cart'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $id = htmlspecialchars($id, ENT_QUOTES);
    $name = htmlspecialchars($name, ENT_QUOTES);
    $price = htmlspecialchars($price, ENT_QUOTES);
    //$_SESSION['cart'][$id] = array('name' => $name, 'price' => $price, 'qty' => 1);
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty']++;
    } else {
        $_SESSION['cart'][$id] = array('name' => $name, 'price' => $price, 'qty' => 1);
    }
}
//空にする
if (isset($_POST['empty_cart'])) {
    $_SESSION['cart'] = NULL;
}
//削除
if (isset($_POST['delete_item'])) {
    $id = $_POST['id'];
    $id = htmlspecialchars($id, ENT_QUOTES);
    //指定した変数を破棄する
    unset($_SESSION['cart'][$id]);
}
//数量変更処理
if (isset($_POST['change_qty'])) {
    $id = $_POST['id'];
    $qty = mb_convert_kana($_POST['qty'], 'n', 'utf-8');
    $id = htmlspecialchars($id, ENT_QUOTES);
    $qty = htmlspecialchars($qty, ENT_QUOTES);
    if ((int)$qty !== 0) {
        //ゼロ以外の場合
        $_SESSION['cart'][$id]['qty'] = $qty;
    } else {
        //ゼロの場合
        unset($_SESSION['cart'][$id]);
    }
}
// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h4>カート</h4>
<?php
    $totalPrice = 0;
    if (isset($_SESSION['cart']) && count($_SESSION['cart']) !==0) {
        echo '<table>';
        foreach ($_SESSION['cart'] as $id => $item) {
            echo '<tr>';
            echo '<td>' . $item['name'] . '</td>';
            echo '<td>' . number_format($item['price']) . '円</td>';
            echo '<td>
                    <form method="post" action="cart.php">
                        <input type="text" name="qty" value="' . $item['qty'] . '">個
                        <input type="hidden" name="id" value="' . $id . '">
                        <input type="submit" name="change_qty" value="数量を変更">
                    </form>
                </td>';
            echo "</tr>";
            echo '<td>
                    <form method="post" action="cart.php">
                        <input type="hidden" name="id" value="' . $id . '">
                        <input type="submit" name="delete_item" value="削除">
                    </form>
                </td>';
            echo "</tr>";
            $totalPrice += (int)$item['price'] * $item['qty'];
        }
        echo '</table>';
        echo '合計：' . number_format($totalPrice) . '円';
        echo '<p>';
        echo '<form method="post" action="cart.php"><input type="submit" name="empty_cart" value="カートを空にする"></form>';
        echo '</p>';
    } else {
        echo 'カートは空です。';
    }
?>
    <h4>一覧</h4>
    <dl>
        <dt>テスト1</dt>
        <dd>1000円</dd>
        <dd>
            <form method="post" action="cart.php">
                <input type="submit" name="add_cart" value="入れる">
                <input type="hidden" name="id" value="1">
                <input type="hidden" name="name" value="テスト1">
                <input type="hidden" name="price" value="1000">
            </form>
        </dd>
        <dt>テスト2</dt>
        <dd>2000円</dd>
        <dd>
            <form method="post" action="cart.php">
                <input type="submit" name="add_cart" value="入れる">
                <input type="hidden" name="id" value="2">
                <input type="hidden" name="name" value="テスト2">
                <input type="hidden" name="price" value="2000">
            </form>
        </dd>
        <dt>テスト3</dt>
        <dd>3000円</dd>
        <dd>
            <form method="post" action="cart.php">
                <input type="submit" name="add_cart" value="入れる">
                <input type="hidden" name="id" value="3">
                <input type="hidden" name="name" value="テスト3">
                <input type="hidden" name="price" value="3000">
            </form>
        </dd>
    </dl>  
</body>
</html>