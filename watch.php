<?php
/**
 * Intrusion Detection and Detection SYstem
 *
 */
require 'mailer/PHPMailerAutoload.php';
include_once "classes/notification.php";
include_once "classes/watcher.php";
$dbname = "optisoft_datasecur";
$dbuser = "optisoft_datasecur";
$password= "_%5p376ag$10!63";
$owner = null;

$link = mysqli_connect("localhost", $dbuser, $password, $dbname);



$path = "server/storage/app/str";
$watcher =  new Watcher();
$notifier = new Notification();
$watcher->watchPath($path);

$sender_email = "ping@datasecur@optisoft.ng";
$sender_password = "pingerp00r";

$admins = array("<Pinger>"=> "<phonenumber>", "<email2>" => "<phonenumber>");


$note = function() use ($notifier, $admins, $sender_email, $sender_password, $owner) {
$arguments = func_get_args();
$file = $arguments[0][0];

if ($link) {
    //TODO: filter ofilepath
    $chunk = explode("/", $file);
    $len = count($chunk);
    $path = "{$chunk[$len-2]}/{$chunk[$len-1]}";
    $owner_id = mysql_result(mysql_query($link, "SELECT owner_id FROM documents WHERE path='{$path}' LIMIT 1"),0);


    if($owner_id){
        $result = mysql_query($link, "SELECT id, email, phone, name FROM user WHERE id='{$owner_id}' LIMIT 1");
        $owner = mysql_fetch_assoc($result);
    }

    mysqli_close($link);
}

//lock the files
chmod($file, 0644);
$date = date("d-m-y h:i:s", time());
//send Notification
$body = "Dear Admin,\n there has been and intrusion in the file system. File {$file} has been modified on {$date}.\n
The file permission has been set to 0644 to prevent further modifications. ";
// $notifier->send_sms($admins, $body);

$notifier->Send_Mail($sender_email, $sender_password, $admins, $body);
if ($owner) {
    $notifier->send_sms($owner['phone'], $body);

    $notifier->Send_Mail($sender_email, $sender_password, array( "<{$owner['name']}>"=> $owner['email']), $body);
}

};

$watcher->addListener($note);
$watcher->watch();
