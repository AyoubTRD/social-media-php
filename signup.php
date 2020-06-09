<?php
include "variables.php";
include "functions.php";
if ($is_logged_in) {
  header("Location: $website_base");
}

$name = "";
$email = "";
$password = "";
$gender = "";
$birth_date = "2000-01-01";

$errors = array("name" => "", "email" => "", "password" => "", "gender" => "");
$error = "";

if (isset($_POST["submit"])) {

  $name = $_POST["name"];
  $password = $_POST["password"];
  $email = $_POST["email"];
  $gender = $_POST["gender"];
  $birth_date = $_POST["birth_date"];

  $valid = 1;

  if (!$name) {
    $errors["name"] = "The name is required.";
    $valid = 0;
  }
  elseif (strlen($name) < 3) {
    $errors["name"] = "The name has to be at least 3 characters.";
    $valid = 0;
  }

  if (!$email) {
    $errors["email"] = "The email is required.";
    $valid = 0;
  }

  if (!$password) {
    $errors["password"] = "The password is required.";
    $valid = 0;
  }
  elseif (strlen($password) < 6) {
    $errors["password"] = "The password has to be at least 6 characters.";
    $valid = 0;
  }

  if (!$gender) {
    $errors["gender"] = "The gender is required.";
    $valid = 0;
  }
  elseif (!($gender === "male" || $gender === "female")) {
    $errors["gender"] = "The gender has to be either male or female.";
    $valid = 0;
  }

  if ($valid) {
      $name_q = mysqli_real_escape_string($connection, $name);
      $email_q = mysqli_real_escape_string($connection, $email);
      $password_q = password_hash($password, PASSWORD_DEFAULT);
      $query = "INSERT INTO users(name, email, password, gender, birth_date) ";
      $query .= "VALUES ('$name_q', '$email_q', '$password_q', '$gender', '$birth_date')";
      $res = mysqli_query($connection, $query);

      if (!$res) {
        $error = "This email is already taken.";
      } else {
        $query = "SELECT * FROM users WHERE id = ".mysqli_insert_id($connection);
        $res = mysqli_query($connection, $query);
        if (!$res) {
          $error = "An error occured while signing you up. But you can login now!";
        }
        $user = mysqli_fetch_assoc($res);
    }
  }
  if ($user) {
    $_SESSION["userid"] = $user["id"];
    $is_logged_in = 1;
    header("Location: $website_base");
  }
}

$title = "Signup for an account";
$active = "signup";
include "header.php";

?>
<form class="ui form auth-form" action="signup.php" method="post">
  <div class="required field">
    <label for="name">Name</label>
    <input required type="text" name="name" id="name" value="<?php echo $name; ?>" placeholder="Your name">
    <?php if ($errors["name"]) { ?>
      <div class="ui message visible red">
        <p><?php echo $errors["name"]; ?></p>
      </div>
    <?php } ?>
  </div>
  <div class="required field">
    <label for="email">Email</label>
    <input required type="email" name="email" id="email" value="<?php echo $email; ?>" placeholder="Email address">
    <?php if ($errors["email"]) { ?>
      <div class="ui message visible red">
        <p><?php echo $errors["email"] ?></p>
      </div>
    <?php } ?>
  </div>
  <div class="required field">
    <label for="password">Password</label>
    <input required type="password" name="password" id="password" value="<?php echo $password; ?>" placeholder="Password">
    <?php if ($errors["password"]) { ?>
      <div class="ui message visible red">
        <p><?php echo $errors["password"] ?></p>
      </div>
    <?php } ?>
  </div>
  <div class="required field">
    <label for="gender">Gender</label>
    <div class="ui selection dropdown">
      <input type="hidden" name="gender" id="gender" value="<?php echo $gender ?>">
      <i class="dropdown icon"></i>
      <div class="<?php echo $gender ? '' : 'default'; ?> text"><?php echo $gender ? $gender : "Gender"; ?></div>
      <div class="menu">
        <div class="item" data-value="male">Male</div>
        <div class="item" data-value="female">Female</div>
      </div>
    </div>
    <?php if ($errors["gender"]) { ?>
      <div class="ui message visible red">
        <p><?php echo $errors["gender"] ?></p>
      </div>
    <?php } ?>
  </div>
  <div class="field required">
    <label for="birth_date">Birth date</label>
    <input required type="date" name="birth_date" id="birth_date" value="<?php echo $birth_date ?>">
  </div>
  <input type="submit" name="submit" class="ui button primary" value="Register">
  <?php if ($error) { ?>
    <div class="ui message yellow">
      <p><?php echo $error; ?></p>
    </div>
  <?php } ?>
</form>

<?php include 'footer.php'; ?>
