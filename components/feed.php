<?php
  if (!$is_logged_in) {
    header("Location: $website_base");
  }

  $res = mysqli_query($connection, $query);
  if (!$res) {
    echo "<p class='text-red-500 mt-4'>Failed to get your feed.</p>";
  } else {
?>

<div class="ui feed">
  <h2 class="my-2"><?php echo $feed_title ?></h2>
  <?php
    $posts_exist = 0;
    while ($post = mysqli_fetch_assoc($res)) {
    $posts_exist = 1;
  ?>
    <div class="event">
      <?php if ($post["user_id"] === $user["id"]) { ?>
        <div class="ui dropdown post-settings">
          <i class="ellipsis horizontal icon"></i>
          <div class="menu">
            <form class="submit-on-click item" action="<?php echo $website_base.'/endpoints/posts.php' ?>" method="post">
              <i class="trash icon"></i>
              Delete
              <input type="hidden" name="delete" value="delete">
              <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
            </form>
          </div>
        </div>
      <?php } ?>
      <div class="label pt-4">
        <img src="<?php if ($post['avatar']) {
          echo $post['avatar'];
        } else {
          echo 'https://avatars.dicebear.com/api/initials/'.$post['name'][0].'.svg';
        } ?>">
      </div>
      <div class="content">
        <div class="summary">
          <a class="user" href="<?php echo $website_base.'/users/profile.php?user_id='.$post['user_id']; ?>">
            <?php echo $post["name"]; ?>
          </a> has posted.
          <div class="date">
            <?php echo $post["created_at"]; ?>
          </div>
        </div>
        <div class="extra text">
          <?php echo $post["content"]; ?>
        </div>
        <div class="meta">
          <a class="like">
            <i class="like icon"></i> 8 Likes
          </a>
        </div>
      </div>
    </div>
  <?php }
    if (!$posts_exist) {
      echo "<p class='text-gray-600 text-xl text-center'>".$no_posts_message."</p>";
    }
  ?>
</div>
<?php } ?>
