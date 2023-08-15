<?php

require_once("../../config.php");

require_once($CFG->dirroot . "/local/fakesmarts/classes/forms/bot_form.php");


use local_fakesmarts\base;
use local_fakesmarts\fakesmart;


global $CFG, $OUTPUT, $USER, $PAGE, $DB, $SITE;

$id = optional_param('id', 0, PARAM_INT);

$context = CONTEXT_SYSTEM::instance();

require_login(1, false);

if ($id) {
    $FAKESMART = new fakeSmart($id);
    $formdata = $FAKESMART->get_record();
    $formdata->description_editor['text'] = $formdata->description;
    $formdata->welcome_message_editor['text'] = $formdata->welcome_message;

} else {
    $formdata = new stdClass();
}


$mform = new \local_fakesmarts\bot_form(null, array('formdata' => $formdata));
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/local/fakesmarts/bot_config.php');
} else if ($data = $mform->get_data()) {

    if ($data->id) {
        $FAKESMART = new fakeSmart($data->id);
        $data->description = $data->description_editor['text'];
        $data->welcome_message = $data->welcome_message_editor['text'];
        $FAKESMART->update_record($data);
        if ($FAKESMART->use_indexing_server()) {
            $FAKESMART->update_bot_on_indexing_server();
        }

    } else {
        $data->description = $data->description_editor['text'];
        $data->welcome_message = $data->welcome_message_editor['text'];
        $FAKESMART = new fakeSmart();
        $id = $FAKESMART->insert_record($data);
        $NEW_BOT = new fakeSmart($id);
        if ($NEW_BOT->use_indexing_server()) {
            $NEW_BOT->create_bot_on_indexing_server();
        }
    }


    redirect($CFG->wwwroot . '/local/fakesmarts/bot_config.php');


} else {

    $mform->set_data($mform);
}


base::page(
    new moodle_url('/local/fakesmarts/bot.php', ['id' => $id]),
    get_string('bot', 'local_fakesmarts'),
    '',
    $context,
    'standard'
);


echo $OUTPUT->header();
//**********************
//*** DISPLAY HEADER ***
//

$mform->display();


//**********************
//*** DISPLAY FOOTER ***
//**********************
echo $OUTPUT->footer();
?>