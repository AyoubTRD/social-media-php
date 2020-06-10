<?php
  include_once "variables.php";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.4.6/tailwind.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
    <link rel="stylesheet" href="<?php echo $website_base.'/assets/css/main.css'; ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
  </head>
  <body style="background-color: #fcfcfc">
    <header class="ui primary menu pointing" style="border-radius: 0; margin-bottom: 0">
      <div class="ui container">
        <a href="<?php echo $website_base; ?>" class="item <?php echo $active === 'home' ? 'active' : '' ?> ">
          <i class="home icon"></i>
          <span class="hide-on-mobile">Home</span>
        </a>
        <?php if ($is_logged_in) { ?>
          <form class="item" action="<?php echo $website_base ?>/search.php" method="get" style="flex: 4; min-width: 0">
            <div class="ui icon input">
              <i class="search icon"></i>
              <input type="text" name="search_query" placeholder="search..." value="" style="border: none;">
            </div>
          </form>
        <?php } ?>
        <div class="right menu">
          <?php if (!$is_logged_in) { ?>
            <a href="<?php echo $website_base ?>/signup.php" class="item <?php echo $active === 'signup' ? 'active' : '' ?>">Signup</a>
            <a href="<?php echo $website_base ?>/login.php" class="item <?php echo $active === 'login' ? 'active' : '' ?>">Login</a>
        <?php } else { ?>
          <div class="item ui dropdown">
            <div class="text hide-on-mobile">Account</div>
            <i class="dropdown icon hide-on-mobile"></i>
            <i class="user icon show-on-mobile"></i>
            <div class="menu">
              <a href="<?php echo $website_base."/users/profile.php?user_id=".$user['id'] ?>" class="item">
                <i class="icon user"></i>
                Profile
              </a>
              <a href="<?php echo $website_base ?>/profile-settings.php" class="item">
                <i class="icon cog"></i>
                Settings
              </a>
            </div>
          </div>
          <a href="<?php echo $website_base ?>/logout.php" class="item">
            <i class="icon sign-out"></i>
            <span class="hide-on-mobile">Logout</span>
          </a>
        <?php } ?>
        </div>
      </div>
    </header>
    <?php if (!isset($no_container)) { ?>
      <div class="ui container <?php echo isset($container_classes) ? $container_classes : '' ?>">
    <?php } ?>
