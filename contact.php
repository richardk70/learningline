<?php

// require ReCaptcha class
require('recaptcha-master/src/autoload.php');

// an email address that will be in the From field of the email.
$from = 'Website contact form <info@learningline.org>';

// an email address that will receive the email with the output of the form
$sendTo = 'Robin <robink70@gmail.com>';

// subject of the email
$subject = 'Message from website contact form!';

// form field names and their translations.
// array variable name => Text to appear in the email
$fields = array('first' => 'Name', 'last' => 'Last', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message'); 

// message that will be displayed when everything is OK :)
// $okMessage = 'Contact form successfully submitted. Thank you, we will get back to you soon!';
$okMessage = header("Location: success.html");

// If something goes wrong, we will display this message.
// $errorMessage = 'There was an error while submitting the form. Please try again later';
$errorMessage = header("Location: error.html");

// ReCaptch Secret
$recaptchaSecret = '6LcjvaQUAAAAAOXFNXf1ZHA1nzgRflQTAaVjIYvW';

// if you are not debugging and don't need error reporting, turn this off by error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);


    if (!empty($_POST)) {

        // validate the ReCaptcha, if something is wrong, we throw an Exception,
        // i.e. code stops executing and goes to catch() block
        
        if (!isset($_POST['g-recaptcha-response'])) {
            throw new \Exception('ReCaptcha is not set.');
        }

        // do not forget to enter your secret key from https://www.google.com/recaptcha/admin
        
        $recaptcha = new \ReCaptcha\ReCaptcha($recaptchaSecret, new \ReCaptcha\RequestMethod\CurlPost());
        
        // we validate the ReCaptcha field together with the user's IP address
        
        $response = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        if (!$response->isSuccess()) {
            throw new \Exception('ReCaptcha was not validated.');
        }
            
    $emailText = "You have a new message from your contact form\n=============================\n";

    foreach ($_POST as $key => $value) {
        // If the field exists in the $fields array, include it in the email 
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    // All the neccessary headers for the email.
    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email
    if (mail('richardk70@gmail.com', $subject, $emailText, implode("\n", $headers))) {
        header("Location: http://www.richardkeightley.com/testing/success.html");
    } else {
        header("Location: http://www.richardkeightley.com/testing/error.html");
    }

    // $responseArray = array('type' => 'success', 'message' => $okMessage);
}



// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
// else just display the message
else {
    echo $responseArray['message'];
}