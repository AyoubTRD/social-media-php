<?php
  include "variables.php";
  $page_title = $website_name;
  $active = isset($active) ? $active : "";

  if (isset($title)) {
    $page_title .= " | ".$title;
  }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <style>
      .auth-form {
        width: 420px;
        margin: 25px auto;
      }
    </style>
  </head>
  <body>
    <header class="ui primary menu pointing" style="border-radius: 0; margin-bottom: 0">
      <div class="ui container">
        <a href="index.php" class="item <?php echo $active === 'home' ? 'active' : '' ?>">Home</a>
        <div class="right menu">
          <?php if (!$is_logged_in) {
          ?>
            <a href="signup.php" class="item <?php echo $active === 'signup' ? 'active' : '' ?>">Signup</a>
            <a href="login.php" class="item <?php echo $active === 'login' ? 'active' : '' ?>">Login</a>
        <?php } else { ?>
          <div class="item ui dropdown">
            <div class="text">Account</div>
            <i class="dropdown icon"></i>
            <div class="menu">
              <a href="profile.php" class="item">
                <i class="icon user"></i>
                Profile
              </a>
              <a href="profile-settings.php" class="item">
                <i class="icon cog"></i>
                Settings
              </a>
            </div>
          </div>
          <a href="logout.php" class="item">
            <i class="icon sign-out"></i>
            Logout
          </a>
        <?php } ?>
        </div>
      </div>
    </header>
    <?php if (!isset($no_container)) {
      echo '<div class="ui container">';
    }
    ?>
