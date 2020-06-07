<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$website_name = "Hello MySQL World";
$website_base = "http://localhost/hello-world/mysql";
if (isset($_ENV["WEBSITE_BASE_URL"]) && $_ENV["WEBSITE_BASE_URL"]) {
  $website_base = $_ENV["WEBSITE_BASE_URL"];
}
$is_logged_in = 0;
$user = array();

if (isset($_SESSION["userid"]) && $_SESSION["userid"]) {
  $user_id = $_SESSION["userid"];
  $connection = mysqli_connect("localhost", "root", "", "helloworld");

  $query = "SELECT * FROM users WHERE id = $user_id";
  $res = mysqli_query($connection, $query);

  $user = mysqli_fetch_assoc($res);
  if ($user) {
    $is_logged_in = 1;
  } else {
    $_SESSION["userid"] = "";
  }
}
?>
