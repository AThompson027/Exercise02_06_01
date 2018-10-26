<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="modernizr.custom.65897.js"></script>
    <link rel="stylesheet" href="Guest.css">
    <link href="https://fonts.googleapis.com/css?family=Charmonman|Pacifico" rel="stylesheet">
    <title>Post Guest</title>
</head>

<body>
    <?php
    // if the submit button in the form is pushed then it will
    if (isset($_POST['submit'])) {
        $email = stripslashes($_POST['email']);
        $name = stripslashes($_POST['name']);
        // this finds strings that are put into the input and replaces it with other strings
        $name = str_replace("~" , "-", $name);
        $email = str_replace("~" , "-", $email);
        $existingNames = array();
        if (file_exists("messages.txt") && filesize("messages.txt") > 0) {
            $messageArray = file("messages.txt");
            $count = count($messageArray);
            for ($i = 0; $i < $count; $i++) {
                $currMsg = explode("~", $messageArray[$i]);
                $existingNames[] = $currMsg[0];
            }
        }
        // in_array tells you if your feed it a value if it's an element in an array. (Searches if keys exist)
        if (in_array($name, $existingNames)) {
            echo "<h3 style=\"background-color: red; color: white; border: 1px solid darkred; width: 500px; height: 50px; text-align: center; margin-left:33%; padding-top: 20px;\">The name <em>\"$name\"</em> You entered already exist!</h3><br>\n";
            echo "<h3 style=\"background-color: red; color: white; border: 1px solid darkred; width: 500px; height: 50px; text-align: center; margin-left:33%; padding-top: 20px;\">Please enter a new name and try again.</h3><br>\n";
            echo "<h3 style=\"background-color: red; color: white; border: 1px solid darkred; width: 500px; height: 50px; text-align: center; margin-left:33%; padding-top: 20px;\">Your message was not saved.</h3>\n";
        }
        else {
        $messageRecord = "$name~$email\n";
        $fileHandle = fopen("messages.txt", "ab");
            
        // if the fileHandle is not opening the file then it will give out an error message
        if(!$fileHandle) {
            echo "<h3 style=\"background-color: red; color: white; border: 1px solid darkred; width: 500px; height: 50px; text-align: center; margin-left:33%; padding-top: 20px;\">There was an error saving your info!</h3>\n";
        } else {
            fwrite($fileHandle, $messageRecord);
            fclose($fileHandle);
            echo "<h3 style=\"background-color: green; color: white; border: 1px solid darkred; width: 500px; height: 50px; text-align: center; margin-left: 33%; padding-top: 20px;\">Your info has been saved.</h3>\n";
            $name = "";
            $email = "";
       }
        }
        
    }
    else {
            $name = "";
            $email = "";
    }
    
    ?>
    <h1>Post Guest</h1>
    <form action="PostGuest.php" method="post">
        <span style="font-weight: bold; font-family: 'Charmonman', cursive;">Name : <input type="text" name="name" value="<?php echo $name;?>"></span><br>
        <span style="font-weight: bold; font-family: 'Charmonman', cursive;">Email : <input type="text" name="email" value="<?php echo $email;?>"></span><br>
        <input type="reset" name="reset" value="Reset Form">
        <input type="submit" name="submit" value="Post Message"><br><br>
        <a id="view" href="GuestBook.php">View Guest Info</a>
    </form>
</body>

</html>