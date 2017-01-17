<?php

include("incl/header.php");

$res = prepareSQL($sqlArticle, "about");

$rows = null;
foreach ($res as $row) {
    $aboutTitle = $row['title'];
    $aboutContent = $row['content'];
}

?>
<main class="about">
    <article>
        <h2><?= $aboutTitle ?></h2>
        <?= $aboutContent ?>
        <h2>Om webbplatsens skapare</h2>
        <p>Jag som skapare av denna version av BMO heter André Johansson, född
        1994 (22 år!) i en liten stad I Skåne, studerar Webbprogrammering
        på campus vid Blekinge Tekniska Högskola. När jag inte pluggar så
        skriver jag ofta kod till egna små projekt utanför skolan.
        <br><br>
        Jag kom först i kontakt med webbprogrammering i gymnasiet och har sedan
        då spenderat många, många timmar med främst HTML och CSS men också
        JavaScript och lite PHP. Huvudsakligen är det front-end som jag tycker
        om att jobba med. Och med många timmar i Photoshop loggade sedan
        tolv år, är design av en webbsida också något jag gillar jobba med.
        <br><br>
        När jag tar en paus from kodning och design så spenderas den mesta tid på
        internet eller att spela datorspel. Men jag har också stort intresse för
        flygplan och astronomi. Övar gärna flygning på simulator för att en dag
        kunna ta privat flygcertifikat.</p>
        <?php
        include("incl/byline.php");
        ?>
    </article>
</main>
<?php
include("incl/footer.php");
?>
