<?php
include "variables.php";
if (!$is_logged_in) {
  header("Location: $website_base");
}

$name = $user["name"];
$email = $user["email"];
$password = $user["password"];
$id = $user["id"];

$errors = array("name" => "", "email" => "", "password" => "");
$error = "";

$success = "";

if(isset($_POST["delete"])) {
  $connection = mysqli_connect("localhost", "root", "", "helloworld");
  if (!$connection) {
    $error = "Some error occured.";
  } else {
    $query = "DELETE FROM users ";
    $query .= "WHERE id = $id";
    $res = mysqli_query($connection, $query);

    if (!$res) {
      $error = "Some error occured";
    } else {
      setcookie("userid", "", time() - 3600);
      header("Location: $website_base");
    }
  }
}

if (isset($_POST["submit"])) {
  $new_name = $_POST["name"];
  $new_password = $_POST["password"];
  $new_email = $_POST["email"];

  $valid = 1;

  if (!$new_name) {
    $errors["name"] = "The name is required.";
    $valid = 0;
  }
  elseif (strlen($new_name) < 3) {
    $errors["name"] = "The name has to be at least 3 characters.";
    $valid = 0;
  }

  if (!$new_email) {
    $errors["email"] = "The email is required.";
    $valid = 0;
  }

  if (!$new_password) {
    $errors["password"] = "The password is required.";
    $valid = 0;
  }
  elseif (strlen($new_password) < 6) {
    $errors["password"] = "The password has to be at least 6 characters.";
    $valid = 0;
  }

  $name = $new_name;
  $email = $new_email;
  $password = $new_password;

  if ($valid) {
    $connection = mysqli_connect("localhost", "root", "", "helloworld");
    if (!$connection) {
      echo "An error occured while signin you up.";
    } else {
      $name_q = mysqli_real_escape_string($connection, $new_name);
      $email_q = mysqli_real_escape_string($connection, $new_email);
      $password_q = password_hash($new_password, PASSWORD_DEFAULT);
      $query = "UPDATE users ";
      $query .= "SET name = '$name_q', email = '$email_q', password = '$password_q'";
      $query .= "WHERE id = $id";

      $res = mysqli_query($connection, $query);

      if (!$res) {
        $error = "Something went wrong";
      } else {
        $success = "Update success!";
        $query = "SELECT * FROM users WHERE id = $user_id";
        $res = mysqli_query($connection, $query);

        $user = mysqli_fetch_assoc($res);
        if ($user) {
          $is_logged_in = 1;
        } else {
          setcookie("userid", "", time() - 3600);
        }
      }
    }
  }
}

$title = "Account settings";
$active = "profile-settings";
include "header.php";

?>
<form class="ui form auth-form" action="profile-settings.php" method="post">
  <div class="field">
    <label for="name">Name</label>
    <input required type="text" name="name" id="name" value="<?php echo $name; ?>" placeholder="Your name">
    <?php if ($errors["name"]) { ?>
      <div class="ui message visible red">
        <p><?php echo $errors["name"]; ?></p>
      </div>
    <?php } ?>
  </div>
  <div class="field">
    <label for="email">Email</label>
    <input required type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="Email address">
    <?php if ($errors["email"]) { ?>
      <div class="ui message visible red">
        <p><?php echo $errors["email"] ?></p>
      </div>
    <?php } ?>
  </div>
  <div class="field">
    <label for="password">Password</label>
    <input required type="password" name="password" id="password" value="" placeholder="Password">
    <?php if ($errors["password"]) { ?>
      <div class="ui message visible red">
        <p><?php echo $errors["password"] ?></p>
      </div>
    <?php } ?>
  </div>
  <input type="submit" name="submit" class="ui button primary" value="Update">
  <?php if ($error) { ?>
    <div class="ui message yellow">
      <p><?php echo $error; ?></p>
    </div>
  <?php } ?>
  <?php if ($success) { ?>
    <div class="ui message green">
      <p><?php echo $success; ?></p>
    </div>
  <?php } ?>
</form>
<form action="profile-settings.php" method="post">
  <input type="submit" name="delete" value="Delete account" class="ui button red">
</form>

<?php include 'footer.php'; ?>
