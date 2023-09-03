<?php
require_once('../../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

\local_fakesmarts\base::page(
    new moodle_url('/local/fakesmarts/minutes_master/test.php'),
    get_string('minutes_master', 'local_fakesmarts'),
    get_string('minutes_master', 'local_fakesmarts'),
    $context
);

$PAGE->requires->js_call_amd('local_fakesmarts/minutes_maker', 'init');

//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$dashboard = new \local_fakesmarts\output\minutes_maker();
echo $output->render_minutes_maker($dashboard);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();