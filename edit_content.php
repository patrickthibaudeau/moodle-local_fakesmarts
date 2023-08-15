<?php

require_once("../../config.php");

require_once($CFG->dirroot . "/local/fakesmarts/classes/forms/edit_content_form.php");


use local_fakesmarts\base;
use local_fakesmarts\fakesmart_file;



global $CFG, $OUTPUT, $USER, $PAGE, $DB, $SITE;

$context = CONTEXT_SYSTEM::instance();

require_login(1, false);
// Get content id
$id= required_param('id', PARAM_INT);

$FILES = new fakesmart_file($id);

$formdata = $FILES->get_record();

// Create form
$mform = new \local_fakesmarts\edit_content_form(null, array('formdata' => $formdata));
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/local/fakesmarts/content.php?id=' . $formdata->fakesmarts_id);
} else if ($data = $mform->get_data()) {
    $FAKESMARTSFILE = new fakesmart_file($data->fakesmarts_id);
//    $data->content = $content = preg_replace('/\s+/', ' ', trim($data->content));
    // Update content
    $DB->update_record('local_fakesmarts_files', $data);

    $FAKESMARTSFILE->upload_files_to_indexing_server($data->fakesmarts_id, $data->id, true);
    // Redirect to the content page
    redirect($CFG->wwwroot . '/local/fakesmarts/content.php?id=' . $data->fakesmarts_id,);
} else {
    // Show form
    $mform->set_data($mform);
}

base::page(
    new moodle_url('/local/fakesmarts/edit_content.php', ['id' => $id]),
    get_string('add_content', 'local_fakesmarts'),
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