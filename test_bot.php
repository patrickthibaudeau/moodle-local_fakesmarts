<?php
require_once('../../config.php');
use local_fakesmarts\gpt;
// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

$bot_id = required_param('id', PARAM_INT);

\local_fakesmarts\base::page(
    $CFG->wwwroot . '/local/fakesmarts/test_bot.php',
    get_string('testing_bot', 'local_fakesmarts'),
    get_string('testing_bot', 'local_fakesmarts'),
    $context);

$PAGE->requires->js_call_amd('local_fakesmarts/gpt', 'init');
//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$test_bot = new \local_fakesmarts\output\test_bot($bot_id);
echo $output->render_test_bot($test_bot);
//$cache = cache::make('local_fakesmarts', 'fakesmarts_system_messages');
//echo $cache->get(8 . '_' . sesskey());

//print(gpt::get_response(15, 'What is this bot used for?'));
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();