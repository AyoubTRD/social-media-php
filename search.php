<?php
  include_once "functions.php";
  $search_query = $_GET["search_query"];

  $title = "Search results for ".$search_query;
  $container_classes = "py-10";
  include_once "header.php";

  $search_query_q = mysqli_real_escape_string($connection, $search_query);

  $query = "SELECT id, name, avatar, gender ";
  $query .= "FROM users ";
  $query .= "WHERE name REGEXP '$search_query_q' ";
  $res = mysqli_query($connection, $query);

  if (!$res) {
      // Some error occured
  ?>
  <div class="w-64 h-32 rounded shadow-sm bg-white mx-auto flex items-center justify-center">
    <h1 class="text-red-500 text-center text-3xl uppercase">Some error occured</h1>
  </div>
  <?php } else {
      $found_users = 0; ?>
<div class="grid grid-cols-2 md:grid-cols-4 sm:grid-cols-3 xs:grid-cols-2 lg:grid-cols-6 xl:grid-cols-6 gap-10">
  <?php
      while ($user_res = mysqli_fetch_assoc($res)) {
          $found_users = 1; ?>
        <div class="transition border border-gray-300 duration-300 w-48 h-48 shadow-sm rounded flex flex-col align-center justify-around text-center py-2 px-4 hover:shadow-xl bg-white" style="justify-self: center">
          <img class="rounded-full w-20 h-20 mx-auto mb-1" src="<?php echo get_avatar($user_res) ?>" alt="<?php echo $user_res['name'] ?>'s profile picture">
          <h3 class="mb-3 mt-0 text-xl"><?php echo $user_res["name"] ?></h3>
          <a href="<?php echo $website_base.'/users/profile.php?user_id='.$user_res['id'] ?>" class="ui button primary">
            View profile
          </a>
        </div>
  <?php
      }
  ?>
</div>
<?php
  if ($found_users) {
      echo "<hr class='ui divider'>";
  }
?>

<?php
  $query = $start_query;
  $query .= "FROM posts p ";
  $query .= "JOIN users u ON p.user_id = u.id ";
  $query .= "LEFT JOIN comments c ";
  $query .= "USING (post_id) ";
  $query .= "LEFT JOIN users cu ";
  $query .= "ON c.user_id = cu.id ";
  $query .= "WHERE p.content REGEXP '$search_query_q' ";
  $query .= "OR u.name REGEXP '$search_query_q' ";
  $query .= "ORDER BY p.post_id DESC";

  $feed_title = "Posts that include ".$search_query;
  $no_posts_message = "No posts.";
  include 'components/feed.php';
}

?>

<?php include_once "footer.php"; ?>
