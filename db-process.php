<?php
ob_start();

include("incl/header.php");

if ((isset($_POST['add'])) || (isset($_POST['save'])) || (isset($_POST['delete']))) {

    $add = isset($_POST['add']);
    $save = isset($_POST['save']);
    $delete = isset($_POST['delete']);

    if ($_POST['type'] == "article") {
        if ($add || $save) {
            $theID = $_POST['id'];
            $category = $_POST['category'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $author = $_POST['author'];
            $pubdate = $_POST['pubdate'];

            $params = [$theID, $category, $title, $content, $author, $pubdate];
            if ($save) {
                array_splice($params, 0, 1);
                array_push($params, $theID);
            }
        } elseif ($delete) {
            $theID = $_POST['ID'];
            $params = [$theID];
        }

        if ($add) {
            $sql = "INSERT INTO Article VALUES(?, ?, ?, ?, ?, ?)";
        } elseif ($save) {
            $sql = <<<EOD
        UPDATE Article
            SET
                category = ?,
                title = ?,
                content = ?,
                author = ?,
                pubdate = ?
            WHERE
                id = ?
EOD;
        } elseif ($delete) {
            $sql = <<<EOD
        DELETE FROM Article
            WHERE
                id = ?
EOD;
        }
    } elseif ($_POST['type'] == "objekt") {
        if ($add || $save) {
            $theID = $_POST['id'];
            $title = $_POST['title'];
            $category = $_POST['category'];
            $text = $_POST['text'];
            $image = $_POST['image'];
            $owner = $_POST['owner'];

            $params = [$theID, $title, $category, $text, $image, $owner];
            if ($save) {
                array_splice($params, 0, 1);
                array_push($params, $theID);
            }
        } elseif ($delete) {
            $theID = $_POST['id'];
            $params = [$theID];
        }

        if ($add) {
            $sql = "INSERT INTO Object VALUES(?, ?, ?, ?, ?, ?)";
        } elseif ($save) {
            $sql = <<<EOD
        UPDATE Object
            SET
                title = ?,
                category = ?,
                text = ?,
                image = ?,
                owner = ?
            WHERE
                id = ?
EOD;
        } elseif ($delete) {
            $sql = <<<EOD
        DELETE FROM Object
            WHERE
                id = ?
EOD;
        }
    }

    $stmt = $db->prepare($sql);

    ?>
    <main class="admin">
        <article>
            <?php
            try {
                $stmt->execute($params);
                echo "<h1>Uppdatering av databas lyckades!</h1><br>";
                echo "Du kommer att omdirigeras om 10 sekunder... ";
                if ($delete) {
                    echo "<a href='admin.php?page=delete'>Klicka här för att gå direkt</a><br>";
                    echo "<hr>Föremålen har tagits bort från databasen";
                } else {
                    echo "<a href='{$_SESSION['adminpage']}'>Klicka här för att gå direkt</a><br>";
                    echo "<hr>";
                    if ($_POST['type'] == "article") {
                        echo "<h2>{$_POST['title']}</h2>
                        {$_POST['content']}<br><hr>
                        <div class='article-info'>
                        <span>{$_POST['author']}</span><br>
                        <span><em>Publicerad {$_POST['pubdate']}</em></span>
                        </div><br><br>";
                    } elseif ($_POST['type'] == "objekt") {
                        echo "<h2>{$_POST['title']}</h2>
                        <img src='img/550x550/{$_POST['image']}' alt='{$_POST['title']}'><br>
                        <h3>Beskrivning</h3>
                        <p>{$_POST['text']}
                        <h3>Kategori</h3>
                        <a href='object.php?category={$_POST['category']}'>{$_POST['category']}</a>
                        <h3>Ägare</h3>
                        <p>{$_POST['owner']}</p>";
                    }
                }
            } catch (PDOException $e) {
                echo "<p>Uppdateringen misslyckades.</p>";
                echo "<p>Skickat \$_POST:<pre>" . print_r($_POST, true) . "</pre>";
                echo "<p>Errorn: " . $stmt->errorCode();
                echo "<p>Meddelande:<pre>" . print_r($stmt->errorInfo(), true) . "</pre>";
                throw $e;
            } ?>
            </article>
        </main> <?php
}

// Load footer
include("incl/footer.php");

// To debug a processingpage, before it does its redirect
//var_dump($_SESSION);
//die();

//var_dump($params);
//exit();
if ((isset($_POST['add'])) || (isset($_POST['save'])) || (isset($_POST['delete']))) {
    // Redirect to the previous page
    if ($delete) {
        header("refresh:10; url=admin.php?page=delete");
    } else {
        header("refresh:10; url=" . $_SESSION['adminpage']);
    }
}
