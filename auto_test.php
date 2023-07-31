<?php
require_once('../../config.php');

use local_fakesmarts\fakesmart;
use local_fakesmarts\fakesmart_files;
use local_fakesmarts\gpt;

// CHECK And PREPARE DATA
global $CFG, $OUTPUT, $SESSION, $PAGE, $DB, $COURSE, $USER;

require_login(1, false);
$context = context_system::instance();

$bot_id = required_param('id', PARAM_INT);

\local_fakesmarts\base::page(new moodle_url('/local/fakesmarts/auto_test.php', ['id' => $bot_id]), get_string('pluginname', 'local_fakesmarts'), '', $context);

$PAGE->requires->js_call_amd('local_fakesmarts/gpt', 'init');
//**************** ******
//*** DISPLAY HEADER ***
//**********************
echo $OUTPUT->header();

$tests = $DB->get_records('local_fakesmarts_qa', ['fakesmarts_id' => $bot_id]);

$FAKESMART = new fakesmart($bot_id);
$FAKESMARTFILES = new fakesmart_files($bot_id);
$bot_type = $FAKESMART->get_bot_type();
// Build the cache for the bot
$cache = \cache::make('local_fakesmarts', 'fakesmarts_system_messages');
// Delete any existing cache for this bot
$cache->delete($bot_type . '_' . sesskey());
$cache->delete($bot_id . '_' . sesskey());
// Set the cache for this bot
$cache->set($bot_type . '_' . sesskey(), $FAKESMART->concatenate_system_messages());
$cache->set($bot_id . '_' . sesskey(), $FAKESMARTFILES->concatenate_content());

ob_start();
$data = [];
$i = 0;
foreach ($tests as $test) {

    $response = gpt::get_response($bot_id, $test->question);
    $comparsion = gpt::compare_text($response, $test->answer);
    $data['id'] = $test->id;
    if ($comparsion == 'true') {
        $data['accuracy'] = 1;
        echo '<div class="alert alert-success" role="alert">' . $test->question . '<br>'
            . '<p><b>GPT Response:</b><br>' . $response . '</p>'
            . '<p><b>Correct Answer:</b><br>' . $test->answer . '</p>' .
            '</div>';
    } else {
        $data['accuracy'] = 0;
        echo '<div class="alert alert-danger" role="alert">' . $test->question . '<br>'
            . '<p><b>GPT Response:</b><br>' . $response . '</p>'
            . '<p><b>Correct Answer:</b><br>' . $test->answer . '</p>' .
            '</div>';
    }
    $DB->update_record('local_fakesmarts_qa', $data);
    ob_flush();
    flush();
    if ($i == 3) {
        break;
    }
    $i++;
}
ob_clean();

//print(gpt::get_response(8, 'Can I give my presentation with someone else?'));
//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();