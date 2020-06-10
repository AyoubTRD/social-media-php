<?php
  include_once '../variables.php';
  if (!$is_logged_in) {
    echo "Permission error";
    header("Location: $redirect_uri#auth_error=1");
  }
  $redirect_uri = $website_base;

  if (isset($_GET["redirect_uri"])) {
    $redirect_uri = $_GET["redirect_uri"];
  }

  if (isset($_POST["submit"])) {
    $content = $_POST["comment_content"];
    $post_id = $_POST["post_id"];

    if (!$content) {
      header("Location: $redirect_uri#comment_error=content&post_id=$post_id");
    }

    $content_q = mysqli_real_escape_string($connection, $content);
    $post_id_q = mysqli_real_escape_string($connection, $post_id);
    $user_id = $user["id"];

    $query = "INSERT INTO comments (content, user_id, post_id) ";
    $query .= "VALUES ('$content_q', $user_id, $post_id_q) ";

    $res = mysqli_query($connection, $query);

    if (!$res) {
      header("Location: $redirect_uri#comment_error=server&post_id=$post_id");
    }

    header("Location: $redirect_uri#comment_success=1");
  }

  if (isset($_POST["delete"])) {
    $comment_id = mysqli_real_escape_string($connection, $_POST["comment_id"]);
    $user_id = $user["id"];

    $query = "DELETE FROM comments ";
    $query .= "WHERE comment_id = $comment_id AND user_id = $user_id ";

    $res = mysqli_query($connection, $query);

    echo $query;

    if (!$res) {
      header("Location: $redirect_uri#comment_delete_error=1");
    }

    header("Location: $redirect_uri#comment_delete_success=1");
  }
