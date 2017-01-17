<?php
// Start session
$name = substr(preg_replace('/[^a-z\d]/i', '', dirname(__DIR__)), -30);
session_name($name);
session_start();

$thisPage = basename($_SERVER['SCRIPT_NAME']);

$QueryString = basename($_SERVER['QUERY_STRING']);

// Create a DSN for the database using its filename
$fileName = dirname(__DIR__) . "/db/bmo2.sqlite";
$dsn = "sqlite:$fileName";

/**
* Generate navbar link class for selected page
*/
function selected($pageURI)
{
    if ($GLOBALS['thisPage'] == $pageURI) {
        echo 'class="selected"';
    }
}

/**
* Open the database file and catch the exception it it fails.
*/
function connectDatabase($dsn)
{
    try {
        $db = new PDO($dsn);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        echo "Failed to connect to the database using DSN:<br>$dsn<br>";
    }
}

$db = connectDatabase($dsn);

/**
* Generate header title for pages. Collected in one place for easy editing
*/
function title($scriptName)
{
    $mainTitle = "Begravningsmuseum Online | ";
    $pageTitle = [
        "index.php" => $mainTitle . "Välkommen",
        "about.php" => $mainTitle . "Om BMO",
        "maggy.php" => $mainTitle . "Maggy's Artikel",
        "article.php" => $mainTitle . "Artiklar",
        "object.php" => $mainTitle . "Objekt",
        "search.php" => $mainTitle . "Sök",
        "gallery.php" => $mainTitle . "Galleri",
        "admin.php" => $mainTitle . "Administration",
        "db-process.php" => $mainTitle . "Databas",
    ];
    foreach ($pageTitle as $uri => $title) {
        if ($scriptName == $uri) {
            echo $title;
        }
    }
}

$sqlArticle = "SELECT * FROM Article WHERE category LIKE ?";
$sqlObject = "SELECT * FROM Object WHERE category LIKE ?";

/**
* Prepare and execute SQL statement with given parameter
*/
function prepareSQL($sql, $param)
{
    $stmt = $GLOBALS['db']->prepare($sql);
    $params = [$param];
    $stmt->execute($params);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $res;
}

/**
* Make current category selected in dropdown
*/
function selectedCategory($category, $value)
{
    if ($category == $value) {
        echo "selected";
    }
}

/**
* Generate HTML for article thumbnail
*/
function generateArticleThumb($content, $data)
{
    if (strpos($GLOBALS['QueryString'], "page=update") !== false) {
        $href = "admin.php?page=update&id={$data['id']}";
    } elseif (strpos($GLOBALS['QueryString'], "page=delete") !== false) {
        $href = "admin.php?page=delete&id={$data['id']}";
    } else {
        $href = "article.php?id={$data['id']}";
    }
    $content .= "<div class='article-item'>
    <a href='{$href}'>{$data['title']}</a><br>
    <span>{$data['author']}</span><br>
    <span><em>Publicerad: {$data['pubdate']}</em></span>
    </div><br>";
    return $content;
}

/**
* Generate HTML for related objects
*/
function generateRelatedObject($objects, $item)
{
    $objects .= "<div class='related-item'>
    <a href='object.php?id={$item['id']}'><img src='img/80x80/{$item['image']}' alt='{$item['title']}'></a>
    </div>";
    return $objects;
}

/**
* Generate HTML for article
*/
function generateArticle($content, $data)
{
    $content = "<h2>{$data['title']}</h2>
    {$data['content']}<br><hr>
    <div class='article-info'>
    <span>{$data['author']}</span><br>
    <span><em>Publicerad {$data['pubdate']}</em></span>
    </div>
    <div class='article-back-link'>
    <a href='article.php'>Tillbaka till artiklar</a>
    </div>";
    return $content;
}

/**
* Generate HTML for object thumbnail
*/
function generateObjectThumb($content, $data)
{
    if (strpos($GLOBALS['QueryString'], "page=update") !== false) {
        $href = "admin.php?page=update&ob={$data['id']}";
    } elseif (strpos($GLOBALS['QueryString'], "page=delete") !== false) {
        $href = "admin.php?page=delete&ob={$data['id']}";
    } else {
        $href = "object.php?id={$data['id']}";
    }
    $content .= "<div class='object-item'>
    <img src='img/80x80/{$data['image']}' alt='{$data['title']}'>
    <a href='{$href}'>{$data['title']}</a><br>
    <span>Kategori: <em>{$data['category']}</em></span><br>
    </div><br>";
    return $content;
}

/**
* Generate links for navigating between objects
*/
function generateObjectMain($content, $data, $theID, $nrOfObjects)
{
    $nextID = $theID + 1;
    $prevID = $theID - 1;
    if ($nextID <= $nrOfObjects) {
        $nextHREF = "href='object.php?id={$nextID}'";
    } else {
        $nextHREF = "href='object.php?id={$nextID}' class='disabled'";
    }
    if ($prevID >= 1) {
        $prevHREF = "href='object.php?id={$prevID}'";
    } else {
        $prevHREF = "href='object.php?id={$prevID}' class='disabled'";
    }
    if ($theID == 1) {
        $firstHREF = "href='object.php?id=1' class='disabled'";
    } else {
        $firstHREF = "href='object.php?id=1'";
    }
    if ($theID == $nrOfObjects) {
        $lastHREF = "href='object.php?id={$nrOfObjects}' class='disabled'";
    } else {
        $lastHREF = "href='object.php?id={$nrOfObjects}'";
    }
    $content = "<div class='object-navigation'>
    <a {$firstHREF}>Första</a>
    <a {$prevHREF}>Förgående</a>
    <span>Objekt {$data['id']} av {$nrOfObjects} totalt</span>
    <a {$nextHREF}>Nästa</a>
    <a {$lastHREF}>Sista</a>
    </div>
    <h2>{$data['title']}</h2>
    <img src='img/550x550/{$data['image']}' alt='{$data['title']}'><br>
    <h3>Beskrivning</h3>
    <p>{$data['text']}
    <h3>Kategori</h3>
    <a href='object.php?category={$data['category']}'>{$data['category']}</a>
    <h3>Ägare</h3>
    <p>{$data['owner']}</p>
    <hr>
    <a href='object.php'>Tillbaka till objekt</a>";
    return $content;
}

/**
* Generate gallery item
*/
function generateGalleryItem($content, $data)
{
    $content .= "<div class='gallery-item'>
    <a href='img/full-size/{$data['image']}'><img src='img/250x250/{$data['image']}' alt='{$data['title']}'></a>
    </div>";
    return $content;
}
