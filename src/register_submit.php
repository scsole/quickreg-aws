<?php
	function throw_if_null($key, $value){
		if ($value == null){
			echo "<h2>$key is null!</h2>";
			echo "<br>";
			throw new Exception("$key is null!");
		}
	}
	function get_form_field($field){
		$field = trim($field);
		$field = stripslashes($field);
		$field = htmlspecialchars($field);
		return $field;
	}

	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		print_r($_POST);
		$first_name = get_form_field("first_name");
		$first_name = $_POST['first_name'];
		throw_if_null("first_name", $first_name);

		$last_name = get_form_field("last_name");
		$last_name = $_POST['last_name'];
		throw_if_null("last_name", $last_name);

		$gender = $_POST['gender'];
		$gender	= get_form_field("gender");
		throw_if_null("gender", $gender);

		$dob = $_POST['dob'];
		$dob = get_form_field("dob"); 
		throw_if_null("dob", $dob);

		$club = $_POST['club'];
		$club = get_form_field("club");

		$email_address = $_POST['email_address'];
		$email_address = get_form_field("email_address");
		throw_if_null("email_address", $email_address);

		$medical_conditions = $_POST['medical_conditions'];
		$medical_conditions = get_form_field("medical_conditions"); 

		$emergency_contact_name = $_POST['emergency_contact_name'];
		$emergency_contact_name = get_form_field("emergency_contact_name");
		throw_if_null("emergency_contact_name", $emergency_contact_name);

		$emergency_contact_number = $_POST['emergency_contact_number'];
		$emergency_contact_number = get_form_field("emergency_contact_number"); 
		throw_if_null("emergency_contact_number", $emergency_contact_number);

		$db_host   = 'mysql';
		$db_name   = 'quickreg';
		$db_user   = 'webuser';
		$db_passwd = 'insecure_pw';
		$timestamp 	= date('Y-m-d H:i:s');
		try {
		$pdo_dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";
		$conn   	= new PDO($pdo_dsn, $db_user, $db_passwd);
		$sql 		= "INSERT INTO registrations (id, first_name, last_name, gender, dob, club, email_address, medical_conditions, emergency_contact_name, emergency_contact_number, registration_timestamp VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt 		= $conn->prepare($sql);
		$stmt->execute([NULL, $first_name, $last_name, $gender, $dob, $club, $email_address, $medical_conditions, $emergency_contact_name, $emergency_contact_number, $timestamp]);
		echo $conn.lastInsertId();
		} catch (Exception $e){
			$error_msg = $e.getMessage();
			echo "<h1>$error_msg</h1>";
		}
	}	
?>
