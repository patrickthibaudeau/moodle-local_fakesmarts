<?php
require_once('../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);

$context = context_system::instance();

\local_fakesmarts\base::page(
    new moodle_url('/local/fakesmarts/bot_types.php'),
    get_string('bot_types', 'local_fakesmarts'),
    get_string('bot_types', 'local_fakesmarts'),
    $context
);

$PAGE->requires->js_call_amd('local_fakesmarts/bot_type', 'init');

//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$bot_types = new \local_fakesmarts\output\bot_types();
echo $output->render_bot_types($bot_types);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();