<?php
require_once('../../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

\local_fakesmarts\base::page(
    new moodle_url('/local/fakesmarts/minutes_master/index.php'),
    get_string('translation_app', 'local_fakesmarts'),
    get_string('translation_app', 'local_fakesmarts'),
    $context
);

$PAGE->requires->js_call_amd('local_fakesmarts/translate', 'init');

//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$dashboard = new \local_fakesmarts\output\translate();
echo $output->render_translate($dashboard);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();