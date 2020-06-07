<?php
  include 'variables.php';
  if ($is_logged_in) {
    setcookie("userid", "", time() - 3600);
    $is_logged_in = 0;
  }
  header("Location: $website_base");
?>
