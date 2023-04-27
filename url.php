<?php

// include the functions.php file
require_once 'web_page_helper.php';
require_once 'chatgpt_rewrite.php';

if(isset($_POST['url'])) {
    $url = $_POST['url'];
    // echoes back the received url
    echo "URL: " . $url ."<br>";
    // use the get_web_page() function to get the webpage content
    $response = get_web_page($url);
    var_dump($response);
    // create a DOM object and load the HTML content
    $dom = new DOMDocument();
    @$dom->loadHTML($response['content']);

    // get the title of the page
    $title = $dom->getElementsByTagName('title')->item(0)->nodeValue;

    // get the content of the page
    $content = '';
    $xpath = new DOMXPath($dom);
    $elements = $xpath->query('//body//text()');

    foreach ($elements as $element) {
        if (!in_array($element->parentNode->nodeName, array('script', 'style', 'comment'))) {
            $content .= $element->nodeValue;
        }
    }

//    // display the original title and content
//    echo "Webpage Title: "."<br>" . $title ."<br>"."<br>"."<br>";
//    echo "Content: "."<br>" . $content."<br>"."<br>"."<br>";


    // Call the chatgpt function with the user's input
    $new_title =  chatgpt($title);
    $new_content = chatgpt($content);
    // Output the response to the user
    echo "Webpage Title: "."<br>" . $new_title ."<br>". "Content: "."<br>" . $new_content."<br>";
}
else {
    // if no name was received
    echo "No url was received.";
}

