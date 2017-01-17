<?php

include("incl/header.php");

$res = prepareSQL($sqlArticle, "maggy");

$rows = null;
foreach ($res as $row) {
    $maggyTitle = $row['title'];
    $maggyContent = $row['content'];
}

?>
<main class="maggy">
    <article>
        <h2><?= $maggyTitle ?></h2>
        <?= $maggyContent ?>
    </article>
</main>
<?php
include("incl/footer.php");
?>
