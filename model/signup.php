<?php
	if (!isset($_SESSION))
		session_start();
	require_once("SetDataMethods.php");
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$confirmPassword = $_POST['confirmPassword'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];

	/*
	1) information (not trusted) --> sanitize //strip special chars (including spaces)
	//check if any fields are blank
	2) Check if email exists in database --> Getdatamethods 
	3) Check if username exists in database --> getdatamethods
	4) check if passwords match and is_secure
	5) setdatamethods::createUser() --> userID (new user)
	//intermediate step: email user, send user random access code, they will copy and paste into their 'account' to 'activate' their account
	6) //login --> call from php OR you can return to ajax, call from there
	//-1 --> guest
	//0 --> non-active user
	//1 --> active user --> report users
	//2 --> admin --> promote/demote users to become admins --> request ban (temporary deactivate OR deactivate from certain topics)
	//3 --> super-admin --> 'forever' admins --> we can overwrite admin --> delete/deactivate accounts
	//keep track of terminated accounts --> email ids
	
	*/
	
	if ($username != "" && $password != "" && $email != "" && $confirmPassword !="" && $firstName != "" && $lastName != "") {
		if ($password != $confirmPassword) {
			return false;
		} else {
			//change so that it knows whether email exists or username exists and let the user know
			$db = connectDB::getConnection();
			$stmt = $db->prepare("SELECT COUNT(*) FROM user WHERE email = ? OR username = ?");
			$stmt->bind_param("ss", $email, $username);
			$stmt->bind_result($count);
			$stmt->execute();
			$stmt->fetch();
			$stmt->close();
			$db->close();
			$db->prepare();
			
			if (count > 0) {
				echo 0;
			}
			else {
				$db = connectDB::getConnection();
				$stmt = $db->prepare("INSERT INTO user(email, username, password, firstName, lastName, Role) VALUES (?, ?, ?, ?, ?, 1)");
				$stmt->bind_param("sssss", $email, $username, $password, $firstName, $lastName);
				$stmt->execute();
				$stmt->fetch();
				$stmt->close();
				$db->close();
				$db->prepare();
				
				echo 1;
			}
		}
		
	}
	else {
		if ($username=="") {
			echo -1;
		}
		if ($password == "") {
			echo -2;
		}
		if ($email == "") {
			echo -3;
		}
		if ($confirmPassword == "") {
			echo -4;
		}
		if ($firstName == "") {
			echo -5;
		}
		if ($lastName == "") {
			echo -6;
		}
	}

?>