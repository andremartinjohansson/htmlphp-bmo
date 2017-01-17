<?php
include("incl/header.php");


$res = prepareSQL($sqlArticle, "article");

$content = null;
foreach ($res as $data) {
    $content = generateArticleThumb($content, $data);
}

$theID = isset($_GET['id'])
        ? $_GET['id']
        : null;

is_string($theID) or is_null($theID)
    or die("Incoming value for page must be a string.");

if ($theID) {
    $objects = null;
    $items2 = null;
    foreach ($res as $data) {
        if ($theID == 1) {
            $items = prepareSQL($sqlObject, "Begravningskonfekt");
            break;
        } elseif ($theID == 2) {
            $items = prepareSQL($sqlObject, "Minnestavla");
            break;
        } elseif ($theID == 3) {
            $items = prepareSQL($sqlObject, "Pärlkrans");
            break;
        } elseif ($theID == 5) {
            $items = prepareSQL($sqlObject, "Begravningsfest");
            $items2 = prepareSQL($sqlObject, "Begravningstal");
        }
    }
    foreach ($items as $item) {
        $objects = generateRelatedObject($objects, $item);
    }
    if ($items2 !== null) {
        foreach ($items2 as $item) {
            $objects = generateRelatedObject($objects, $item);
        }
    }
    $content = null;
    foreach ($res as $data) {
        if ($data['id'] == $theID) {
            $content = generateArticle($content, $data);
            break;
        }
    }
    if ($data['id'] != $theID) {
        $content = "Looks like the article you're looking for doesn't exist";
    }
}
?>

<main class="article">
    <article>
        <?php if ($QueryString != true) {
            echo "<h2>Artiklar</h2>
            <p>Här är en samling av BMO:s artiklar. Det finns totalt " . count($res) . " artiklar som listas nedan.</p>";
}
        echo $content;
if (strpos($QueryString, "id=") !== false) {
    echo "<aside class='related'>
        <h4>Relaterade objekt</h4>
        $objects
    </aside>";
}
        ?>
    </article>
</main>
<?php
include("incl/footer.php");
?>
