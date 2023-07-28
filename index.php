<?php
require_once('../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

\local_fakesmarts\base::page($CFG->wwwroot . '/local/fakesmarts/index.php', get_string('pluginname', 'local_fakesmarts'), '', $context);

$PAGE->requires->js_call_amd('local_fakesmarts/bot', 'init');
//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$output = $PAGE->get_renderer('local_fakesmarts');
$dashboard = new \local_fakesmarts\output\dashboard();
echo $output->render_dashboard($dashboard);
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();