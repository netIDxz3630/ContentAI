<?php

// include the functions.php file
require_once 'web_page_helper.php';
require_once 'chatgpt_rewrite.php';

// use the get_web_page() function to get the webpage content
//$url = 'https://weglot.com/blog/making-customers-our-business/';
$url = 'https://weglot.com/blog/international-ecommerce-on-the-rise/';

$response = get_web_page($url);
var_dump($response);
// create a DOM object and load the HTML content
$dom = new DOMDocument();
@$dom->loadHTML($response['content']);

// get the title of the page
$title = $dom->getElementsByTagName('title')->item(0)->nodeValue;

// get the content of the page with their titles
$content = array();
$current_title = '';
foreach ($dom->getElementsByTagName('*') as $node) {
    if (in_array($node->nodeName, array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p'))) {
        $text = trim($node->textContent);
        if (!empty($text)) {
            if (in_array($node->nodeName, array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'))) {
                $current_title = $text;
            } else {
                $content[$current_title][] = strip_tags($node->ownerDocument->saveHTML($node));
            }
        }
    }
}

echo "Webpage Title: " . $title . "\n" . "\n";
foreach ($content as $title => $sections) {
    echo "\n" . "Title: " . $title . "\n";
    foreach ($sections as $section) {
//        $new_content = chatgpt($section);
        echo "Content: " . $section . "\n";
//        echo "Rewrite Content: " . $new_content . "\n";
//        echo $new_content . "\n";
    }
}