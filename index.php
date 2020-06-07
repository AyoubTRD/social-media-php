<?php
  $title = "Home";
  $no_container = 1;
  $active = "home";
  include "header.php";
?>

<?php if (!$is_logged_in) { ?>
  <style>
    .welcome {
      height: 80vh;
      background: linear-gradient(rgba(32, 32, 32, 0.85), rgba(32, 32, 32, 0.85)), url("https://images.unsplash.com/photo-1470770841072-f978cf4d019e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1350&q=80");
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 5vw;
    }
    .welcome h1 {
      color: white;
      font-size: 65px;
    }
    @media all and (max-width: 700px) {
      .welcome h1 {
        font-size: 40px;
      }
    }
  </style>
  <div class="welcome">
    <div class="hero">
      <h1>Welcome! Start by creating an account.</h1>
      <a href="signup.php" class="ui button primary large">Create account</a>
      <a href="login.php" class="ui button grey large">Login</a>
    </div>
  </div>
<?php } else { ?>
  <div class="ui container">
    <h1>Hello <?php echo $user["name"]; ?></h1>
  </div>
<?php } ?>

<?php include "footer.php"; ?>
