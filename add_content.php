<?php

require_once("../../config.php");

require_once($CFG->dirroot . "/local/fakesmarts/classes/forms/add_content_form.php");

use local_fakesmarts\rd_text_extraction;
use local_fakesmarts\cria;

/**
 * Loads all files found in a given folder.
 * Calls itself recursively for all sub folders.
 *
 * @param string $dir
 */
function requireFilesOfFolder($dir)
{
    foreach (new DirectoryIterator($dir) as $fileInfo) {
        if (!$fileInfo->isDot()) {
            if ($fileInfo->isDir()) {
                requireFilesOfFolder($fileInfo->getPathname());
            } else {
                require_once $fileInfo->getPathname();
            }
        }
    }
}

$rootFolder = __DIR__ . '/classes/Smalot/PdfParser';

// Manually require files, which can't be loaded automatically that easily.
require_once $rootFolder . '/Element.php';
require_once $rootFolder . '/PDFObject.php';
require_once $rootFolder . '/Font.php';
require_once $rootFolder . '/Page.php';
require_once $rootFolder . '/Element/ElementString.php';
require_once $rootFolder . '/Encoding/AbstractEncoding.php';

/*
 * Load the rest of PDFParser files from /src/Smalot/PDFParser
 * Dont worry, it wont load files multiple times.
 */
requireFilesOfFolder($rootFolder);

use local_fakesmarts\base;
use local_fakesmarts\fakesmart_file;
use Smalot\PdfParser;


global $CFG, $OUTPUT, $USER, $PAGE, $DB, $SITE;

$context = CONTEXT_SYSTEM::instance();

require_login(1, false);
// Get bot id
$bot_id = required_param('id', PARAM_INT);

$formdata = new stdClass();
// Set bot id in formdata
$formdata->fakesmarts_id = $bot_id;

// Create form
$mform = new \local_fakesmarts\add_content_form(null, array('formdata' => $formdata));
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/local/fakesmarts/content.php?id=' . $formdata->fakesmarts_id);
} else if ($data = $mform->get_data()) {
    $FAKESMARTFILES = new fakesmart_file($data->fakesmarts_id);
    // Get file name and content
    $filename = strtolower(str_replace(' ', '_',$mform->get_new_filename('importedFile')));
    $fileContent = $mform->get_file_content('importedFile');
    $path = $CFG->dataroot . '/temp/fakesmarts';

    // Does the folder exist for fakesmarts
    if (!is_dir($path)) {
        mkdir($path);
    }
    // Does the folder exist for the bot
    $path = $CFG->dataroot . '/temp/fakesmarts/' . $data->fakesmarts_id;
    if (!is_dir($path)) {
        mkdir($path);
    }
    // Set the file path with filename
    $file_path = $path . '/' . $filename;
    // save the file
    file_put_contents($file_path, $fileContent);
    // Convert the content of the file to text
    $content = rd_text_extraction::convert_to_text($file_path);
    // Remove all lines and replace with space. AKA lower token count
//    $content = preg_replace('/\s+/', ' ', trim($content));
    // Create content data array
    $content_data = [
        'fakesmarts_id' => $data->fakesmarts_id,
        'content' => $content,
        'name' => $filename,
        'usermodified' => $USER->id,
        'timemodified' => time(),
        'timecreated' => time(),
    ];
    // Insert the content into the database
    $file_id = $DB->insert_record('local_fakesmarts_files', $content_data);

    // Upload files to indexing server
    $FAKESMARTFILES->upload_files_to_indexing_server($data->fakesmarts_id, $file_path, $filename);
    // Redirect to the content page
    redirect($CFG->wwwroot . '/local/fakesmarts/content.php?id=' . $data->fakesmarts_id,);
} else {
    // Show form
    $mform->set_data($mform);
}


base::page(
    new moodle_url('/local/fakesmarts/add_content.php'),
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