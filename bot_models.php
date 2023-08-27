<?php
require_once('../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);

$context = context_system::instance();

\local_fakesmarts\base::page(
    new moodle_url('/local/fakesmarts/bot_models.php'),
    get_string('bot_models', 'local_fakesmarts'),
    get_string('bot_models', 'local_fakesmarts'),
    $context
);

$PAGE->requires->js_call_amd('local_fakesmarts/bot_models', 'init');

//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$bot_models = new \local_fakesmarts\output\bot_models();
echo $output->render_bot_models($bot_models);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();