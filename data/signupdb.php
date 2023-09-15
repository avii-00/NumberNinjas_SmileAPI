<?php

require_once 'database.php';

// Define variables 
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST')  // Event trigger happens here
{
	// Check whether username is empty
	if (empty(trim($_POST['username']))) {
		$username_err = "Please enter the username.";
	} else {
		$sql = 'SELECT id FROM users WHERE username = ?';

		if ($stmt = $mysql_database->prepare($sql)) {
			$param_username = trim($_POST['username']);
			$stmt->bind_param('s', $param_username);

			if ($stmt->execute()) {
				$stmt->store_result();

				if ($stmt->num_rows == 1) {
					$username_err = 'This username is already used!';
				} else {
					$username = trim($_POST['username']);
				}
			} else {
				echo "Oops! ${$username}, something went wrong!";
			}

			$stmt->close();
		} else {
			$mysql_database->close();
		}
	}

	// Validating password
	if (empty(trim($_POST["password"]))) {
		$password_err = "Please enter password!";
	} elseif (strlen(trim($_POST["password"])) < 6) {
		$password_err = "Password should consist of at least 6 characters!";
	} else {
		$password = trim($_POST["password"]);
	}

	// Validate confirm password
	if (empty(trim($_POST["confirm_password"]))) {
		$confirm_password_err = "Confirm the password!";
	} else {
		$confirm_password = trim($_POST["confirm_password"]);
		if (empty($password_err) && ($password != $confirm_password)) {
			$confirm_password_err = "Password did not match!";
		}
	}

	// Check before inserting details to database
	if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
		$sql = 'INSERT INTO users (username, password) VALUES (?,?)';

		if ($stmt = $mysql_database->prepare($sql)) {
			$param_username = $username;
			$param_password = password_hash($password, PASSWORD_DEFAULT); // Generate a hash of the password entered
			$stmt->bind_param('ss', $param_username, $param_password);

			if ($stmt->execute()) {
				// Redirects to login page
				header('location: login.php');
			} else {
				echo "Oops! Something went wrong. Try again.";
			}

			$stmt->close();
		}

		$mysql_database->close();
	}
}
