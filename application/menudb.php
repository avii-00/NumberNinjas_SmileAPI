<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true)
{
  header("location: login.php");
  exit;
}

//  Get logged in user's name
$loggedInUserName = $_SESSION['username'];

if (isset($_POST['logout'])) 
{
  // Unset session variables and destroy session
  session_unset();
  session_destroy();

  // Redirect to login page
  header("location: login.php");
  exit;
}

?>