<?php
  if (!$is_logged_in) {
    header("Location: $website_base");
  }
?>

<form class="ui form" action="<?php echo $website_base."/endpoints/posts.php" ?>" method="post" enctype="multipart/form-data">
  <div class="field">
    <label for="content">Post content</label>
    <textarea id="content" name="content" value="" placeholder="What's on your mind? <?php echo $user['name']; ?>!"></textarea>
  </div>
  <label for="images" class="ui button labeled icon small green" style="margin-bottom: 0.75rem">
      <i class="upload icon"></i> Upload images
  </label>
  <input type="file" name="images[]" id="images" accept="image/jpeg, image/png" style="display: none" multiple>
    <input type="submit" name="submit" value="Create post" class="ui button primary" style="display: block; width: 100%">
  <?php if (isset($_GET["posterror"])) { ?>
    <div class="ui message red visible">
      <p>An error occured while creating your post.</p>
    </div>

  <?php } ?>
</form>
