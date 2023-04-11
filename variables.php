<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$website_name = "TRD Social Media";
$website_base = "http://localhost:8888";
if (isset($_ENV["WEBSITE_BASE_URL"]) && $_ENV["WEBSITE_BASE_URL"]) {
  $website_base = $_ENV["WEBSITE_BASE_URL"];
}
$realtime_server = "http://localhost:8080/";
if (isset($_ENV["NODE_SERVER"]) && $_ENV["NODE_SERVER"]) {
  $realtime_server = $_ENV["NODE_SERVER"];
}
$is_logged_in = 0;
$user = array();

$db_host = "localhost:3306";
$db_user = "root";
$db_password = "";
$db_name = "social_media_php";


if (isset($_ENV["DB_HOST"])) {
  $db_host = $_ENV["DB_HOST"];
}
if (isset($_ENV["DB_USER"])) {
  $db_user = $_ENV["DB_USER"];
}
if (isset($_ENV["DB_PASSWORD"])) {
  $db_password = $_ENV["DB_PASSWORD"];
}
if (isset($_ENV["DB_NAME"])) {
  $db_name = $_ENV["DB_NAME"];
}

$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
if (!$connection) {
  die("Failed to connect to database ".mysqli_error($connection));
}

if (isset($_SESSION["userid"]) && $_SESSION["userid"]) {
  $user_id = $_SESSION["userid"];

  $query = "SELECT * FROM users WHERE id = $user_id";
  $res = mysqli_query($connection, $query);

  $user = mysqli_fetch_assoc($res);
  if ($user) {
    $is_logged_in = 1;
  } else {
    $_SESSION["userid"] = "";
  }

  $user_id = -1;
  if (isset($user["id"])) {
    $user_id = $user["id"];
  }
  $start_query = "SELECT p.post_id, p.content, p.images, p.created_at, p.user_id, u.name, u.avatar, u.gender, c.comment_id, c.content AS comment_content, c.images AS comment_images, c.created_at AS comment_created_at, c.user_id AS comment_user_id, cu.name AS comment_user_name, cu.gender AS comment_user_gender, cu.avatar AS comment_user_avatar, (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.post_id) AS likes, (SELECT COUNT(*) FROM likes l WHERE l.post_id = p.post_id AND l.user_id = $user_id) AS is_liked, (SELECT COUNT(*) FROM likes l WHERE l.comment_id = c.comment_id) AS comment_likes, (SELECT COUNT(*) FROM likes l WHERE l.comment_id = c.comment_id AND l.user_id = $user_id) AS comment_is_liked ";
}
?>
