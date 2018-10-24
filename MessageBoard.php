<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Board</title>
    <script src="modernizr.custom.65897.js"></script>
</head>
<h1>Message Board</h1>

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
        echo "<p>There are no messages posted.</p>\n";
    } else {
        // this represents the file used
        $messageArray = file("messages.txt");
        echo "<table style=\"background-color: lightgrey\" border=\"1\" width=\"100%\">\n";
        // counts how many elements are in the array
        $count = count($messageArray);
        // this will create a shelf in the array with the subject as the key
       

        for ($i = 0; $i < $count; $i++) {
            $currMsg = explode("~", $messageArray[$i]);
            $keyMessageArray[$currMsg[0]] = $currMsg[1] . "~" . $currMsg[2];
        }

        $index = 1;
        $key = key($keyMessageArray);
        foreach ($keyMessageArray as $message) {
            // this breaks the string every time there is an "~" into multiple strings
            $currMsg = explode("~", $message);
            echo "<tr>\n";
            
            echo "<td width=\"5%\" style=\"text-align: center; font-weight: bold\">" . $index . "</td>\n";
            
            echo "<td width=\"85%\"><span style=\"font-weight: bold\">Subject: </span>" . htmlentities($key) . "<br>\n";
            
            echo "<span style=\"font-weight: bold\">Name: </span>" . htmlentities($currMsg[0]) . "<br>\n";
            
            echo "<span style=\"text-decoration: underline; font-weight: bold\">Message: </span><br>\n" . htmlentities($currMsg[1]) . "</td>\n";
            echo "<td width=\"10%\" style=\"text-align:center\">" . "<a href='MessageBoard.php?" . "action=Delete%20Message&" . "message=" . ($index - 1) . "'>" . "Delete This Message</a></td>\n";
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
    <a href="PostMessage.php">Post New Message</a><br>
    <a href="MessageBoard.php?action=Sort%20Ascending">Sort Subjects A-Z</a><br>
    <a href="MessageBoard.php?action=Sort%20Descending">Sort Subjects Z-A</a><br>
<!--part of the URL that passes data in named value pairs (seperated by "&")-->
    <a href="MessageBoard.php?action=Delete%20First">Delete First Message</a><br>
    <a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a><br>
<!--    <a href="MessageBoard.php?action=Remove%20Duplicates">Remove Duplicates</a><br>-->
    </p>
</body>
</html>
