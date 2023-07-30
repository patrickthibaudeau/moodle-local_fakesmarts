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
        $FAKESMARTFILES = new fakesmart_files($this->bot_id);
        $bot_type = $FAKESMART->get_bot_type();
        // Build the cache for the bot
        $cache = \cache::make('local_fakesmarts', 'fakesmarts_system_messages');
        // Delete any existing cache for this bot
        $cache->delete($bot_type . '_' . sesskey());
        $cache->delete($this->bot_id . '_' . sesskey());
        // Set the cache for this bot
        $cache->set($bot_type . '_' . sesskey(), $FAKESMART->concatenate_system_messages());
        $cache->set($this->bot_id . '_' . sesskey(), $FAKESMARTFILES->concatenate_content());

        $data = [
            'bot_id' => $this->bot_id,
            'name' => $FAKESMART->get_name()
        ];
        return $data;
    }

}
