<?php
  function encryptPassword($password) {
    $hash_format = "$2y$10$";
    $salt = "noneofyourbusiness";
    $encrypted = crypt($password, $hash_format.$salt);
    return $encrypted;
  }

  function get_avatar($user) {
    if ($user['avatar']) {
      return $user['avatar'];
    } else {
      return 'https://avatars.dicebear.com/api/initials/'.$user['name'][0].'.svg';
    }
  }
