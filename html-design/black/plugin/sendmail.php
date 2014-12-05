<?php
//        Who you want to recieve the emails from the form. (Hint: generally you.)
$sendto = 'demdouss@mail.ru';

//        The subject you'll see in your inbox
$subject = 'Message from yoursite contact';

//        Message for the user when he/she doesn't fill in the form correctly.
$errormessage = 'Oops! There seems to have been a problem. May we suggest...';

//        Message for the user when he/she fills in the form correctly.
$thanks = "Your message was sent";


//        Message for the bot when it fills in in at all.
$honeypot = "You filled in the honeypot! If you're human, try again!";

//        Various messages displayed when the fields are empty.
$emptyname =  'Enter your name?';
$emptyemail = 'Enter your email address?';
$emptytele = 'Enter subject name?';
$emptymessage = 'Enter a message?';

//       Various messages displayed when the fields are incorrectly formatted.
$alertname =  'Enter your name using only the standard alphabet?';
$alertemail = 'Enter your email in this format: <i>name@example.com</i>?';
$alerttele = 'Enter subject using only the standard alphabet?';
$alertmessage = "Making sure you aren't using any parenthesis or other escaping characters in the message? Most URLS are fine though!";
define('_msg_invalid_data_name','Please enter your name.');
// --------------------------- Thats it! don't mess with below unless you are really smart! ---------------------------------

//Setting used variables.
$alert = '';
$pass = 0;

function createResponse($msg)
		{
			echo json_encode($msg);
			exit;
		}


// Sanitizing the data, kind of done via error messages first. Twice is better!
function clean_var($variable) {
    $variable = strip_tags(stripslashes(trim(rtrim($variable))));
  return $variable;
}

//The first if for honeypot.
if ( empty($_REQUEST['last']) ) {

	// A bunch of if's for all the fields and the error messages.
	if ( empty($_REQUEST['yourname']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptyname . "</li>";
		$response['info'][]=array('fieldId'=>'yourname','message'=>_msg_invalid_data_name);
		
	} elseif ( preg_match( "/[][{}()*+?.\\^$|]/", $_REQUEST['yourname'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertname . "</li>";
	}
	if ( empty($_REQUEST['email']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptyemail . "</li>";
	} elseif ( !preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/i", $_REQUEST['email']) ) {
		$pass = 1;
		$alert .= "<li>" . $alertemail . "</li>";
	}
	if ( empty($_REQUEST['tele']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptytele . "</li>";
	} elseif ( preg_match( "/[][{}()*+?.\\^$|]/", $_REQUEST['tele'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alerttele . "</li>";
	}
	if ( empty($_REQUEST['message']) ) {
		$pass = 1;
		$alert .= "<li>" . $emptymessage . "</li>";
	} elseif ( preg_match( "/[][{}()*+?\\^$|]/", $_REQUEST['message'] ) ) {
		$pass = 1;
		$alert .= "<li>" . $alertmessage . "</li>";
	}

	//If the user err'd, print the error messages.
	if ( $pass==1 ) {

		//This first line is for ajax/javascript, comment it or delete it if this isn't your cup o' tea.
	echo "<script>$(\".message\").hide(\"slow\").show(\"slow\"); </script>";
	echo "<ul>";
	echo $alert;
	echo "</ul>";

	// If the user didn't err and there is in fact a message, time to email it.
	} elseif (isset($_REQUEST['message'])) {
	    
		//Construct the message.
	    $message = "From: " . clean_var($_REQUEST['yourname']) . "\n";
		$message .= "Email: " . clean_var($_REQUEST['email']) . "\n";
	    $message .= "Subject: " . clean_var($_REQUEST['tele']) . "\n";
	    $message .= "Message: \n" . clean_var($_REQUEST['message']);
	    $header = 'From:'. clean_var($_REQUEST['email']);

//This is for javascript, 
		echo "<script>$(\".message\").hide(\"slow\").show(\"slow\").animate({opacity: 1.0}, 4000).hide(\"slow\"); $(':input').clearForm() </script>";
		echo "Your message was sent";	    
//Mail the message - for production
		mail($sendto, $subject, $message, $header);


		die();

//Echo the email message - for development
		//echo "<br/><br/>" . $message;

	}
	
//If honeypot is filled, trigger the message that bot likely won't see.
} else {
	echo "<script>$(\".message\").hide(\"slow\").show(\"slow\"); </script>";
	echo $honeypot;
}
?>
