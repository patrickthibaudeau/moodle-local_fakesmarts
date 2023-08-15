<?php

namespace local_fakesmarts;

use local_fakesmarts\fakesmart;
use local_fakesmarts\fakesmart_file;
use local_fakesmarts\fakesmart_files;
use local_fakesmarts\gpt;

class cria
{

    /**
     * Create a bot on the indexing server
     * @param $bot_id
     * @return mixed|null
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public static function create_bot($bot_id)
    {
        $FAKESMART = new fakesmart($bot_id);
        $system_message = $FAKESMART->get_bot_type_system_message() . ' ' . $FAKESMART->get_bot_system_message();

        $data = [
            "system_message" => $system_message,
            "chat_expires_seconds" => 900
        ];

        $data = json_encode($data);
        // Create bot
        $new_bot = gpt::_make_call($bot_id, $data, 'create', 'POST', true);

        if ($new_bot->status == 409) {
            return \core\notification::error(get_string('bot_already_exists', 'local_fakesmarts'));
        }
        return $new_bot;
    }

    /**
     * Get bot configuration
     * @param $bot_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function get_bot($bot_id)
    {

        // Create bot
        return gpt::_make_call($bot_id, [], 'config', 'GET', true);
    }

    /**
     * @param $bot_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function delete_bot($bot_id)
    {
        // Create bot
        return gpt::_make_call($bot_id, [], 'delete', 'DELETE', true);
    }

    /**
     * @param $bot_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function update_bot($bot_id)
    {
        $FAKESMART = new fakesmart($bot_id);
        $system_message = $FAKESMART->get_bot_type_system_message() . ' ' . $FAKESMART->get_bot_system_message();

        $data = [
            "field" => "system_message",
            "value" => $system_message
        ];

        $data = json_encode($data);
        // Create bot
        return gpt::_make_call($bot_id, $data, 'config', 'PATCH', true);
    }

    /**
     * @param $bot_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function get_files($bot_id)
    {
        // Create bot
        return gpt::_make_call($bot_id, '', 'files', 'GET', true);
    }

    /**
     * @param $bot_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function add_file($bot_id, $file_id)
    {
        global $CFG;

        // Get config to use later for the indexing server api key
        $config = get_config('local_fakesmarts');
        // Create objects
        $FAKESMART = new fakesmart($bot_id);
        $FAKESMARTFILE = new fakesmart_file($file_id);

        // Create temp file
        $file_name = $FAKESMARTFILE->get_indexing_server_file_name();

        // Make sure temp folders exist
        if (!is_dir($CFG->dataroot . '/local/fakesmarts/')) {
            mkdir($CFG->dataroot . '/local/fakesmarts/', 0777, true);
        }
        if (!is_dir($CFG->dataroot . '/local/fakesmarts/' . $bot_id)) {
            mkdir($CFG->dataroot . '/local/fakesmarts/' . $bot_id, 0777, true);
        }
        // Set full path
        $full_path = $CFG->dataroot . '/local/fakesmarts/' . $bot_id . '/' . $file_name;
        // Create temp file
        file_put_contents($full_path, $FAKESMARTFILE->get_content());
        // Initiate CURL
        $curl = curl_init();
        // Set parameters
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://patdev.glendon.yorku.ca:3001/bots/' . $bot_id
                . '/files/?x-api-key=' . $config->indexing_server_api_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Content-Type: multipart/form-data'
            ),
            CURLOPT_POSTFIELDS => array(
                'files' => new \CURLFILE($full_path, 'text/plain'),
            ),
        ));
        // Upload file
        $result = curl_exec($curl);
        curl_close($curl);

        if ($result === false) {
           \core\notification::error('File upload failed.');
        } else {
            return json_decode($result);
        }
    }

    /**
     * @param $bot_id
     * @param $file File can be either the file name or the indexing server file id
     * @return mixed
     * @throws \dml_exception
     */
    public static function delete_file($bot_id, $file)
    {
        // Create array
        $data = [
           $file
        ];
        $data = json_encode($data);
        // Make call
        return gpt::_make_call($bot_id, $data, 'files', 'DELETE', true);
    }

    /**
     * Start a chat session
     * @param $bot_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function start_chat($bot_id)
    {
        // Make call
        return gpt::_make_call($bot_id, '', 'chats/start', 'POST', true);
    }

    /**
     * Send message for reply from GPT
     * @param $bot_id
     * @param $chat_id
     * @param $message
     * @return mixed
     * @throws \dml_exception
     */
    public static function send_chat_request($bot_id, $chat_id, $message)
    {
        // Create array
        $data = [
            "message" => $message
        ];
        $data = json_encode($data);
        // Make call
        return gpt::_make_call($bot_id, $data, 'chats/' . $chat_id . '/send', 'POST', true);
    }

    /**
     * Get chat summary
     * @param $bot_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function get_chat_summary($bot_id) {
        // Make call
        return gpt::_make_call($bot_id, '', 'chats/summary', 'GET', true);
    }

    /**
     * Get caht history
     * @param $bot_id
     * @param $chat_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function get_chat_history($bot_id, $chat_id) {
        // Make call
        $results = gpt::_make_call($bot_id, '', 'chats/' . $chat_id . '/history', 'GET', true);
        if ($results->status == 404) {
            \core\notification::error(get_string('chat_does_not_exist', 'fakesmarts'));
        }
    }

    /**
     * End chat session
     * @param $bot_id
     * @param $chat_id
     * @return mixed
     * @throws \dml_exception
     */
    public static function end_chat($bot_id, $chat_id) {
        // Make call
        return gpt::_make_call($bot_id, '', 'chats/' . $chat_id . '/end', 'DELETE', true);
    }

}