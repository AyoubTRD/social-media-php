<?php
include_once "../variables.php";
include_once "../g_drive.php";

$user_id = $user["id"];
foreach(["avatar", "cover"] as $image) {
  if (isset($_FILES[$image])) {
    $image_content = file_get_contents($_FILES[$image]["tmp_name"]);
    $image_drive_path = upload_file($service, $image_content);
    $image_q = mysqli_real_escape_string($connection, $image_drive_path);

    $query = "UPDATE users SET $image = '$image_q' WHERE id = $user_id";
    $res = mysqli_query($connection, $query);

    if(!$res) {
      die("An error occured".mysqli_error($connection));
    }
  }
}
$profile_id = $_GET["user_id"];

$query = "SELECT name, id, cover, avatar, birth_date, gender ";
$query .= "FROM users ";
$query .= "WHERE id = $profile_id";

$res = mysqli_query($connection, $query);

if (!$res) {
  echo "An error occured";
}

$profile = mysqli_fetch_assoc($res);

if (!$profile) {
  echo "User not found";
}

$is_auth_user = $user["id"] === $profile["id"];

$title = $profile["name"];
$no_container = 1;
include_once "../header.php";

?>

<div class="block bg-gray-700 cover" style="
   height: 550px;
   max-height: 70vh;
   <?php if ($profile['cover']) {
      echo 'background-image: url('.$profile['cover'].');';
    } ?>;
    background-size: cover;
">
  <?php if($is_auth_user) { ?>
  <form id="cover-form" class="ui label right corner blue cursor-pointer large" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
    <a class="cursor-pointer">
      <label class="cursor-pointer" for="cover"><i class="edit icon" style="cursor: pointer"></i></label>
      <input type="file" class="hidden" name="cover" id="cover" value="" accept="image/png, image/jpeg" onchange="document.querySelector('#cover-form').submit()">
    </a>
  </form>
  <?php } ?>
  <div class="ui container profile-picture-container">
  <?php if ($profile["avatar"]) { ?>
    <div class="profile-picture shadow-lg relative overflow-hidden rounded" style="
    background-image: url(<?php echo $profile['avatar'] ?>)
    ">
      <?php if ($is_auth_user) { ?>
      <form id="avatar-form" class="ui label right corner blue cursor-pointer" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" enctype="multipart/form-data">
        <a class="cursor-pointer">
          <label class="cursor-pointer" for="avatar"><i class="edit icon" style="cursor: pointer"></i></label>
          <input type="file" class="hidden" name="avatar" id="avatar" value="" accept="image/png, image/jpeg" onchange="document.querySelector('#avatar-form').submit()">
        </a>
      </form>
      <?php } ?>
    </div>
  <?php } else {?>
    <h1 class="text-white text-6xl text-shadow-black on-cover-text"><?php echo $profile["name"]; ?></h1>
  </div>
  <?php } ?>
</div>
</div>

<div class="ui container py-5 pb-10" style="
  <?php if ($profile['avatar']) {
    echo 'padding-top: 120px;';
    } ?>
">
  <?php if ($profile["birth_date"]) { ?>
    <div class="text-center">
      <div class="mx-auto w-24 h-24 flex items-center justify-center bg-blue-800 rounded-full">
        <i class="fas fa-baby text-white text-6xl"></i>
      </div>
      <h2 class="text-blue-700 text-4xl mt-4 mb-0"><?php echo $profile["name"] ?> </h2>
      <p class="text-gray-900 mt-1 text-xl">
        Born on <span class="font-bold text-gray-800"><?php echo $profile["birth_date"] ?></span> <i class="icon <?php echo $profile["gender"] ?>"></i>
      </p>
    </div>
    <hr class="divider my-10">
  <?php } ?>
  <?php
    $query = $start_query;
    $query .= "FROM posts p ";
    $query .= "JOIN users u ";
    $query .= "ON p.user_id = u.id ";
    $query .= "LEFT JOIN comments c ";
    $query .= "USING (post_id) ";
    $query .= "LEFT JOIN users cu ";
    $query .= "ON c.user_id = cu.id ";
    $query .= "WHERE p.user_id = $profile_id ";
    $query .= "ORDER BY p.post_id DESC";

    $feed_title = $profile["name"]."'s recent activity";
    $no_posts_message = "<strong>".$profile["name"]."</strong> has no posts.";
    include '../components/feed.php'
  ?>
</div>

<?php include "../footer.php" ?>
