<?php

require_once 'chatgpt_rewrite.php';

// check if the 'text' parameter was received via POST request
if(isset($_POST['text'])) {
    // retrieve the value of the 'text' parameter and store it in a variable called 'name'
    $text = $_POST['text'];
    // Call the chatgpt function with the user's input
    $response = chatgpt($text);
    // Output the response to the user
    echo $response;
} else {
    // output a message indicating that no text was received
    echo "No text was received.";
}