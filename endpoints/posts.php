<?php
  include '../variables.php';
  if (isset($_POST["submit"]) && $is_logged_in) {
    $post_content = $_POST["content"];

    $userid = $user["id"];
    $content_q = mysqli_real_escape_string($connection, $post_content);
    $query = "INSERT INTO posts ";
    $query .= "(user_id, content) ";
    $query .= "VALUES ($userid, '$content_q')";

    $res = mysqli_query($connection, $query);
    if ($res) {
      header("Location: $website_base");
    } else {
      header("Location: $website_base/?posterror=1");
    }
  }
  if (isset($_POST["delete"]) && $is_logged_in) {
    $post_id_q = mysqli_real_escape_string($connection, $_POST["post_id"]);
    $user_id = $user["id"];
    $query = "DELETE FROM posts ";
    $query .= "WHERE post_id = $post_id_q AND user_id = $user_id";

    $res = mysqli_query($connection, $query);
    if (!$res) {
      echo "An error occured while deleting the post <br>";
    } else {
      header("Location: $website_base");
    }
  }
?>
