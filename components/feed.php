<?php
  include_once $_SERVER['DOCUMENT_ROOT']."/functions.php";
  if (!$is_logged_in) {
      header("Location: $website_base");
  }

  $res = mysqli_query($connection, $query);
  if (!$res) {
      echo "<p class='text-red-500 mt-4'>Failed to get your feed.</p>";
  } else {
      ?>

  <h2 class="my-2"><?php echo $feed_title ?></h2>
  <?php
    $posts_res = mysqli_fetch_all($res, MYSQLI_ASSOC);
      $posts = format_posts($posts_res);
      foreach ($posts as $post) {
          include $_SERVER["DOCUMENT_ROOT"]."/components/post.php";
      }
      if (!$posts) {
          echo "<p class='text-gray-600 text-xl text-center'>".isset($no_posts_message) ? $no_posts_message : 'No feed'."</p>";
      } ?>
<?php
  } ?>
