<?php
require_once('../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

if (!has_capability('local/fakesmarts:view_bots', $context)) {
    throw new moodle_exception('nopermissions', 'error', '', 'You do not have permissions to access this page');
}


\local_fakesmarts\base::page(
    new moodle_url('/local/fakesmarts/bot_config.php'),
    get_string('bot_configurations', 'local_fakesmarts'),
    get_string('bot_configurations', 'local_fakesmarts'),
    $context);

$PAGE->requires->js_call_amd('local_fakesmarts/bot_config', 'init');
//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$dashboard = new \local_fakesmarts\output\bot_config();
echo $output->render_bot_config($dashboard);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();