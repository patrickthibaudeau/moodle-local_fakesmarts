<?php

namespace local_fakesmarts;

use local_fakesmarts\fakesmart;
use local_fakesmarts\fakesmart_files;

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

        return $result;
    }

    /**
     * Build the message to send to the API
     * @param int $bot_id
     * @param string $prompt
     * @return object
     * @throws \dml_exception
     */
    protected static function _build_message($bot_id, $prompt) {
        $FAKESMART = new fakesmart($bot_id);
        $FILES = new fakesmart_files($bot_id);
        $system_message = $FAKESMART->get_bot_type_system_message();
        $messages = [
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $system_message
                ],
                [
                    'role' => 'user',
                    'content' => $FILES->concatenate_content()
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ]
        ];

        return json_encode($messages);
    }

    /**
     * Take a string and turn any valid URLs into HTML links
     * @param $input
     * @return array|string|string[]|null
     */
    protected static function _make_link($input) {
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
    protected static function _make_email($input){
        //Detect and create email
        $mail_pattern = "/([A-z0-9\._-]+\@[A-z0-9_-]+\.)([A-z0-9\_\-\.]{1,}[A-z])/";
        return preg_replace($mail_pattern, '<a href="mailto:$1$2">$1$2</a>', $input);

    }
    /**
     * Get the response from the API
     * @param int $bot_id
     * @param string $prompt
     * @return string
     * @throws \dml_exception
     */
    public static function get_response($bot_id, $prompt)
    {
        $content = '';
        // Build the message
        $data = self::_build_message($bot_id, $prompt);
        // Call the API
        $result = self::_make_call($data);
        // If a response is returned, format it
        if (isset($result->choices[0]->message->content)) {
            $content = $result->choices[0]->message->content;
            $content = nl2br( htmlspecialchars( $content));
            $content = self::_make_link($content);
            $content = self::_make_email($content);
        }
        return $content;
    }
}