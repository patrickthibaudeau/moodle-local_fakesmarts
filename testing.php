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

$file_name = '8a51e01f-eb69-4f3b-9cc5-a8846a004a50';
$bot_id = 13;
$prompt = "Is there a bachelor degree in business?";;
$chat_id = '68d5831c-f40e-4d17-bf1e-8d142431171e';
//print_object(cria::start_chat($bot_id));
print_object(cria::send_chat_request($bot_id, $chat_id, $prompt));

//print_object(cria::delete_file($bot_id, $file_name, true));
//print_object(cria::get_files($bot_id));
//print_object(cria::get_chat_summary($bot_id));


//print_object(cria::get_files(11));
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();