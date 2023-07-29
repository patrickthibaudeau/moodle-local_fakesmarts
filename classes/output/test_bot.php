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

use local_fakesmarts\gpt;
use local_fakesmarts\fakesmart;
use local_fakesmarts\fakesmart_files;

class test_bot implements \renderable, \templatable
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
//        $FILES = new fakesmart_files($this->bot_id);
//        $system_message = $FAKESMART->get_bot_type_system_message();
//        $messages = [
//            'messages' => [
//                [
//                    'role' => 'system',
//                    'content' => $system_message
//                ],
//                [
//                    'role' => 'user',
//                    'content' => $FILES->concatenate_content()
//                ],
//                [
//                    'role' => 'user',
//                    'content' => 'Who teaches the course?'
//                ]
//            ]
//        ];

        $prompt = 'Is there a zoom link for this course?';

        print_object(gpt::get_response($this->bot_id, $prompt));

        $data = [
            'bot_id' => $this->bot_id,
            'name' => $FAKESMART->get_name()
        ];
        return $data;
    }

}
