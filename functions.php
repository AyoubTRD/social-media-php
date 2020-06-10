<?php
  function encryptPassword($password)
  {
      $hash_format = "$2y$10$";
      $salt = "noneofyourbusiness";
      $encrypted = crypt($password, $hash_format.$salt);
      return $encrypted;
  }

  function get_avatar($user)
  {
      if ($user['avatar']) {
          return $user['avatar'];
      } else {
          return 'https://avatars.dicebear.com/api/initials/'.$user['name'][0].'.svg';
      }
  }

  function format_posts($posts)
  {
      if (!$posts) {
          return [];
      }
      $post = $posts[0];
      $formatted_posts = [$post];
      $comment = [
        "content" => $post["comment_content"],
        "images" => $post["comment_images"],
        "created_at" => $post["comment_created_at"],
        "user_id" => $post["comment_user_id"],
        "comment_id" => $post["comment_id"],
        "gender" => $post["comment_user_gender"],
        "avatar" => $post["comment_user_avatar"],
        "name" => $post["comment_user_name"],
        "likes" => $post["comment_likes"],
        "is_liked" => $post["comment_is_liked"]
      ];
      $formatted_posts[0]["comments"] = [];
      if ($formatted_posts[0]["comment_content"] !== null) {
          array_push($formatted_posts[0]["comments"], $comment);
      }
      $previous_post_id = $posts[0]["post_id"];
      for ($i = 1; $i < count($posts); $i++) {
          $post = $posts[$i];
          $comment = [
            "content" => $post["comment_content"],
            "images" => $post["comment_images"],
            "created_at" => $post["comment_created_at"],
            "user_id" => $post["comment_user_id"],
            "comment_id" => $post["comment_id"],
            "gender" => $post["comment_user_gender"],
            "avatar" => $post["comment_user_avatar"],
            "name" => $post["comment_user_name"],
            "likes" => $post["comment_likes"],
            "is_liked" => $post["comment_is_liked"]
          ];
          if ($post["post_id"] === $previous_post_id) {
              $last_i = count($formatted_posts) - 1;
              array_push($formatted_posts[$last_i]["comments"], $comment);
          } else {
              array_push($formatted_posts, $post);
              $last_i = count($formatted_posts) - 1;
              $formatted_posts[$last_i]["comments"] = [];
              if ($formatted_posts[$last_i]["comment_content"] !== null) {
                  array_push($formatted_posts[$last_i]["comments"], $comment);
              }
          }
          $previous_post_id = $post["post_id"];
      }
      return $formatted_posts;
  }
