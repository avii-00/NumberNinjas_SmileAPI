<?php require_once "../../application/logindb.php" ?>

<!DOCTYPE html>
<html>

<head>
  <title>Login Form</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>

<body>
  <div class="container">
    <div class="left-side">
      <img src="../../public/images/symbol1.png" alt="Logo">
      <h2>Number Ninjas</h2>
    </div>
    <div class="right-side">
      <h1 class="display-4 pt-3">LOGIN</h1> <br><br>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <div class="form-group <?php (!empty($username_err)) ? 'has_error' : ''; ?>">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" class="form-control" value="<?php echo $username ?>">
          <span class="help-block"><?php echo $username_err; ?></span>
        </div>

        <div class="form-group <?php (!empty($password_err)) ? 'has_error' : ''; ?>">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" class="form-control" value="<?php echo $password ?>">
          <span class="help-block"><?php echo $password_err; ?></span>
        </div>

        <div class="button-container">
          <input type="submit" class="btn btn-outline-primary" value="login">
        </div>
        <p>Don't have an account? <a href="signup.php">Sign in</a></p>
      </form>
    </div>
  </div>

</body>

</html>