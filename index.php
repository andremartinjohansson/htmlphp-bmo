<?php

include("incl/header.php");

$res = prepareSQL($sqlArticle, "start");

$rows = null;
foreach ($res as $row) {
    $startTitle = $row['title'];
    $startContent = $row['content'];
}

?>

<main class="index">
    <article>
        <h2><?=$startTitle?></h2>
        <?=$startContent?>
    </article>
</main>
<?php
include("incl/footer.php");
?>
