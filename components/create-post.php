<?php
  if (!$is_logged_in) {
    header("Location: $website_base");
  }
?>

<form class="ui form" action="<?php echo $website_base."/endpoints/posts.php" ?>" method="post">
  <div class="field">
    <label for="content">Post content</label>
    <textarea id="content" name="content" value="" placeholder="What's on your mind? <?php echo $user['name']; ?>!"></textarea>
  </div>
  <input type="submit" name="submit" value="Create post" class="ui button primary">
  <?php if (isset($_GET["posterror"])) { ?>
    <div class="ui message red visible">
      <p>An error occured while creating your post.</p>
    </div>
  <?php } ?>
</form>
