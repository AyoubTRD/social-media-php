<?php
header("Access-Control-Allow-Origin: *");
include "../variables.php";
function getRequestDataBody()
{
  $body = file_get_contents('php://input');

  if (empty($body)) {
    return [];
  }

  // Parse json body and notify when error occurs
  $data = json_decode($body, true);
  if (json_last_error()) {
    trigger_error(json_last_error_msg());
    return [];
  }

  return $data;
}
$response = ["data" => [], "status" => "ok"];

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
  $user_id_1 = mysqli_real_escape_string($connection, $user["id"]);
  $user_id_2 = mysqli_real_escape_string($connection, $_GET["user_id"]);

  $query = "UPDATE messages SET seen = 1 WHERE user_from = $user_id_2 AND user_to = $user_id_1";

  $res = mysqli_query($connection, $query);

  if (!$res) {
    http_response_code(500);
    $response["status"] = "error";
    $response["data"] = mysqli_error($connection);
    echo json_encode($response);
    die();
  }

  if (!isset($_GET["no_fetch"])) {
    $query = "SELECT * FROM messages WHERE (user_from = $user_id_1 AND user_to = $user_id_2) OR (user_from = $user_id_2 AND user_to = $user_id_1)";

    $res = mysqli_query($connection, $query);
    if (!$res) {
      http_response_code(500);
      $response["status"] = "error";
      $response["data"] = mysqli_error($connection);
      echo json_encode($response);
      die();
    }
    $messages = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $response["data"] = $messages;
  }
}

if ($method === "POST") {
  $body = getRequestDataBody();
  if (isset($body["create"])) {
    $message_content = $body["message"]["content"];
    $message_receiver = $body["message"]["to"];
    $message_sender = $body["message"]["from"];
    $message_created_at = $body["message"]["createdAt"];
    $message_content_escaped = mysqli_real_escape_string($connection, $message_content);
    $message_receiver_escaped = mysqli_real_escape_string($connection, $message_receiver);
    $message_sender_escaped = mysqli_real_escape_string($connection, $message_sender);
    $message_created_at_escaped = mysqli_real_escape_string($connection, $message_created_at);

    $query = "INSERT INTO messages (user_from, user_to, content, created_at) ";
    $query .= "VALUES ($message_sender_escaped, $message_receiver_escaped, '$message_content_escaped', '$message_created_at_escaped')";

    $res = mysqli_query($connection, $query);
    if (!$res) {
      http_response_code(400);
      $response["status"] = mysqli_error($connection);
    }
  }
  elseif (isset($body["delete"])) {
    $message_id = $body["message"]["id"];
    $message_id_escaped = mysqli_real_escape_string($connection, $message_id);

    $query = "DELETE FROM messages WHERE message_id = $message_id_escaped";
  }
}

echo json_encode($response);