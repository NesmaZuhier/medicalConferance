<?php
/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * This uses traditional id & password authentication - look at the gmail_xoauth.phps
 * example to see how to use XOAUTH2.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */
//Import PHPMailer classes into the global namespace

use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';

$msg = '';
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
// $mail->SMTPDebug = 2;
//Set the hostname of the mail server
$mail->Host = 'sg2plcpnl0008.prod.sin2.secureserver.net';
// use
// $mail->Host = 'relay-hosting.secureserver.net';
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = tsl;//ssl
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "imc@imcgaza.com";
//Password to use for SMTP authentication
$mail->Password = "imcgaza2018";
//Set who the message is to be sent from
$mail->setFrom('imc@imcgaza.com', 'IMC');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@gmail.com', 'Nesma Sadeq');
//Set who the message is to be sent to
 $mail->addAddress('massry_alaa@yahoo.com', 'Alaa Al-Masry');
//$mail->addAddress('nesmazuhier@gmail.com', 'Nesma');
$mail->AddCC('imcgaza.imc@gmail.com', 'Medical conference');
$mail->AddCC('maha.alfaqawi@gmail.com', 'Medical conference');
$mail->AddCC('elfarrareem@gmail.com', 'Medical conference');
$mail->AddCC('dr.m.khateeb91@gmail.com', 'Medical conference');
$mail->AddCC('tamerabedalghafoor@hotmail.com', 'Medical conference');
//Set the subject line
$mail->Subject = 'Submission from '. $_POST['fname'].' '. $_POST['lname']." about ".$_POST['article-title'];
//Read an HTML message body from an external file, convert referenced images to embedded,
$mail->isHTML(true);
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('email_content.html'), __DIR__);
//Replace the plain text body with one created manually
$mail->Body = '<p><b>Frist name: </b>' . $_POST['fname'].'</p>'.
'<p><b>Last Name: </b>' . $_POST['lname'].'</p>'.
'<p><b>Birth Date: </b>' . $_POST['birth'].'</p>'.
'<p><b>Gender: </b>' . $_POST['gender'].'</p>'.
'<p><b>Highest Education Degree: </b>' . $_POST['HED'].'</p>'.
'<p><b>Year: </b>' . $_POST['year'].'</p>'.
'<p><b>Speciality: </b>' . $_POST['speciality'].'</p>'.
'<p><b>Current Job: </b>' . $_POST['job'].'</p>'.
'<p><b>place: </b>' . $_POST['place'].'</p>'.
'<p><b>Email: </b>' . $_POST['email'].'</p>'.
'<p><b>mobile: </b>' . $_POST['phone_no'].'</p>'.
'<p><b>Title of Article: </b>' . $_POST['article-title'].'</p>'.
'<p><b>Type of Paper: </b>' . $_POST['types'].'</p>'.
'<p><b>Other type: </b>' . $_POST['your-type'].'</p>';
$mail->AltBody = 'This is a plain-text message body';
 if (array_key_exists('userfile', $_FILES)) {
    // First handle the upload
    // Don't trust provided filename - same goes for MIME types  
    $uploadfile = tempnam(sys_get_temp_dir(), sha1( $_FILES['userfile']['name']));
    $fileName = $_FILES['userfile']['name'];
//     if (isset($_FILES['userfile']) &&
//     $_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
//     $mail->AddAttachment($_FILES['userfile']['tmp_name'],
//                          $_FILES['userfile']['name']);
// }
if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Thanks, File is valid, and was successfully uploaded.\n";
    $mail->addAttachment($uploadfile, $fileName );
} else {
    echo "Possible invalid file upload !\n";
}
    // if (is_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    //     // Attach the uploaded file
    //     $mail->addAttachment($uploadfile, $fileName );
    // }else{
    //     echo "not upload";
    // }
    
}
//Attach an image file
// $mail->addAttachment('../imgs/Logo.png');
//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<br/> your message sent!";
//     var_dump($_FILES);
//   var_dump($uploadfile) ;
   

    //Section 2: IMAP
    //Uncomment these to save your message in the 'Sent Mail' folder.
    #if (save_mail($mail)) {
    #    echo "Message saved!";
    #}
}
//Section 2: IMAP
//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
//You can use imap_getmailboxes($imapStream, '/imap/ssl') to get a list of available folders or labels, this can
//be useful if you are trying to get this working on a non-Gmail IMAP server.
function save_mail($mail)
{
    //You can change 'Sent Mail' to any other folder or tag
    $path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";
    //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
    $imapStream = imap_open($path, $mail->Username, $mail->Password);
    $result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
    imap_close($imapStream);
    return $result;
}
?>
