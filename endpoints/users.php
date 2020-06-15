<?php
include "../variables.php";
$user_id = $user["id"];
$response = array("data" => [], "status" => "ok");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {

  if (isset($_GET["messages"])) {
    $query = "SELECT name, gender, avatar, cover, id, is_online, (SELECT COUNT(*) FROM messages WHERE seen != 1 AND user_from = u.id AND user_to = $user_id) AS unseen_messages, (SELECT content AS last_message_content FROM messages WHERE (user_from = $user_id AND user_to = u.id) OR (user_from = u.id AND user_to = $user_id) ORDER BY message_id DESC LIMIT 1) AS last_message_content ";
    $query .= "FROM users u WHERE id != $user_id";
  } else {
    $query = "SELECT name, gender, avatar, cover, id, is_online FROM users WHERE id != $user_id";
  }

  $res = mysqli_query($connection, $query);
  if (!$res) {
    $response["status"] = "error";
    $response["data"] = mysqli_error($connection);
    $response["query"] = $query;
    http_response_code(500);
  } else {
    $users = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $response["data"] = $users;
  }
}

echo json_encode($response);