<?php

include("incl/config.php");

ob_start();

?>

<?php
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);

   header("Location: " . $_SESSION['currentpage']);
