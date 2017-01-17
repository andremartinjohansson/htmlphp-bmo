<nav class="admin-nav">
    <ul>
        <li><a href="admin.php">Meny</a></li>
        <li><a href="admin.php?page=update">Redigera</a></li>
        <li><a href="admin.php?page=create" class="active-a">Skapa</a></li>
        <li><a href="admin.php?page=delete">Ta bort</a></li>
    </ul>
</nav>

<?php

$type = isset($_GET['type'])
    ? $_GET['type']
    : null;

// Check incoming value
is_string($type) or is_null($type)
    or die("Incoming value for page must be a string.");

if (empty($_GET['type'])) { ?>
    <p>Skapa ny artikel eller okjekt. Välj vad du vill göra.</p> <?php
} else { ?>
    <p><a href="admin.php?page=create">Gå tillbaka</a></p> <?php
}
?>


<?php

if ($type == "article") { ?>
    <form method="post" action="db-process.php" class="article-form update-form">
        <fieldset>
            <legend>Skapa artikel</legend>
            <p><label>id<br><input type="number" name="id"></label></p>
            <p><label>category<br><input type="text" name="category"></label></p>
            <p><label>title<br><input type="text" name="title"></label></p>
            <p><label>content<br><textarea rows="8" cols="100" name="content"></textarea></label></p>
            <p><label>author<br><input type="text" name="author"></label></p>
            <p><label>pubdate<br><input type="text" name="pubdate"></label></p>
            <input type="hidden" name="type" value="article">
            <p><button type="submit" name="add">Skapa</button></p>
        </fieldset>
    </form> <?php
} elseif ($type == "object") { ?>
    <form method="post" action="db-process.php" class="object-form update-form">
        <fieldset>
            <legend>Skapa objekt</legend>
            <p><label>id<br><input type="number" name="id"></label></p>
            <p><label>title<br><input type="text" name="title"></label></p>
            <p><label>category<br><input type="text" name="category"></label></p>
            <p><label>text<br><textarea rows="4" cols="100" name="text"></textarea></label></p>
            <p><label>image<br><input type="text" name="image"></label></p>
            <p><label>owner<br><input type="text" name="owner"></label></p>
            <input type="hidden" name="type" value="objekt">
            <p><button type="submit" name="add">Skapa</button></p>
        </fieldset>
    </form> <?php
} else { ?>
    <a href="admin.php?page=create&amp;type=article" class="create-choice">Skapa artikel</a>
    <a href="admin.php?page=create&amp;type=object" class="create-choice">Skapa objekt</a> <?php
}

?>
