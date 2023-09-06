<?php
require_once('../../../config.php');

use local_fakesmarts\fakesmart;
// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

$bot_id = required_param('id', PARAM_INT);
$FAKESMART = new fakesmart($bot_id);
\local_fakesmarts\base::page(
    new moodle_url('/local/fakesmarts/index.php'),
    $FAKESMART->get_name(),
    $FAKESMART->get_name(),
    $context
);

$PAGE->requires->js_call_amd('local_fakesmarts/gpt', 'init');
//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$dashboard = new \local_fakesmarts\output\bot_app($bot_id);
echo $output->render_bot_app($dashboard);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();