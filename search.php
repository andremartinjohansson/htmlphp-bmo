<?php

include("incl/header.php");

$search = isset($_GET['search'])
    ? $_GET['search']
    : null;

is_string($search) or is_null($search)
    or die("Incoming value for page must be a string.");
?>

<main class="search">
    <article>
        <h2>Sök efter artiklar och objekt</h2>
        <p>Här kan du söka efter BMO:s artiklar och objekt. Matchar på rubrik.</p>

        <!-- The search form -->
        <form method="get">
            <input type="search" name="search" value="<?=$search?>">
            <input type="submit" value="Sök">
        </form>

<!-- The result of the search -->
<?php

// Break script if empty $search
if (is_null($search)) {
    echo "";
} else {
    $sql = "SELECT * FROM Article WHERE category='article' AND title LIKE ?";
    $searchWild = "%" . $search . "%";
    $res = prepareSQL($sql, $searchWild);
    $sql = "SELECT * FROM Object WHERE title LIKE ?";
    $resObj = prepareSQL($sql, $searchWild);
}

if (isset($_GET['search'])) {
    $articles = null;
    $objects = null;
    foreach ($res as $data) {
        $articles = generateArticleThumb($articles, $data);
    }
    foreach ($resObj as $data) {
        $objects = generateObjectThumb($objects, $data);
    }
    if (empty($articles)) {
        $articles = "Din sökning matchade inga artiklar";
    }
    if (empty($objects)) {
        $objects = "Din sökning matchade inga objekt";
    }
    echo "<h4>Artiklar:</h4>" . $articles . "<h4>Objekt:</h4>" . $objects;
}

?>

    </article>
</main>

<?php
include("incl/footer.php");
?>
