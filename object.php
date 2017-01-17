<?php
include("incl/header.php");

$category = isset($_GET['category'])
        ? $_GET['category']
        : null;

is_string($category) or is_null($category)
    or die("Incoming value for page must be a string.");

$total = prepareSQL($sqlObject, "%");
$nrOfObjects = count($total);

if ($category != null) {
    if ($category != "Alla") {
        $res = prepareSQL($sqlObject, $category);
    } else {
        $res = $total;
    }
} else {
    $res = $total;
}

$content = null;
foreach ($res as $data) {
    $content = generateObjectThumb($content, $data);
}

$theID = isset($_GET['id'])
        ? $_GET['id']
        : null;

is_string($theID) or is_null($theID)
    or die("Incoming value for page must be a string.");

if ($theID) {
    $content = null;
    foreach ($res as $data) {
        if ($data['id'] == $theID) {
            $content = generateObjectMain($content, $data, $theID, $nrOfObjects);
            break;
        }
    }
    if ($data['id'] != $theID) {
        $content = "Looks like the article you're looking for doesn't exist";
    }
}

?>

<main class="object">
    <article>
        <?php if (strpos($QueryString, "id=") !== 0) {
            echo "<h2>Objekt</h2>
            <p>Här är en samling av BMO:s objekt. Just nu visas " . count($res) . " objekt i listan nedan av totalt " . $nrOfObjects . "</p>";
            ?>
            <form method="get">
                <label class="cat-dropdown"><strong>Visa kategori:</strong>
                    <select name="category" onchange="form.submit();">
                        <option value="Alla">Alla</option>
                        <option value="Begravningskonfekt" <?=$category == "Begravningskonfekt" ? "selected" : ""; ?>>Begravningskonfekt</option>
                        <option value="Begravningssked" <?=$category == "Begravningssked" ? "selected" : ""; ?>>Begravningssked</option>
                        <option value="Begravningstal" <?=$category == "Begravningstal" ? "selected" : ""; ?>>Begravningstal</option>
                        <option value="Begravningsfest" <?=$category == "Begravningsfest" ? "selected" : ""; ?>>Begravningsfest</option>
                        <option value="Inbjudningsbrev" <?=$category == "Inbjudningsbrev" ? "selected" : ""; ?>>Inbjudningsbrev</option>
                        <option value="Minnestavla" <?=$category == "Minnestavla" ? "selected" : ""; ?>>Minnestavla</option>
                        <option value="Pärlkrans" <?=$category == "Pärlkrans" ? "selected" : ""; ?>>Pärlkrans</option>
                    </select>
                </label>
            </form>
        <?php
}
        echo $content;
        ?>
    </article>
</main>
<?php
include("incl/footer.php");
?>
