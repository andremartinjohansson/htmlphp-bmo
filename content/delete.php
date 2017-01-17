<nav class="admin-nav">
    <ul>
        <li><a href="admin.php">Meny</a></li>
        <li><a href="admin.php?page=update">Redigera</a></li>
        <li><a href="admin.php?page=create">Skapa</a></li>
        <li><a href="admin.php?page=delete" class="active-a">Ta bort</a></li>
    </ul>
</nav>

<p>Här kan du ta bort artiklar och objekt från BMO:s samling. Välj i listan vad du vill ta bort.</p>

<?php

$theID = isset($_GET['id'])
    ? $_GET['id']
    : null;

// Check incoming value
is_string($theID) or is_null($theID)
    or die("Incoming value for page must be a string.");

$theObjID = isset($_GET['ob'])
    ? $_GET['ob']
    : null;

// Check incoming value
is_string($theObjID) or is_null($theObjID)
    or die("Incoming value for page must be a string.");

$sql = "SELECT * FROM Article WHERE title LIKE ?";
$res = prepareSQL($sql, "%");
$sql = "SELECT * FROM Object WHERE title LIKE ?";
$resObj = prepareSQL($sql, "%");

$articles = null;
$objects = null;
foreach ($res as $data) {
    $articles = generateArticleThumb($articles, $data);
}
foreach ($resObj as $data) {
    $objects = generateObjectThumb($objects, $data);
}

if ($theID) {
    $sql = "SELECT * FROM Article WHERE id LIKE ?";
    $updateRes = prepareSQL($sql, $theID);
    $title = $updateRes[0]['title'];
    if (empty($updateRes)) {
        die("No such ID");
    }
}

if ($theObjID) {
    $sql = "SELECT * FROM Object WHERE id LIKE ?";
    $updateRes = prepareSQL($sql, $theObjID);
    $title = $updateRes[0]['title'];
    if (empty($updateRes)) {
        die("No such ID");
    }
}

if ($theID) { ?>
    <form method="post" action="db-process.php" class="object-form update-form">
        <fieldset>
            <legend>Ta bort artikel</legend>
            <p><label>id<br><input type="number" name="id" value="<?=$theID?>" readonly></label></p>
            <p><label>title<br><input type="text" name="title" value="<?=$title?>" readonly></label></p>
            <input type="hidden" name="type" value="article">
            <p><button type="submit" name="delete">Ta bort</button></p>
        </fieldset>
    </form> <?php
} elseif ($theObjID) { ?>
    <form method="post" action="db-process.php" class="object-form update-form">
        <fieldset>
            <legend>Ta bort objekt</legend>
            <p><label>id<br><input type="number" name="id" value="<?=$theObjID?>" readonly></label></p>
            <p><label>title<br><input type="text" name="title" value="<?=$title?>" readonly></label></p>
            <input type="hidden" name="type" value="objekt">
            <p><button type="submit" name="delete">Ta bort</button></p>
        </fieldset>
    </form> <?php
}

echo "<h4>Artiklar:</h4>" . $articles . "<h4>Objekt:</h4>" . $objects;

?>
