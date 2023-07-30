<?php
require_once('../../config.php');
use local_fakesmarts\gpt;
// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

$bot_id = required_param('id', PARAM_INT);

\local_fakesmarts\base::page($CFG->wwwroot . '/local/fakesmarts/index.php', get_string('pluginname', 'local_fakesmarts'), '', $context);

$PAGE->requires->js_call_amd('local_fakesmarts/gpt', 'init');
//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$test_bot = new \local_fakesmarts\output\test_bot($bot_id);
echo $output->render_test_bot($test_bot);
$cache = cache::make('local_fakesmarts', 'fakesmarts_system_messages');
//echo $cache->get(1 . '_' . sesskey());
//print(gpt::get_response(8, 'Who teaches this course?'));
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();