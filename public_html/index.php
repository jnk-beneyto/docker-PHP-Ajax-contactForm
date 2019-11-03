<?php
//using phpmailer library
require 'phpmailer/PHPMailerAutoload.php';
require 'globals.php';


function sendMail($msg, $name, $mail)
{

  $the_subject = "sent from My web";
  $address_to = MY_EMAIL;
  $from_name = "My Web";
  $phpmailer = new PHPMailer();

  // ----------  Gmail data account -------------------------------
  $phpmailer->Username = MY_EMAIL;
  $phpmailer->Password = MY_PASSWORD;
  //---------------------------------------------------------------

  $phpmailer->SMTPSecure = 'ssl';
  $phpmailer->Host = "smtp.gmail.com";
  $phpmailer->Port = 465;
  $phpmailer->IsSMTP();
  $phpmailer->SMTPAuth = true;
  $phpmailer->setFrom($phpmailer->Username, $from_name);
  $phpmailer->AddAddress($address_to); //recipients email
  $phpmailer->Subject = $the_subject;
  $phpmailer->Body .= "<h3 style='color:#187FE6;'>New query: </h3>";
  $phpmailer->Body .= '<p> Name: ' . $name . '</p>';
  $phpmailer->Body .= '<p> Email: ' . $mail . '</p>';
  $phpmailer->Body .= '<p> Message: ' . $msg . '</p>';
  $phpmailer->Body .= "<p>Date: " . date("d-m-Y h:i:s") . "</p>";
  $phpmailer->IsHTML(true);
  $phpmailer->Send();
}

if ($_POST['name'] != "" && $_POST['email'] != "" && $_POST['msg'] != "") {

  //sanitizing data
  $name = strip_tags(trim($_POST['name']));
  $msg = strip_tags($_POST['msg']);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

  //message to form
  echo "Message sent successfully!";

  sendMail($msg, $name, $email);
  exit;
}

require('form.html');
