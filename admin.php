<?php
include("incl/header.php");

ob_start();

$_SESSION['adminpage'] = basename($_SERVER["REQUEST_URI"]);

// Get the selected page, or the default
$page = (isset($_GET['page'])) ? $_GET['page'] : "intro";

// Check incoming value
is_string($page) or is_null($page)
    or die("Incoming value for page must be a string.");

// Directory the content-files
$dir  = __DIR__ . "/content/";

// Array with all the pages
$multipage = [
    "intro"    => "intro.php",
    "create"  => "create.php",
    "update"      => "update.php",
    "delete" => "delete.php",
    "read" => "read.php",
];

// Get the file to include
if (isset($multipage[$page])) {
    $file = $multipage[$page];
} else {
    die("The value of ?page=" . htmlentities($page) . " is not recognized as a valid page.");
}
?>

    <main class="admin">
        <article>
            <div>
                <?php if (empty($_SESSION['username'])) { ?>
                    <h2>Administration</h2>
                    <p>Du måste logga in för att komma åt administrativa verktyg</p>
<?php
}
$msg = '';
if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    if (($_POST['username'] == 'admin' && $_POST['password'] == 'admin') || ($_POST['username'] == 'doe' && $_POST['password'] == 'doe')) {
        $_SESSION['valid'] = true;
        $_SESSION['timeout'] = time();
        $_SESSION['username'] = $_POST['username'];

        ?>
        <script type="text/javascript">
            window.location.href = 'admin.php';
        </script>
        <?php
    } else {
        $msg = 'Fel användare eller lösenord';
    }
}
//var_dump($_SESSION['username']);
if (isset($_SESSION['username'])) {
    include("$dir/$file");
}
?>

            </div>
            <?php if (empty($_SESSION['username'])) { ?>
                <div>
                    <form action="admin.php" method="post">
                        <p><strong><?php echo $msg; ?></strong></p>
                        <input type="text" name="username" placeholder="Användare" required autofocus><br>
                        <input type="password" name="password" placeholder="Lösenord" required>
                        <button type="submit" name="login">Logga in</button>
                    </form>
                </div> <?php
} ?>
        </article>
    </main>
<?php
// Load footer
include("incl/footer.php");
?>
