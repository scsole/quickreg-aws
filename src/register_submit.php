<?php
	function get_form_field($field) {
		if (empty($_POST[$field])){
			return null;
		}
		$field = trim($field);
		$field = stripslashes($field);
		$field = htmlspecialchars($field);
		return $_POST[$field];
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$first_name 				= get_form_field("first_name");
		$last_name 					= get_form_field("last_name");
		$gender 					= get_form_field("gender");
		$dob 						= get_form_field("dob"); 
		$club 						= get_form_field("club");
		$email_address 				= get_form_field("email_address");
		$medical_conditions 		= get_form_field("medical_conditions"); 
		$emergency_contact_name 	= get_form_field("emergency_contact_name");
		$emergency_contact_number 	= get_form_field("emergency_contact_number"); 
		$registration_timestamp = "";
		$db_host   = 'mysql';
		$db_name   = 'quickreg';
		$db_user   = 'webuser';
		$db_passwd = 'insecure_pw';
		try {
		$pdo_dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
		}  catch(\PDOException $e) {
			throw new \PDOException($e->getMessage(); (int)$e->getCode());
		}
		$conn   	= new PDO($pdo_dsn, $db_user, $db_passwd);
		$timestamp 	= date('Y-m-d H:i:s');
		$sql 		= "INSERT INTO registrations (first_name, last_name, gender, dob, club, email_address, medical_conditions, emergency_contact_name, emergency_contact_number, registration_timestamp VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt 		= $pdo->prepare($sql);
		$stmt->execute([NULL, $first_name, $last_name, $gender, $dob, $club, $email_address, $medical_conditions, $emergency_contact_name, $emergency_contact_number, $timestamp);

	}
?>
