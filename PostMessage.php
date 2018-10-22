<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
    <title>Post New Message</title>
</head>

<body>
   <?php
    // if the submit button in the form is pushed then it will
    if (isset($_POST['submit'])) {
        $subject = stripslashes($_POST['subject']);
        $name = stripslashes($_POST['name']);
        $message = stripslashes($_POST['message']);
        // this finds strings that are put into the input and replaces it with other strings
        $subject = str_replace("~" , "-", $subject);
        $name = str_replace("~" , "-", $name);
        $message = str_replace("~" , "-", $message);
        $messageRecord = "$subject~$name~$message\n";
        $fileHandle = fopen("messages.txt", "ab");
        
        // if the fileHandle is not opening the file then it will give out an error message
        if(!$fileHandle) {
            echo "There was an error saving your message!\n";
        } else {
            fwrite($fileHandle, $messageRecord);
            fclose($fileHandle);
            echo "Your message has been saved.\n";
        }
        
    }
    ?>
    <h1>Post New Message</h1>
    <hr>
    <form action="PostMessage.php" method="post">
        <span style="font-weight: bold;">Subject: <input type="text" name="subject"></span>
        <span style="font-weight: bold;">Name: <input type="text" name="name"></span><br>
        <textarea name="message" rows="6" cols="80" style="margin: 10px 5px 5px"></textarea><br>
        <input type="reset" name="reset" value="Reset Form">
        <input type="submit" name="submit" value="Post Message">
    </form>
    <hr>
    <p>
        <a href="MessageBoard.php">View Message</a>
        
    </p>
</body>
</html>
