<?php
  include_once "../variables.php";

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json");

  if (!$is_logged_in) {
      header("Location: $website_base");
  }

  $user_id = $user["id"];
  if (isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];
    $post_id_q = mysqli_real_escape_string($connection, $post_id);

    $get_like_query = "SELECT * FROM likes WHERE post_id = $post_id_q AND user_id = $user_id";

    $res = mysqli_query($connection, $get_like_query);

    if (!$res) {
      echo "This loeuf is not working\n";
      echo mysqli_error($connection);
    }

    if (mysqli_fetch_assoc($res)) {
      // We have to delete the like
      $query = "DELETE FROM likes WHERE post_id = $post_id_q AND user_id = $user_id";
      $message = "Like deleted";
    } else {
      // We have to create the like
      $query = "INSERT INTO likes (post_id, user_id) VALUES ($post_id_q, $user_id)";
      $message = "Like created";
    }
    $res = mysqli_query($connection, $query);

    if (!$res) {
      http_response_code(404);
      echo json_encode([
        "status" => 404,
        "message" => "This post does not exist"
      ]);
      die();
    }

    echo json_encode([
      "status" => 200,
      "message" => $message
    ]);
  }

  if (isset($_GET["comment_id"])) {
    $comment_id = $_GET["comment_id"];
    $comment_id_q = mysqli_real_escape_string($connection, $comment_id);

    $get_like_query = "SELECT * FROM likes WHERE comment_id = $comment_id_q AND user_id = $user_id";

    $res = mysqli_query($connection, $get_like_query);

    if (!$res) {
      echo "This loeuf is not working\n";
      echo mysqli_error($connection);
    }

    if (mysqli_fetch_assoc($res)) {
      // We have to delete the like
      $query = "DELETE FROM likes WHERE comment_id = $comment_id_q AND user_id = $user_id";
      $message = "Like deleted";
    } else {
      // We have to create the like
      $query = "INSERT INTO likes (comment_id, user_id) VALUES ($comment_id_q, $user_id)";
      $message = "Like created";
    }
    $res = mysqli_query($connection, $query);

    if (!$res) {
      http_response_code(404);
      echo json_encode([
        "status" => 404,
        "message" => "This comment does not exist"
      ]);
      die();
    }

    echo json_encode([
      "status" => 200,
      "message" => $message
    ]);
  }
