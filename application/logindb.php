
<?php
  
  session_start();

  // Redirect to menu page if user has already login

  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
  {
    header("location: menu.php");
    exit;
  }

  // Include database configuration file
  require_once "../../data/database.php";

  // Define variables, initialize with empty values
  $username = $password = '';
  $username_err = $password_err = '';

  // Process submitted form data
  if ($_SERVER['REQUEST_METHOD'] === 'POST')  // Event trigger happens here
  {
    // Check whether username is empty
    if(empty(trim($_POST['username'])))
    {
      $username_err = 'Please enter your username!';
    } 
    else
    {
      $username = trim($_POST['username']);
    }

    // Check whether password is empty
    if(empty(trim($_POST['password'])))
    {
      $password_err = 'Please enter your password!';
    } 
    else
    {
      $password = trim($_POST['password']);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) 
    {
      // Retrieve data from database
      $sql = 'SELECT id, username, password FROM users WHERE username = ?';

      if ($stmt = $mysql_database->prepare($sql)) 
      {

        // Set param
        $param_username = $username;

        // Bind param to statement
        $stmt->bind_param('s', $param_username);

        // Attempt to execute
        if ($stmt->execute())
        {

          // Store result
          $stmt->store_result();

          // If username already exists, verify it
          if ($stmt->num_rows == 1) 
          {
            // Bind result into variables
            $stmt->bind_result($id, $username, $hashed_password);

            if ($stmt->fetch()) 
            {
              if (password_verify($password, $hashed_password)) 
              {

                // Start new session
                session_start();

                // Store data in sessions
                $_SESSION['loggedin'] = true;
                $_SESSION['id'] = $id;
                $_SESSION['username'] = $username;

                // Redirect user to menu page
                header('location: menu.php');
              } 
              else
              {
                $password_err = 'Please enter correct password!';
              }
            }
          } 
          else 
          {
            $username_err = "Username does not exists!";
          }
        } 
        else 
        {
          echo "Oops! Something went wrong please try again..";
        }


        // Close statement
        $stmt->close();
      }

      
      // Close connection
      $mysql_database->close();
    }
  }
?>