<?php
require_once('../../config.php');

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

\local_cts_co\base::page($CFG->wwwroot . '/local/fakesmarts/index.php', get_string('pluginname', 'local_fakesmarts'), '', $context);


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