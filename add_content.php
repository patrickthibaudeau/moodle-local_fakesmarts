<?php

require_once("../../config.php");

require_once($CFG->dirroot . "/local/fakesmarts/classes/forms/add_content_form.php");
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

$rootFolder = __DIR__.'/classes/Smalot/PdfParser';

// Manually require files, which can't be loaded automatically that easily.
require_once $rootFolder.'/Element.php';
require_once $rootFolder.'/PDFObject.php';
require_once $rootFolder.'/Font.php';
require_once $rootFolder.'/Page.php';
require_once $rootFolder.'/Element/ElementString.php';
require_once $rootFolder.'/Encoding/AbstractEncoding.php';

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

$bot_id= required_param('id', PARAM_INT);

$formdata = new stdClass();
$formdata->fakesmarts_id = $bot_id;


$mform = new \local_fakesmarts\add_content_form(null, array('formdata' => $formdata));
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
    redirect($CFG->wwwroot . '/local/fakesmarts/index.php');
} else if ($data = $mform->get_data()) {

    //common settings to all imports
    $filename = $mform->get_new_filename('importedFile');
    $fileContent = $mform->get_file_content('importedFile');
    $path = $CFG->dataroot . '/temp/fakesmarts';

    if(!is_dir($path)){
        mkdir($path);
    }

    $path = $CFG->dataroot . '/temp/fakesmarts/' . $data->fakesmarts_id;
    if(!is_dir($path)){
        mkdir($path);
    }

    $file_path = $path . '/' . $filename;

    file_put_contents($file_path, $fileContent);


        require_once('classes/rd_text_extraction.php');
        $content = RD_Text_Extraction::convert_to_text($file_path);



    $content_data = [
        'fakesmarts_id' => $data->fakesmarts_id,
        'content' => $content,
        'name' => $filename,
        'usermodified' => $USER->id,
        'timemodified' => time(),
        'timecreated' => time(),
    ];

    $DB->insert_record('local_fakesmarts_files', $content_data);

    redirect($CFG->wwwroot . '/local/fakesmarts/content.php?id=' . $data->fakesmarts_id,);

} else {

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