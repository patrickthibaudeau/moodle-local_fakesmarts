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

use local_fakesmarts\fakesmarts;

class bot_config implements \renderable, \templatable
{


    public function __construct()
    {

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

        $context = \context_system::instance();

        $FAKESMARTS = new fakesmarts();

        $bots = $FAKESMARTS->get_records();
        $bots = array_values($bots);

        $data = [
            'bots' => $bots,
            'can_edit' => has_capability('local/fakesmarts:edit_bots', $context),
            'can_delete' => has_capability('local/fakesmarts:delete_bots', $context),
            'can_test' => has_capability('local/fakesmarts:test_bots', $context),
            'can_view_bot_types' => has_capability('local/fakesmarts:view_bot_types', $context),
            'can_edit_bot_content' => has_capability('local/fakesmarts:edit_bot_content', $context),
            'can_view_bot_logs' => has_capability('local/fakesmarts:view_bot_logs', $context),
        ];
print_object($data);
        return $data;
    }

}
