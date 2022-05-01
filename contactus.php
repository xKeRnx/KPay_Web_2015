<?php
    $from = 'Youplay Contact Form';
    $to = '<your email here>';
    $subject = 'Message from Youplay contact form';
    
    function errorHandler($message) {
        header('HTTP/1.1 500 Internal Server Error');
        die($message);
    }

    // remove it if yor php fincally configured
    die('This is demo message from PHP');

    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']  == 'XMLHttpRequest') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $body = "From: $name\n E-Mail: $email\n Message:\n $message";

        $pattern  = '/[\r\n]|Content-Type:|Bcc:|Cc:/i';
        if (preg_match($pattern, $name) || preg_match($pattern, $email) || preg_match($pattern, $message)) {
            errorHandler('Header injection detected');
        }
 
        // Check if name has been entered
        if (!$_POST['name']) {
            errorHandler('Please enter your name');
        }
        
        // Check if email has been entered and is valid
        if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            errorHandler('Please enter a valid email address');
        }
        
        //Check if message has been entered
        if (!$_POST['message']) {
            errorHandler('Please enter your message');
        }

        $headers  = 'MIME-Version: 1.1' . PHP_EOL;
        $headers .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;
        $headers .= "From: $name <$email>" . PHP_EOL;
        $headers .= "Return-Path: $to" . PHP_EOL;
        $headers .= "Reply-To: $email" . PHP_EOL;
        $headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
 
        // If there are no errors, send the email
        if (mail($to, $subject, $body, $headers)) {
            die('Thank You! I will be in touch');
        } else {
            errorHandler('Sorry there was an error sending your message. Please try again later');
        }
    } else {
        errorHandler('Allower only XMLHttpRequest');
    }
?>