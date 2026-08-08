<?php
session_start();
$error = false;

// $name=$_REQUEST['name']; 
// $email=$_REQUEST['email']; 
// $user_message=$_REQUEST['user_message']; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $email = test_input($_POST["email"]);
  $user_message = test_input($_POST["user_message"]);
  $honeypot = test_input($_POST["honeypot"]);
  //$colorcheck = test_input($_POST["colorcheck"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$attempted = true;

if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
	$error = true;
	$_SESSION['error'] = "name";
	$_SESSION['comments'] = "Only letters and white space allowed in the name.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$error = true;
	$_SESSION['error'] = "email";
	$_SESSION['comments'] = "Invalid email format.";
}

if ($honeypot != "")
{
	$error = true;
}

// if (($colorcheck != "green") && ($colorcheck != "Green") && ($colorcheck != "GREEN"))
// {
// 	$error = true;
// 	$_SESSION['error'] = "colorcheck";
// 	$_SESSION['comments'] = "What color is the box?";
// }

$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['user_message'] = $user_message;
$_SESSION['attempted'] = true;
$_SESSION['email_sent'] = false;
//$_SESSION['colorcheck'] = $colorcheck;


if (($name=="")||($email=="")||($user_message=="")) 
        { 
        	$error = true;
        	if ($user_message == "")
        	{
        		$_SESSION['error'] = "message";
        		$_SESSION['comments'] = "Please include a message.";
        	}
        	if ($email == "")
        	{
        		$_SESSION['error'] = "email";
        		$_SESSION['comments'] = "Please include your email.";
        	}
			if ($name=="")
			{
				$_SESSION['error'] = "name";
				$_SESSION['comments'] = "Please include your name.";
			}        	

        } 
    else{  

    	    if (!$error)
    	    {
	    		$_SESSION['email_sent'] = true;
				$_SESSION['comments'] = "Thank you! <br>We will contact you shortly.";       
				$from="From: michael@michaellawrenceart.com"; 
				$to      = 'michael@michaellawrenceart.com';  
				$subject = 'response from the Michael Lawrence Art website';

				$message_content = "Hi Michael,<br><br>You have gotten an inquiry from your website.<br>";


				$message_content .= "Here is the information:<br>";
				$message_content .= "Name:  " . $name . "<br>";
				$message_content .= "email: " .$email . "<br>";
				$message_content .= "<br>-------Their message----------------------------<br>";
				$message_content .= $user_message;
				$message_content .= "<br>------------------------------------------------<br>";

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From: michael@michaellawrenceart.com' . "\r\n" .'Reply-To: michael@michaellawrenceart.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();


				mail($to, $subject, $message_content, $headers);
			}
			

        } 

        header("Location: ../contact.php"); /* Redirect browser */


?>

