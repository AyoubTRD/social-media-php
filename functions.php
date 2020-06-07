<?php
  function encryptPassword($password) {
    $hash_format = "$2y$10$";
    $salt = "noneofyourbusiness";
    $encrypted = crypt($password, $hash_format.$salt);
    return $encrypted;
  }
