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
        curl_close($ch);
        print_object($result);
        return $result;
    }

    /**
     * Build the message to send to the API
     * @param int $bot_id
     * @param string $prompt
     * @return object
     * @throws \dml_exception
     */
    protected static function _build_message($bot_id, $prompt)
    {
        $FAKESMART = new fakesmart($bot_id);
        // initiate cache store
        $cache = \cache::make('local_fakesmarts', 'fakesmarts_system_messages');
        // Get system message and user content from cache
        $system_message = $cache->get($FAKESMART->get_bot_type() . '_' . sesskey());
        $user_content = $cache->get($bot_id . '_' . sesskey());
        // Get number of words in content and split it into chunks if it's too long
        $chunk_text = self::_split_into_chunks($user_content);
        print_object(count($chunk_text));
        // Determine the context window size (overlap)
        $context_window_size = 50;
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
                        'content' => $chunk. ' Your response must only solely be based on the content from the context. Stick with the facts provided only.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ];
            $result = self::_make_call(json_encode($messages));
            $summary[] = $result->choices[0]->message->content;
        }

        if (count($summary) > 1) {
            $content_prompt = '';
            $sentences = '';
            foreach ($summary as $i => $response) {
                if ($response != '') {
                    $sentences .=  $response . "\n" ;
                }
            }
            $content_prompt .= $sentences;
            "Question: Please answer with a boolean only to the following question. In the sentences provided above, do they all the sentences mean the same thing?\n";
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

        return $summaries;
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
     * Get the response from the API
     * @param $bot_id
     * @param $prompt
     * @return string
     * @throws \dml_exception
     */
    public static function get_response($bot_id, $prompt) : string
    {
        $content = '';
        // Build the message
        $content = self::_build_message($bot_id,$prompt);

        // If a response is returned, format it
        if (isset($content)) {
            $content = $content;
            $content = nl2br(htmlspecialchars($content));
            $content = self::_make_link($content);
            $content = self::_make_email($content);
        }

        // Add to logs
        logs::insert($bot_id, $prompt, $content);
        return $content;
    }
}