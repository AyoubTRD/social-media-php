<?php
  $title = "Home";
  $no_container = 1;
  $active = "home";
  include_once "header.php";
?>

<?php if (!$is_logged_in) { ?>
  <div class="welcome">
    <div class="hero">
      <h1>Welcome! Start by creating an account.</h1>
      <a href="signup.php" class="ui button primary large">Create account</a>
      <a href="login.php" class="ui button grey large">Login</a>
    </div>
  </div>
<?php } else { ?>
  <div class="ui container py-10">
    <h1>Hello <?php echo $user["name"]; ?></h1>
    <?php include_once 'components/create-post.php'; ?>
    <hr class="ui divider">
    <?php
      $query = "SELECT p.post_id, p.content, p.images, p.created_at, p.user_id, u.name, u.avatar, u.gender, c.comment_id, c.content AS comment_content, c.images AS comment_images, c.created_at AS comment_created_at, c.user_id AS comment_user_id, cu.name AS comment_user_name, cu.gender AS comment_user_gender, cu.avatar AS comment_user_avatar ";
      $query .= "FROM posts p ";
      $query .= "JOIN users u ";
      $query .= "ON p.user_id = u.id ";
      $query .= "LEFT JOIN comments c ";
      $query .= "USING (post_id) ";
      $query .= "LEFT JOIN users cu ";
      $query .= "ON c.user_id = cu.id ";
      $query .= "ORDER BY p.post_id DESC";
      $feed_title = "Recent activity";
      include_once 'components/feed.php' ?>
  </div>
<?php } ?>

<?php include_once "footer.php"; ?>
