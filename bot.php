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

} else {
    $formdata = new stdClass();
}



$mform = new \local_fakesmarts\bot_form(null, array('formdata' => $formdata));
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/local/fakesmarts/index.php');
} else if ($data = $mform->get_data()) {

    if ($data->id) {
        $FAKESMART = new fakeSmart($data->id);
        $data->description = $data->description_editor['text'];
        $FAKESMART->update_record($data);
    } else {
        $data->description = $data->description_editor['text'];
        $FAKESMART = new fakeSmart();
        $FAKESMART->insert_record($data);
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