<?php
include("incl/config.php");

// Get and save current page in session
$_SESSION['currentpage'] = basename($_SERVER["REQUEST_URI"]);
?>
<!doctype html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <title><?= title($thisPage) ?></title>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all">
    <link rel="shortcut icon" href="img/favicon.png">
</head>
<body>
    <header class="site-header">
        <img src="img/bmo.PNG" alt="BMO">
        <div class="admin-link">
            <a href="admin.php" class="admin-link">Admin</a>
            <br>
            <?php
            if (isset($_SESSION['username'])) { ?>
                <a href="logout.php" class="admin-link">Logga ut</a> <?php
            }
            ?>
        </div>
    </header>
    <nav class="site-nav">
        <ul>
            <li <?= selected("index.php") ?>><a href="index.php">Hem</a></li>
            <li <?= selected("about.php") ?>><a href="about.php">Om Museet</a></li>
            <li <?= selected("maggy.php") ?>><a href="maggy.php">Maggy's Artikel</a></li>
            <li <?= selected("article.php") ?>><a href="article.php">Artiklar</a></li>
            <li <?= selected("object.php") ?>><a href="object.php">Objekt</a></li>
            <li <?= selected("search.php") ?>><a href="search.php">Sök</a></li>
            <li <?= selected("gallery.php") ?>><a href="gallery.php">Galleri</a></li>
        </ul>
    </nav>
