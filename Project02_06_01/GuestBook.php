<!DOCTYPE html>
<html style="background-color: firebrick;" lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Book</title>
    <script src="modernizr.custom.65897.js"></script>
</head>
<h2 style="background-color: indianred; font-family: 'Pacifico', cursive; text-align: center; color: white; text-shadow: 4px 3px firebrick; width: 500px; margin-left: 33%;">Guest Book</h2>

<body>
    <?php
    if (isset($_GET['action'])) {
        if (file_exists("messages.txt") || filesize("messages.txt") != 0) {
            $messageArray = file("messages.txt");
            switch ($_GET['action']) {
                case 'Delete First':
                    // this takes out the first element and shifts
                    array_shift($messageArray);
                    break;
                    // this pops out the last element from the array
                case 'Delete Last':
                    array_pop($messageArray);
                    break;
                case 'Delete Message':
                     if (isset($_GET['message'])) {
                         // this function takes out and element and replaces it with another element
                         array_splice($messageArray, $_GET['message'], 1);
                     }
                    break;
                case 'Remove Duplicates':
                    $messageArray = array_unique($messageArray);
                    $messageArray = array_values($messageArray);
                    break;
                    case 'Sort Ascending':
                    //this sorts the messages in alphabetical order
                    sort($messageArray);
                    break;
                    case 'Sort Descending':
                    //this sorts the messages in backwards from alphabetical order
                    rsort($messageArray);
                    break;
            }
            if (count($messageArray > 0)) {
                $newMessages = implode($messageArray);
                // write & binary 
                // this will wipe out the content in the file
                $fileHandle = fopen('messages.txt', "wb");
                // if the file will not open or wipe out the content from the file then it will echo out an error message
                if (!$fileHandle) {
                    echo "There was an error updating the message file.\n";
                } else {
                    fwrite($fileHandle, $newMessages);
                    fclose($fileHandle);
                }
            } else {
                // this unlinks the message.txt
                unlink("messages.txt");
            }
        }
    }
    // if the file does not exist or if the filesize is 0 (no messages)
    if (!file_exists("messages.txt") || filesize("messages.txt") === 0) {
        echo "<p style=\"background-color: white; font-weight: bold; border: 5px solid darkred; text-align: center; padding: 5px; font-family: 'Charmonman', cursive;\">There are no guests posted.</p>\n";
    } else {
        // this represents the file used
        $messageArray = file("messages.txt");
        echo "<table style=\"background-color: white;\" border=\"1\" width=\"100%\">\n";
        // counts how many elements are in the array
        $count = count($messageArray);
        // this will create a shelf in the array with the subject as the key
       

        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $messageArray[$i]);
            $keyMessageArray[$currMsg[0]] = $currMsg[1];
        }

        $index = 1;
        $key = key($keyMessageArray);
        foreach ($keyMessageArray as $message) {
            // this breaks the string every time there is an "~" into multiple strings
            $currMsg = explode("~", $message);
            echo "<tr>\n";
            
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold; background-color: white;\">" . $index . "</td>\n";
            
            echo "<td width=\"85%\"><span style=\"font-weight: bold; font-family: 'Charmonman', cursive; background-color: white;\">Name: </span>" . htmlentities($key) . "<br>\n";
            
            echo "<span style=\"font-weight: bold; font-family: 'Charmonman', cursive; background-color: white;\">Email: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            echo "<td width=\"10%\" style=\"text-align: center; background-color: white; padding: 2px;\">" . "<a style=\"color: black; text-decoration: none; font-family: 'Charmonman', cursive; font-weight: bold;\" href='GuestBook.php?" . "action=Delete%20Message&" . "message=" . ($index - 1) . "'>" . "Delete This Message</a></td>\n";
            echo "</tr>\n";
            ++$index;
            //gets the next key
            next($keyMessageArray);
            $key = key($keyMessageArray);
        }
        echo "</table>\n";
    }
    ?>
    <p>
    <a href="PostGuest.php" style="color: black; text-decoration: none; font-family: 'Charmonman', cursive; font-weight: bold; text-align: center; background-color: white; padding: 2px; box-shadow: 4px 3px darkred;">Post New Message</a>
    <a href="GuestBook.php?action=Sort%20Ascending" style="color: black; text-decoration: none; font-family: 'Charmonman', cursive; font-weight: bold; text-align: center; background-color: white; padding: 2px; margin: 2px; box-shadow: 4px 3px darkred; margin-top: 100px;" >Sort Subjects A-Z</a>
    <a href="GuestBook.php?action=Sort%20Descending" style="color: black; text-decoration: none; font-family: 'Charmonman', cursive; font-weight: bold; text-align: center; background-color: white; padding: 2px; box-shadow: 4px 3px darkred;">Sort Subjects Z-A</a>
<!--part of the URL that passes data in named value pairs (seperated by "&")-->
    <a href="GuestBook.php?action=Delete%20First" style="color: black; text-decoration: none; font-family: 'Charmonman', cursive; font-weight: bold; text-align: center; background-color: white; padding: 2px; box-shadow: 4px 3px darkred;">Delete First Message</a>
    <a href="GuestBook.php?action=Delete%20Last" style="color: black; text-decoration: none; font-family: 'Charmonman', cursive; font-weight: bold; text-align: center; background-color: white; padding: 2px; box-shadow: 4px 3px darkred;">Delete Last Message</a>
    </p>
</body>
</html>