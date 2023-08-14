<?php
require_once('../../config.php');

use local_fakesmarts\cria;
// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

\local_fakesmarts\base::page(
    new moodle_url('/local/fakesmarts/testing.php'),
    get_string('pluginname', 'local_fakesmarts'),
    'Testing',
    $context
);


//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$chat_id = 'f17b4821-b3ba-4c61-808e-d260482d8957';
$bot_id = 11;
//print_object($_POST);
//print_object($_FILES['file']);
//print_object(cria::send_chat_request($bot_id, $chat_id, 'When should I register?'));

print_object(cria::get_chat_history($bot_id, $chat_id));
print_object(cria::get_chat_summary($bot_id));


//print_object(cria::get_files(11));
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();