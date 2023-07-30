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
    // Update content
    $DB->update_record('local_fakesmarts_files', $data);

    $cache = cache::make('local_fakesmarts', 'fakesmarts_system_messages');
    // Get all records for theis bot
    $records = $DB->get_records('local_fakesmarts_files', ['fakesmarts_id' => $data->fakesmarts_id]);
    $content = '';
    foreach ($records as $record) {
        $content .= $record->content . "\n\n";
    }
    // Delete the cache for this bot
    $cache->delete($data->fakesmarts_id);
    // Set the cache for this bot
    $cache->set($data->fakesmarts_id, $content);
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