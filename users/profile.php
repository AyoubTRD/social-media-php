<?php
$profile_id = $_GET["user_id"];
include_once "../variables.php";

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
  <div class="ui container profile-picture-container">
  <?php if ($profile["avatar"]) { ?>
    <div class="profile-picture border-gray-600 border-4" style="
    background-image: url(<?php echo $profile['avatar'] ?>)
    "></div>
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
