<div class="ui feed bg-white px-2 py-2 sm:py-5 sm:px-5 rounded shadow-md">
  <div class="event has-settings">
    <?php if ($post["user_id"] === $user["id"]) { ?>
      <div class="ui dropdown settings">
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
      <img src="<?php echo get_avatar($post) ?>">
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
        <a class="post-like like <?php echo $post['is_liked'] ? 'active' : '' ?>" data-post-id="<?php echo $post['post_id'] ?>">
          <i class="like icon"></i>
          <span class="likes-count"><?php echo $post["likes"] ?></span> Likes
        </a>
      </div>
    </div>
  </div>
    <div class="mb-4">
      <h3 class="text-xl font-bold mb-3" style="margin-top: 1.25rem">Comments</h3>
      <hr class="divider">
      <div class="ui comments xs:px-3 sm:px-6">
      <?php if (!$post["comments"]) { ?>
        <p class="my-3 text-lg text-center text-gray-600">This post has no comments yet.</p>
      <?php } ?>
      <?php foreach ($post["comments"] as $comment) { ?>
        <div class="comment">
          <?php if ($comment["user_id"] === $user["id"]) { ?>
            <div class="ui dropdown settings">
              <i class="ellipsis horizontal icon"></i>
              <div class="menu">
                <form class="submit-on-click item" action="<?php echo $website_base.'/endpoints/comments.php?redirect_uri='.$_SERVER['REQUEST_URI'] ?>" method="post">
                  <i class="trash icon"></i>
                  Delete
                  <input type="hidden" name="delete" value="delete">
                  <input type="hidden" name="comment_id" value="<?php echo $comment['comment_id']; ?>">
                </form>
              </div>
            </div>
          <?php } ?>
          <a class="avatar">
            <img src="<?php echo get_avatar($comment) ?>">
          </a>
          <div class="content">
            <a class="author" href="<?php echo $website_base.'/users/profile.php?user_id='.$comment['user_id'] ?>">
              <?php echo $comment["name"] ?>
            </a>
            <div class="metadata">
              <span class="date"><?php echo $comment["created_at"] ?></span>
            </div>
            <div class="text">
              <?php echo $comment["content"] ?>
            </div>
            <div class="actions">
              <a class="comment-like like <?php echo $comment['is_liked'] ? 'active' : '' ?>" data-comment-id="<?php echo $comment["comment_id"] ?>">
                <i class="like icon"></i>
                <span class="likes-count"><?php echo $comment["likes"] ?></span> Likes
              </a>
            </div>
          </div>
        </div>
      <?php } ?>
        <form class="ui reply form" action="<?php echo $website_base.'/endpoints/comments.php?redirect_uri='.$_SERVER['REQUEST_URI'] ?>" method="post">
          <input type="hidden" name="post_id" value="<?php echo $post['post_id'] ?>">
          <div class="field">
            <textarea rows="3" placeholder="Say something..." name="comment_content" value="" style="height: 6rem"></textarea>
          </div>
          <input type="submit" name="submit" class="ui button primary" value="Comment">
        </form>
      </div>
    </div>
</div>
