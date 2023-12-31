<?php

require_once("../../config.php");

require_once($CFG->dirroot . "/local/fakesmarts/classes/forms/model_form.php");

use local_fakesmarts\base;
use local_fakesmarts\model;

global $CFG, $OUTPUT, $USER, $PAGE, $DB, $SITE;

$id = optional_param('id', 0, PARAM_INT);

$context = CONTEXT_SYSTEM::instance();

$MODEL = new model($id);

require_login(1, false);

if ($id) {
    $formdata = $MODEL->get_result();
} else {
    $formdata = new stdClass();
}


$mform = new \local_fakesmarts\model_form(null, array('formdata' => $formdata));
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/local/fakesmarts/bot_models.php');
} else if ($data = $mform->get_data()) {
    if ($data->id) {
        $data->usermodified = $USER->id;
        $data->timemodified = time();
        $DB->update_record('local_fakesmarts_models', $data);
    } else {
        $data->usermodified = $USER->id;
        $data->timemodified = time();
        $data->timecreated = time();
        $DB->insert_record('local_fakesmarts_models', $data);
    }
    redirect($CFG->wwwroot . '/local/fakesmarts/bot_models.php');

} else {

    $mform->set_data($mform);
}


base::page(
    new moodle_url('/local/fakesmarts/edit_model.php', ['id' => $id]),
    get_string('model', 'local_fakesmarts'),
    get_string('model', 'local_fakesmarts'),
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