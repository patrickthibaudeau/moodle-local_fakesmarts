<?php
require_once('../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);

$bot_id = required_parAM('id', PARAM_INT);

$context = context_system::instance();

\local_fakesmarts\base::page(
    new moodle_url('/local/fakesmarts/content.php', ['id' => $bot_id]),
    get_string('content', 'local_fakesmarts'),
    '',
    $context
);

$PAGE->requires->js_call_amd('local_fakesmarts/content', 'init');

//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$content = new \local_fakesmarts\output\content($bot_id);
echo $output->render_content($content);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();