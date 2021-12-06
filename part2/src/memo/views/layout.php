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
    <nav class="navbar shadow-sm p-3 mb-5 bg-white">
        <a class="navbar-brand" href="#">
            <img src="" alt="" width="30" height="30" class="d-inline-block align-top">memo
        </a>
        <form class="form-inline">
            <input class="form-control mr-md-2" type="search"　placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-md-0" type="submit">検索</button>
        </form>
    </nav>
    <div class=" container">
        <?php include $content; ?>
    </div>
</body>
</html>