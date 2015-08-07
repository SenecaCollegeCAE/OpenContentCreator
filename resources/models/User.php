<?php
	class User {
		private $_userId;
		private $_username;
		private $_password;
		private $_email;
		
		public function getUserFromServer($username, $password) {
			require_once("./resources/connect.inc.php"); //call the database

			$result = $dbh->prepare("SELECT * FROM users WHERE username = :username");
			$result->execute(array('username' => $username));
			$resultNum = $result->rowCount();
			$dbh = null;
			
			if($resultNum) {
				while($userRow = $result->fetch(PDO::FETCH_ASSOC))
				{
					$this->_userId = $userRow['userid'];
					$this->_username = $userRow['username'];
					$this->_email = $userRow['email'];
					$this->_password = $userRow['password'];
				}
				
				//Database validation to check the crypt password and if username matches
				if((crypt($password, $this->_password) == $this->_password) && ($username == $this->_username))
					return true;
				else 
					return false;
			}
			else
				return false;
		} //function getUserFromServer()
		
		public function getEmailFromServer($email) {
			
			//get the user email so they can reset their forgotten password
			$this->_email = $email;
			require_once("../../resources/connect.inc.php");
			
			$result = $dbh->prepare("SELECT username FROM users WHERE email = :email");
			$result->execute(array('email' => $this->_email));
			$resultNum = $result->rowCount();
			
			if($resultNum) {				
				while($userRow = $result->fetch(PDO::FETCH_ASSOC)) {
					$this->_username = $userRow['username'];
				}
				
				//makes a random password for the user and emails it to them
				$pw = str_shuffle('abcefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ234567890');
				$pw = substr($pw, 0, 8);
				
				//encrypt the password onto the server
				$salt = uniqid(mt_rand(), true); //Generates random salt
				$this->_password = crypt($pw, $salt); //hashed password
				
				$updateResult = $dbh->prepare("UPDATE users SET password = :password WHERE email = :email");
				$updateResult->execute(array(
						'password' => $this->_password,
						'email' => $this->_email	
				));
				
				$dbh = null;
				
				return $pw;
				
				//Send email, this will give a warning if still using on localhost. No problem when uploaded online
				$to = $this->_email;
				$subject = "Open Content Creator Reset Info";
				$message = "Please do not reply to this email. \n\nYour user name is: " . $this->_username . "\n\nYour password is: " . $this->_password . "\n\nYou can login at http://open2.senecac.on.ca/occ/index.php to change the password.";
				$headers = "From: admin-occ@myseneca2.ca";
				
				if(mail($to, $subject, $message, $headers))
					return "success";
				else {
					return "newPasswordWithoutEmailSent";
				}
			}
			else { //email does not exist in database
				$dbh = null;
				return false;
			}
		} //function getEmailFromServer($email)
		
		public function changePasswordWithNewPassword($userId, $username, $password) {
			//encrypt the password onto the server
			$salt = uniqid(mt_rand(), true); //generates a random salt
			$hashpass = crypt($password, $salt);

			require_once("../../../resources/connect.inc.php");
			
			//Update the database with new password for THAT user
			$updateResult = $dbh->prepare("UPDATE users SET password = :hashpass WHERE userid = :userid AND username = :username");
			$updateResult->execute(array('hashpass' => $hashpass, 'userid' => $userId, 'username' => $username));
			$dbh = null;
						
		} //function changePasswordWithNewPassword()
		
		public function registerUserToServer($username, $password, $email) {
			$salt = uniqid(mt_rand(), true); //generates a random salt
			$hashPass = crypt($password, $salt);
			
			require_once("../../resources/connect.inc.php");
			
			//Check if there is a username duplicate first before inserting a new one
			$result = $dbh->prepare("SELECT username FROM users WHERE username = :username");
			$result->execute(array('username' => $username));
			
			$result2 = $dbh->prepare("SELECT email FROM users WHERE email = :email");
			$result2->execute(array('email' => $email));
			
			$usernameDuplicate = $result->rowCount();
			$emailDuplicate = $result2->rowCount();
			
			if(!$usernameDuplicate && !$emailDuplicate) {
				$this->_userId = null;
				$this->_username = $username;
				$this->_password = $hashPass;
				$this->_email = $email;
				
				$insert = $dbh->prepare("INSERT INTO users
						VALUES (:id, :username, :password, :email)");
				$insert->execute(array(
					'id' => $this->_userId,
					'username' => $this->_username,
					'password' => $this->_password,
					'email' => $this->_email
				));
				
				$dbh = null;
				
				//make upload images folder for the user
				if(!file_exists("../../public/img/users/" . $this->_username)) {
			    	mkdir("../../public/img/users/" . $this->_username, 0777, true);
			    }
			    else {
			    	$msg = "The following user: " . $this->_username . " tried to register but there is a duplicate folder with that name for some reason.";
			    	mail("admin-occ@myseneca2.ca", "There is a duplicate folder in the upload", $msg, "From: admin-occ@myseneca2.ca");
			    	die ("There is something wrong with the system. An email notification has been sent to the administrator.");
			    }
				
				//Send email, this will give a warning if still using on localhost. No problem when uploaded online
				$to = $email;
				$subject = "Open Content Creator Login Information";
				$message = "Please do not reply to this email. \n\nYour user name is: " . $this->_username . "\n\nYour password is: " . $this->_password . "\n\nYou can login at http://open2.senecac.on.ca/occ/index.php.";
				$headers = "From: admin-occ@myseneca2.ca";
				
				if(mail($to, $subject, $message, $headers))
					return "success";
				else {
					return "registeredWithoutEmailSent";
				}
			}
			else {
				$dbh = null;
				if($usernameDuplicate)
					return "duplicateUsername";
				else if($emailDuplicate)
					return "duplicateEmail";
			}
		} //function registerUserToServer()
		
		public function getUserInfoFromSession() {
			$user = [];
			array_push($user, $this->_userId);
			array_push($user, $this->_username);
			array_push($user, $this->_email);
			array_push($user, $this->_password);
			return $user;
		} //function getUserInfoFromSession()
		
		public function resetInfoAfterLoggingOut() {
			$this->_userId = "";
			$this->_username = "";
			$this->_email = "";
			$this->_password = "";
		} //function restInfoAfterLoggingOut()
		
	}//Class User
?>