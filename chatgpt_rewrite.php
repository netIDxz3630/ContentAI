<?php

// Load the OpenAI PHP SDK
require_once __DIR__ . '/autoload.php';

// Import the OpenAI class from the SDK
use Orhanerday\OpenAi\OpenAi;

function chatgpt($text)
{
    // Put OpenAi key in here
//     
    // Get text from input box
    if (isset($_POST['text'])) {
        $text = $_POST['text'];
    }

    $model = 'text-davinci-003';
    $params = [
        'max_tokens' => 3000,
        'temperature' => 0.5,
    ];

    if (isset($text)) {
        // Split the text into paragraphs
        $paragraphs = explode("\n", $text);

        // Initialize an empty string to store the output
        $output = "";
        // Define the instruction
        $default_instruction = "Replace 'Weglot' with 'ConveyThis'. When writing the following content I need it to have perplexity and burstiness.";

        // Iterate over each paragraph and send it to the OpenAI chat model
        foreach ($paragraphs as $paragraph) {
            if (!empty(trim($paragraph))) {
                $response = $open_ai->completion([
                    'model' => $model,
                    'prompt' => $default_instruction . 'Rewrite the following sentences:' . $paragraph,
                    'max_tokens' => $params['max_tokens'],
                    'temperature' => $params['temperature'],
                ]);

                $result = json_decode($response, true);
                $generated_text = trim($result['choices'][0]['text']);

                // Append the generated text to the output
                $output .= $generated_text;
            }
        }
        echo $output;
    }
}
