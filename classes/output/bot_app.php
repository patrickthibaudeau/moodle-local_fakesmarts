<?php
/**
 * *************************************************************************
 * *                           YULearn ELMS                               **
 * *************************************************************************
 * @package     local                                                     **
 * @subpackage  yulearn                                                   **
 * @name        YULearn ELMS                                              **
 * @copyright   UIT - Innovation lab & EAAS                               **
 * @link                                                                  **
 * @author      Patrick Thibaudeau                                        **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************ */
namespace local_fakesmarts\output;

use local_fakesmarts\fakesmart;
use local_fakesmarts\cria;
use local_fakesmarts\output\type;

class bot_app implements \renderable, \templatable
{

    /**
     * @var int
     */
    private $bot_id;

    public function __construct($bot_id)
    {
        $this->bot_id = $bot_id;
    }

    /**
     *
     * @param \renderer_base $output
     * @return type
     * @global \moodle_database $DB
     * @global type $USER
     * @global type $CFG
     */
    public function export_for_template(\renderer_base $output)
    {
        global $USER, $CFG, $DB;

        $FAKESMART = new fakesmart($this->bot_id);

        $chat_id = 0;
        if ($FAKESMART->use_bot_server()) {
            $session = cria::start_chat($this->bot_id);
            $chat_id = $session->chat_id;
        } else {
            $cache = \cache::make('local_fakesmarts', 'fakesmarts_system_messages');
            $system_message = $cache->set($FAKESMART->get_bot_type() . '_' . sesskey(), $FAKESMART->get_bot_type_system_message()  . ' ' . $FAKESMART->get_bot_system_message());
        }

        $data = [
            'bot_id' => $this->bot_id,
            'name' => $FAKESMART->get_name(),
            'use_bot_server' => $FAKESMART->use_bot_server(),
            'chat_id' => $chat_id,
            'user_prompt' => $FAKESMART->get_user_prompt(),
        ];
        return $data;
    }

}
