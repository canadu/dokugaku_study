<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/css/app.css">
    <link rel="stylesheet" href="stylesheets/css/custom.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <title><?php echo $title; ?></title>
</head>
<body>
    <!-- ヘッダーを固定する -->
    <header class="sticky-bottom">
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-4">
            <a class="navbar-brand" href="index.php">memo</a> 
            <!-- ハンバーガーメニュー -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#myNavbar"
                aria-controls="myNavbar" aria-expanded="false" aria-label="ハンバーガーメニュー">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="myNavbar">
                <ul class="navbar-nav mt-2">
                    <li class="nav-item"><a class="nav-link" href="new_user"><i class="fas fa-user"></i> Sign Up</a></li>
                    <li class="nav-item"><a class="nav-link" href="login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- ここまで！！ -->
    <div class="container">
        <?php include $content; ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>