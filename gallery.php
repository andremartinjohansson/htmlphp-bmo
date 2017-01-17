<?php
include("incl/header.php");

$page = isset($_GET['page'])
        ? $_GET['page']
        : "1";

is_string($page) or is_null($page)
    or die("Incoming value for page must be a string.");

$res = prepareSQL($sqlObject, "%");

$content = null;
foreach ($res as $data) {
    if ($data['id'] <= 9) {
        $content = generateGalleryItem($content, $data);
    }
}
$nextHREF = "href='{$thisPage}?page=2'";
$prevHREF = "href='{$thisPage}?page=1' class='disabled'";
$firstHREF = "href='{$thisPage}?page=1' class='disabled'";
$lastHREF = "href='{$thisPage}?page=4'";

if ($page == 2) {
    $content = null;
    foreach ($res as $data) {
        if (($data['id'] > 9)  && ($data['id'] <= 18)) {
            $content = generateGalleryItem($content, $data);
        }
    }
    $nextHREF = "href='{$thisPage}?page=3'";
    $prevHREF = "href='{$thisPage}?page=1'";
    $firstHREF = "href='{$thisPage}?page=1'";
}
if ($page == 3) {
    $content = null;
    foreach ($res as $data) {
        if (($data['id'] > 18)  && ($data['id'] <= 27)) {
            $content = generateGalleryItem($content, $data);
        }
    }
    $nextHREF = "href='{$thisPage}?page=4'";
    $prevHREF = "href='{$thisPage}?page=2'";
    $firstHREF = "href='{$thisPage}?page=1'";
}
if ($page == 4) {
    $content = null;
    foreach ($res as $data) {
        if (($data['id'] > 27)  && ($data['id'] <= 36)) {
            $content = generateGalleryItem($content, $data);
        }
    }
    $nextHREF = "href='{$thisPage}?page=4' class='disabled'";
    $prevHREF = "href='{$thisPage}?page=3'";
    $firstHREF = "href='{$thisPage}?page=1'";
    $lastHREF = "href='{$thisPage}?page=4' class='disabled'";
}

?>

<main class="gallery">
    <article>
        <h2>Galleri</h2>
        <p>Detta är ett galleri av bilder som tillhör objekt i BMO:s samling.</p>
        <div class='gallery-navigation'>
            <a <?=$firstHREF?>>Första</a>
            <a <?=$prevHREF?>>Förgående</a>
            <span>Sida <?=$page?> av 4</span>
            <a <?=$nextHREF?>>Nästa</a>
            <a <?=$lastHREF?>>Sista</a>
        </div>
        <div class="gallery-section">
            <?php
            echo $content;
            ?>
        </div>
    </article>
</main>
<?php
include("incl/footer.php");
?>
