<?php

// Load the OpenAI PHP SDK
require_once __DIR__ . '/autoload.php';

// Import the OpenAI class from the SDK
use Orhanerday\OpenAi\OpenAi;

/**
 * @throws Exception
 */
function chatgpt($text)
{
    // Put OpenAi key in here
    $open_ai = new OpenAi('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');
    // Get text from input box
    if (isset($_POST['text'])) {
        $text = $_POST['text'];
    }

    $model = 'text-davinci-003';
    $params = [
        'max_tokens' => 3000,
        'temperature' => 0.5,
//        'stop' => '.',
    ];

    if (isset($text)) {
        // Split the text into paragraphs
        $paragraphs = explode("\n", $text);

        // Initialize an empty string to store the output
        $output = "";

        // Iterate over each paragraph and send it to the OpenAI chat model
        foreach ($paragraphs as $paragraph) {
            if (!empty(trim($paragraph))) {
                $response = $open_ai->completion([
                    'model' => $model,
                    'prompt' => "When writing the following content I need it to have a good amount of perplexity and burstiness. Rewrite the following sentence:\n$paragraph\n\nNew sentence:",
                    'max_tokens' => $params['max_tokens'],
                    'temperature' => $params['temperature'],
//                    'stop' => $params['stop'],
                ]);

                $result = json_decode($response, true);
                $generated_text = trim($result['choices'][0]['text']);

                // Append the generated text to the output
                if (!empty($output)) {
                    $output .= "\n";
                }
                $output .= $generated_text . "\n";
            }
        }
        echo $output;
    }
}