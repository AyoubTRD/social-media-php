<?php
  $title = "Home";
  $no_container = 1;
  $active = "home";
  include "header.php";
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
    <?php include 'components/create-post.php'; ?>
    <hr class="ui divider">
    <?php
      $query = "SELECT p.post_id, p.content, p.images, p.created_at, p.user_id, u.name, u.avatar, u.gender ";
      $query .= "FROM posts p ";
      $query .= "JOIN users u ";
      $query .= "ON p.user_id = u.id ";
      $query .= "ORDER BY p.post_id DESC";
      $feed_title = "Recent activity";
      include 'components/feed.php' ?>
  </div>
<?php } ?>

<?php include "footer.php"; ?>
