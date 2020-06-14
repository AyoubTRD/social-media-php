<?php
header("Allow-Access-Origin: *");
header("application/json");

$response = ["status" => "ok", "data" => []];

include_once "../variables.php";

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
  $user_id = mysqli_real_escape_string($connection, $_GET["user_id"]);
  $user_status = mysqli_real_escape_string($connection, $_GET["status"]);

  $query = "UPDATE users SET is_online = $user_status WHERE id = $user_id";

  $res = mysqli_query($connection, $query);
   if (!$res) {
     http_response_code(500);
     $response["status"] = "error";
     $response["data"] = mysqli_error($connection);
   }
}

echo json_encode($response);
