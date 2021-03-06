<html>
    <head>
        <title>Attachment Mail</title>
    </head>

    <body>

        <?php
            function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {
                $file = $path.$filename;
                $file_size = filesize($file);
                $handle = fopen($file, "r");
                $content = fread($handle, $file_size);
                fclose($handle);
                $content = chunk_split(base64_encode($content));
                $uid = md5(uniqid(time()));
                $header = "From: ".$from_name." <".$from_mail.">\r\n";
                $header .= "Reply-To: ".$replyto."\r\n";
                $header .= "MIME-Version: 1.0\r\n";
                $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
                $header .= "This is a multi-part message in MIME format.\r\n";
                $header .= "--".$uid."\r\n";
                $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
                $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
                $header .= $message."\r\n\r\n";
                $header .= "--".$uid."\r\n";
                $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
                $header .= "Content-Transfer-Encoding: base64\r\n";
                $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
                $header .= $content."\r\n\r\n";
                $header .= "--".$uid."--";
                if (mail($mailto, $subject, "", $header)) {
                    echo "mail send ... OK"; // or use booleans here
                } else {
                    echo "mail send ... ERROR!";
                }
            }

            $my_file = "company-logo.png";
            $my_path = '/var/www/html/bitmascotv3/wp-content/themes/webalive/images/'; // directory path
            $my_name = "Iman Ali";
            $my_mail = "my@mail.com";
            $my_replyto = "my_reply_to@mail.net";
            $my_subject = "This is a mail with attachment.";
            $my_message = "Test <b>Message</b>";
            mail_attachment($my_file, $my_path, "iman@bitmascot.com", $my_mail, $my_name, $my_replyto, $my_subject, $my_message);

        ?>

    </body>
</html>
