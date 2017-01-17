<nav class="admin-nav">
    <ul>
        <li><a href="admin.php">Meny</a></li>
        <li><a href="admin.php?page=update" class="active-a">Redigera</a></li>
        <li><a href="admin.php?page=create">Skapa</a></li>
        <li><a href="admin.php?page=delete">Ta bort</a></li>
    </ul>
</nav>

<p>Uppdatera en artikel eller ett okjekt. Välj i listan vad du vill uppdatera.</p>

<?php

$theID = isset($_GET['id'])
    ? $_GET['id']
    : null;

// Check incoming value
is_string($theID) or is_null($theID)
    or die("Incoming value for page must be a string.");

$category = null;
$title = null;
$content = null;
$author = null;
$pubdate = null;

$theObjID = isset($_GET['ob'])
    ? $_GET['ob']
    : null;

// Check incoming value
is_string($theObjID) or is_null($theObjID)
    or die("Incoming value for page must be a string.");

$title = null;
$category = null;
$text = null;
$image = null;
$owner = null;

$sql = "SELECT * FROM Article WHERE title LIKE ?";
$res = prepareSQL($sql, "%");
$sql = "SELECT * FROM Object WHERE title LIKE ?";
$resObj = prepareSQL($sql, "%");

if ($theID) {
    $sql = "SELECT * FROM Article WHERE id LIKE ?";
    $updateRes = prepareSQL($sql, $theID);
    $category = $updateRes[0]['category'];
    $title = $updateRes[0]['title'];
    $content = $updateRes[0]['content'];
    $author = $updateRes[0]['author'];
    $pubdate = $updateRes[0]['pubdate'];
    if (empty($updateRes)) {
        die("No such ID");
    }
}

if ($theObjID) {
    $sql = "SELECT * FROM Object WHERE id LIKE ?";
    $updateRes = prepareSQL($sql, $theObjID);
    $title = $updateRes[0]['title'];
    $category = $updateRes[0]['category'];
    $text = $updateRes[0]['text'];
    $image = $updateRes[0]['image'];
    $owner = $updateRes[0]['owner'];
    if (empty($updateRes)) {
        die("No such ID");
    }
}

$articles = null;
$objects = null;
foreach ($res as $data) {
    $articles = generateArticleThumb($articles, $data);
}
foreach ($resObj as $data) {
    $objects = generateObjectThumb($objects, $data);
}

if ($theID) { ?>
    <form method="post" action="db-process.php" class="article-form update-form">
        <fieldset>
            <legend>Uppdatera artikel</legend>
            <p><label>id<br><input type="number" name="id" value="<?=$theID?>" readonly></label></p>
            <p><label>category<br><input type="text" name="category" value="<?=$category?>"></label></p>
            <p><label>title<br><input type="text" name="title" value="<?=$title?>"></label></p>
            <p><label>content<br><textarea rows="8" cols="100" name="content"><?=$content?></textarea></label></p>
            <p><label>author<br><input type="text" name="author" value="<?=$author?>"></label></p>
            <p><label>pubdate<br><input type="text" name="pubdate" value="<?=$pubdate?>"></label></p>
            <input type="hidden" name="type" value="article">
            <p><button type="submit" name="save">Spara</button></p>
        </fieldset>
    </form> <?php
} elseif ($theObjID) { ?>
    <form method="post" action="db-process.php" class="object-form update-form">
        <fieldset>
            <legend>Uppdatera objekt</legend>
            <p><label>id<br><input type="number" name="id" value="<?=$theObjID?>" readonly></label></p>
            <p><label>title<br><input type="text" name="title" value="<?=$title?>"></label></p>
            <p><label>category<br><input type="text" name="category" value="<?=$category?>"></label></p>
            <p><label>text<br><textarea rows="4" cols="100" name="text"><?=$text?></textarea></label></p>
            <p><label>image<br><input type="text" name="image" value="<?=$image?>"></label></p>
            <p><label>owner<br><input type="text" name="owner" value="<?=$owner?>"></label></p>
            <input type="hidden" name="type" value="objekt">
            <p><button type="submit" name="save">Spara</button></p>
        </fieldset>
    </form> <?php
}

echo "<h4>Artiklar:</h4>" . $articles . "<h4>Objekt:</h4>" . $objects;

?>
