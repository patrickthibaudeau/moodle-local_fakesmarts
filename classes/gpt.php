<?php

namespace local_fakesmarts;

use local_fakesmarts\fakesmart;
use local_fakesmarts\logs;

class gpt
{

    /**
     * Call to MS OpenAI API that returns the results
     *
     * @param $data
     * @return mixed
     * @throws \dml_exception
     */
    protected static function _make_call($data)
    {
        $config = get_config('local_fakesmarts');
        $url = $config->azure_endpoint . '/openai/deployments/' . $config->deployment_name . '/chat/completions?api-version=2023-05-15';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'api-key: ' . $config->azure_key));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2000);
        $result = json_decode(curl_exec($ch));
//        print_object($result);
//        die;
        curl_close($ch);
        return $result;
    }

    /**
     * Build the message to send to the API
     * @param int $bot_id
     * @param string $prompt
     * @return object
     * @throws \dml_exception
     */
    protected static function _build_message($bot_id, $prompt, $content = '')
    {
        // Create object that will return the data
        $data = new \stdClass();
        $FAKESMART = new fakesmart($bot_id);
        // initiate cache store
        $cache = \cache::make('local_fakesmarts', 'fakesmarts_system_messages');
        // Get system message and user content from cache
        $system_message = $cache->get($FAKESMART->get_bot_type() . '_' . sesskey());
        if ($FAKESMART->use_indexing_server()) {
            $user_content = $content;
        } else {
            $user_content = $cache->get($bot_id . '_' . sesskey());
        }
        // Get number of words in content and split it into chunks if it's too long
        $chunk_text = self::_split_into_chunks($user_content);
        // Determine the context window size (overlap)
        $context_window_size = 50;
        $prompt_tokens = 0;
        $completion_tokens = 0;
        $total_tokens = 0;
        $summary = [];
        $i = 0;
        // Loop through the chunks and send them to the API
        foreach ($chunk_text as $i => $chunk) {
            // Add the previous response's tail as the context for the current chunk
            if ($i > 0) {
                $context = substr($chunk_text[$i - 1], -$context_window_size);
                $chunk = $context . $chunk;
            }
            $messages = [
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $system_message
                    ],
                    [
                        'role' => 'user',
                        'content' => $chunk
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ];
            $result = self::_make_call(json_encode($messages));
            // Add the number of tokens used for the prompt to the total tokens
            $prompt_tokens = $prompt_tokens + $result->usage->prompt_tokens;
            $completion_tokens = $completion_tokens + $result->usage->completion_tokens;
            $total_tokens = $total_tokens + $result->usage->total_tokens;
            // Capture the response
            $summary[] = $result->choices[0]->message->content;
        }

        if (count($summary) > 1) {
            $content_prompt = '';
            $sentences = '';
            foreach ($summary as $i => $response) {
                if ($response != '') {
                    $sentences .= $response . "\n";
                }
            }
            $content_prompt .= $sentences;
            "Question: Please answer with a boolean only to the following question. In the sentences provided above, do all the sentences mean the same thing?\n";
            $messages = [
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You compare text. You only answer with a single boolean. You return the boolean that appears more often.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $content_prompt
                    ]
                ]
            ];

            $comparison_result = self::_make_call(json_encode($messages));
            // Add the number of tokens used for the comparison to the total tokens
            $prompt_tokens = $prompt_tokens + $comparison_result->usage->prompt_tokens;
            $completion_tokens = $completion_tokens + $comparison_result->usage->completion_tokens;
            $total_tokens = $total_tokens + $comparison_result->usage->total_tokens;

            $answer = $comparison_result->choices[0]->message->content;
            if ($answer == 'True') {
                $summaries = $summary[0];
            } else {
                $summaries = implode('', $summary);
            }
        } else {
            // Implode the chunks into one string
            $summaries = implode('', $summary);
        }
        // Get the cost of the call
        $cost = self::_get_cost($total_tokens);
        // Add to logs
        logs::insert($bot_id, $prompt, $summaries, $prompt_tokens, $completion_tokens, $total_tokens, $cost);

        $data->prompt_tokens = $prompt_tokens;
        $data->completion_tokens = $completion_tokens;
        $data->total_tokens = $total_tokens;
        $data->cost = $cost;
        $data->message = $summaries;
        return $data;
    }

    /**
     * Split a long text into smaller chunks
     * @param $long_text
     * @return array
     */
    protected static function _split_into_chunks($long_text)
    {
        // plugin config
        $config = get_config('local_fakesmarts');

        // Define the chunk size (maximum words per chunk)
        $chunk_size = $config->max_chunks;

        // Determine the context window size (overlap)
        $context_window_size = 50;

        // Initialize an array to store the chunked text
        $chunks = [];

        // Get the length of the long text
        $text_length = str_word_count($long_text);

        // Determine the context window size (overlap)
        $context_window_size = 50;

        // Split the long text into smaller chunks with overlap
        $chunks = array_chunk(str_split($long_text, $chunk_size - $context_window_size), 1);
        $chunks = array_map('implode', $chunks);

        return $chunks;
    }

    /**
     * Take a string and turn any valid URLs into HTML links
     * @param $input
     * @return array|string|string[]|null
     */
    protected static function _make_link($input)
    {
        $url_pattern = '<https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)>';
        $str = preg_replace($url_pattern, '<a href="$0" target="_blank">$0</a> ', $input);
        // Remove duplicate links
        return preg_replace('/\[.*\]/', '', $str);
    }

    /**
     * Take a string and turn any valid emails into HTML links
     * @param $input
     * @return array|string|string[]|null
     */
    protected static function _make_email($input)
    {
        //Detect and create email
        $mail_pattern = "/([A-z0-9\._-]+\@[A-z0-9_-]+\.)([A-z0-9\_\-\.]{1,}[A-z])/";
        return preg_replace($mail_pattern, '<a href="mailto:$1$2">$1$2</a>', $input);

    }

    /**
     * Get the cost of the API call
     * @param $object GPT object rteturned from the API
     * @return float
     * @throws \dml_exception
     */
    protected static function _get_cost($total_tokens): float
    {
        // plugin config
        $config = get_config('local_fakesmarts');
        $cost = ($total_tokens / 1000) * $config->gpt_cost;

        return $cost;
    }

    /**
     * Get the response from the API
     * @param $bot_id
     * @param $prompt
     * @return object
     * @throws \dml_exception
     */
    public static function get_response($bot_id, $prompt, $content = ''): object
    {
        $content = '';
        // Build the message
        $data = self::_build_message($bot_id, $prompt, $conten);
        $message = $data->message;

        // Format the message
        if (isset($message)) {
            $message = nl2br(htmlspecialchars($message));
            $message = self::_make_link($message);
            $message = self::_make_email($message);
        }

        $data->message = $message;

        return $data;
    }

    /**
     * Used for automatic testing and comparing text
     * @param $bot_id
     * @param $prompt
     * @return string
     * @throws \dml_exception
     */
    public static function compare_text($response, $answer): string
    {
        $content_prompt = '';
        $sentences = "Text 1: " . $response . "\n\nText 2: " . $answer;
        $content_prompt .= $sentences;
        "Question: Please answer with a boolean only to the following question. In the two texts provided above, do the two texts mean the same thing?\n";
        $messages = [
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You compare text. You only answer with a single boolean. You return the boolean that appears more often.'
                ],
                [
                    'role' => 'user',
                    'content' => $content_prompt
                ]
            ]
        ];

        $comparison_result = self::_make_call(json_encode($messages));
        return $comparison_result->choices[0]->message->content;
    }



}