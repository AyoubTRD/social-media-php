<?php
include "../variables.php";
$user_id = $user["id"];
$response = array("data" => [], "status" => "ok");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {

  $query = "SELECT name, gender, avatar, cover, id, is_online FROM users WHERE id != $user_id";

  $res = mysqli_query($connection, $query);
  if (!$res) {
    $response["status"] = "error";
    http_response_code(500);
  } else {
    $users = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $response["data"] = $users;
  }
}

echo json_encode($response);