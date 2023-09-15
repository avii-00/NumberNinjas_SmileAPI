
<?php
session_start();

if ($_SESSION['loggedin'])
 {
  // Obtain username of logged in user
  $username = $_SESSION['username'];  

  // Obtain current score from JS code
  $score = $_POST['currentScore'];

  // Connect to database
  $conn = mysqli_connect('localhost', 'root', '', 'game');

  // Search whether user exists in score table 
  $query = "SELECT scores FROM score WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) > 0) 
  {
    // If user exists, compare current score with score in database
    $row = mysqli_fetch_assoc($result);
    $scores = $row['scores'];

    if ($score > $scores) 
	  {
      // Update database if current score is greater
      $query = "UPDATE score SET scores = $score WHERE username = '$username'";
      mysqli_query($conn, $query);
    }  
  } 
  else 
  {
    // Insert new row to score table if user doesn't exist
    $query = "INSERT INTO score (username, scores) VALUES ('$username', $score)";
    mysqli_query($conn, $query);
  }

  mysqli_close($conn);


  // Send response to JS code
  if ($score > $scores) 
  {
    echo 'update';
  } 
  else 
  {
    echo 'insert';
  }
}
?>