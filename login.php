<?php
include "variables.php";
if ($is_logged_in) {
  header("Location: $website_base");
}

$email = "";
$password = "";

$errors = array("email" => "", "password" => "");
$error = "";

if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $password = $_POST["password"];
  $valid = 1;

  if (!$email) {
    $errors["email"] = "The email is required.";
    $valid = 0;
  }
  if (!$password) {
    $errors["password"] = "The password is required.";
    $valid = 0;
  }

  if ($valid) {
    $connection = mysqli_connect("localhost", "root", "", "helloworld");
    if (!$connection) {
      echo "An error occured while logging you in.";
    } else {
      $email_q = mysqli_real_escape_string($connection, $email);
      $query = "SELECT * FROM users WHERE email = '$email_q'";

      $res = mysqli_query($connection, $query);

      if (!$res) {
        echo "An error occured while logging you in.";
      } else {
        $user_found = 0;
        while ($row = mysqli_fetch_assoc($res)) {
          $user_found = 1;
          $match = password_verify($password, $row["password"]);
          if (!$match) {
            $error = "The password and email don't match.";
          } else {
            $user = $row;
            break;
          }
        }
        if (!$user_found) {
          $error = "No user found with the email specified.";
        }
      }
    }
  }
  if ($user) {
    $_SESSION["userid"] = $user["id"];
    $is_logged_in = 1;
    header("Location: $website_base");
  }

}

  $title = "Login to your account";
  $active = "login";

  include 'header.php';
?>

<form class="auth-form ui form" action="login.php" method="post">
  <div class="field">
    <label for="email">Email address</label>
    <input required type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email address">
    <?php if ($errors["email"]) { ?>
      <div class="ui message red visible">
        <p><?php echo $errors["email"]; ?></p>
      </div>
    <?php } ?>
  </div>
  <div class="field">
    <label for="password">Password</label>
    <input required type="password" id="password" name="password" value="<?php echo $password; ?>" placeholder="Password">
    <?php if ($errors["password"]) { ?>
      <div class="ui message red visible">
        <p><?php echo $errors["password"]; ?></p>
      </div>
    <?php } ?>
  </div>
  <input type="submit" name="submit" class="ui button primary" value="Login">
  <?php if ($error) { ?>
    <div class="ui message yellow floating">
      <p><?php echo $error; ?></p>
    </div>
  <?php } ?>
</form>

<?php include "footer.php" ?>
