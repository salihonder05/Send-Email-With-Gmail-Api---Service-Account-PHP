<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;

class MailController extends Controller
{

    public function sendMessage($service, $sender, $msg)
    {
        $service->users_messages->send($sender, $msg);
    }

    public function createMessage($sender, $to, $subject, $messageText)
    {
        $rawMsgStr = "From: <{$sender}>\r\n";
        $rawMsgStr .= "To: <{$to}>\r\n";
        $rawMsgStr .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
        $rawMsgStr .= "MIME-Version: 1.0\r\n";
        $rawMsgStr .= "Content-Type: text/html; charset=utf-8\r\n";
        $rawMsgStr .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $rawMsgStr .= "{$messageText}\r\n";

        $mime = rtrim(strtr(base64_encode($rawMsgStr), '+/', '-_'), '=');
        $msg = new Google_Service_Gmail_Message();
        $msg->setRaw($mime);
        return $msg;
    }

    public function send_email()
    {

        $user_to_impersonate = "your@domain.com";

        $sender = $user_to_impersonate;
        $to = 'testreceiver@gmail.com';
        $subject = 'This is an example for gmail api';
        $messageText = 'All is well. Looks good.';

        $credentialsPath = storage_path('app/credentials.json');
        putenv("GOOGLE_APPLICATION_CREDENTIALS={$credentialsPath}");

        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject($sender);
        $client->setApplicationName("Quickstart");
        $client->setScopes([
            "https://mail.google.com/",
            "https://www.googleapis.com/auth/gmail.compose",
            "https://www.googleapis.com/auth/gmail.modify",
            "https://www.googleapis.com/auth/gmail.send"
        ]);
        $service = new Google_Service_Gmail($client);

        try {
            $msg = $this->createMessage($sender, $to, $subject, $messageText);
            $this->sendMessage($service, $sender, $msg);
            echo "Message sent.";
        } catch (Exception $e) {
            print "An error occurred: " . $e->getMessage();
        }
    }
}
