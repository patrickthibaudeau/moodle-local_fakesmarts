<?php
require_once('../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

$bot_id = required_param('id', PARAM_INT);
\local_fakesmarts\base::page(new moodle_url('/local/fakesmarts/bot_logs.php',['id' => $bot_id]), get_string('pluginname', 'local_fakesmarts'), '', $context);

//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$logs = new \local_fakesmarts\output\bot_logs($bot_id);
echo $output->render_bot_logs($logs);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();