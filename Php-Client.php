<?php
require_once('../../vendor/autoload.php');

// Some user within your Google Workspace domain
$user_to_impersonate = "your@domain.com";

$sender = $user_to_impersonate;
$to = 'another@domain.com';
$subject = 'Email Subject';
$messageText = 'E mail body content.';

// The path to your service account credentials goes here.
putenv("GOOGLE_APPLICATION_CREDENTIALS=credentials.json");
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setSubject($sender);
$client->setApplicationName("Quickstart");
$client->setScopes(["https://mail.google.com/",
                    "https://www.googleapis.com/auth/gmail.compose",
                    "https://www.googleapis.com/auth/gmail.modify",
                    "https://www.googleapis.com/auth/gmail.send"]);
$service = new Google_Service_Gmail($client);

// Main Process
try {
  $msg = createMessage($sender, $to, $subject, $messageText);
  sendMessage($service, $sender, $msg);
} catch (Exception $e) {
  print "An error occurred: " . $e->getMessage();
}

function sendMessage($service, $sender, $msg) {
  $service->users_messages->send($sender, $msg);
}

function createMessage($sender, $to, $subject, $messageText) {
  $rawMsgStr = "From: <{$sender}>\r\n";
  $rawMsgStr .= "To: <{$to}>\r\n";
  $rawMsgStr .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
  $rawMsgStr .= "MIME-Version: 1.0\r\n";
  $rawMsgStr .= "Content-Type: text/html; charset=utf-8\r\n";
  $rawMsgStr .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
  $rawMsgStr .= "{$messageText}\r\n";

  // The message needs to be encoded in Base64URL
  $mime = rtrim(strtr(base64_encode($rawMsgStr), '+/', '-_'), '=');
  $msg = new Google_Service_Gmail_Message();
  $msg->setRaw($mime);
  return $msg;
}
 ?>