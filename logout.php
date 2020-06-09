<?php
  include 'variables.php';
  if ($is_logged_in) {
    $_SESSION["userid"] = null;
    $is_logged_in = 0;
  }
  header("Location: $website_base");
?>
