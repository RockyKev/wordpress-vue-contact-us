<?php

<<<<<<< HEAD
echo "It worked!";


if( isset($_POST['firstName']) && isset($_POST['lastName'])) {
    echo $_POST['firstName'];
    echo $_POST['lastName'];      
 } else {  
    echo 'Data not received';
 }
 
die;
=======
// we need to pull in sendgrid-php api
require_once('sendgrid-php/vendor/autoload.php');
>>>>>>> 14e1379bf5f04dc17562c7318a377497834cffeb

// SO WE NEED TO SUMMON WORDPRESS -- https://stackoverflow.com/a/19327058/4096078
define('WP_USE_THEMES', false); // Don't load theme support functionality
require_once('../../../wp-load.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST)) {

   // get the header data, and decode it to PHP array
   $data = json_decode(file_get_contents("php://input"), true);

   // get wordpress options values
   $config["password"] = get_option('vue_contactus_sendgrid_key');
   $config["fromEmail"] = get_option('vue_contactus_from_email');
   $config["fromName"] = get_option('vue_contactus_from_name');

   send_contactus_email_sendgrid($data, $config);
}

// COMES FROM HERE
// https://github.com/sendgrid/sendgrid-php
function send_contactus_email_sendgrid($data, $config) {

   try {

   // sanitize email content
   $filteredData = filter_var_array ($data, [
      'first name' => FILTER_SANITIZE_STRING,
      'last name' => FILTER_SANITIZE_STRING,
      'email' =>FILTER_VALIDATE_EMAIL,
      'company' => FILTER_SANITIZE_STRING,
      'department' => FILTER_SANITIZE_STRING,
      'subject line' => FILTER_SANITIZE_STRING,
      'messaage' => FILTER_SANITIZE_STRING
   ]);

   // compile email content
   $message = '';
   foreach ($filteredData as $input => $value) {
      if (is_array($value)) {
         $message .= implode(", ", $value);
      } else {
         $message .= "$input : $value <br />";
      }
   }

   $email = new \SendGrid\Mail\Mail();
   $email->setFrom($config["fromEmail"], $config["fromName"]);
   $email->setReplyTo($config["fromEmail"], $config["fromName"]);
   $email->setSubject($data['subject line']);
   $email->addTo($data['email'], $data['first name'] . ' ' . $data['last name']);
   $email->addContent("text/html", $message);

   $sendgrid = new \SendGrid($config["password"]);
   // $sendgrid = new \SendGrid('ERROR CHECKING');

   $response = $sendgrid->send($email);

   // sends to Vue App.
   // If it's 202, it's successful.
   print $response->statusCode();

} catch (Exception $e) {
      echo 'Caught exception: ' . $e->getMessage() . "\n";
   }

}
