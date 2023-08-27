<?php

namespace local_fakesmarts;

use local_fakesmarts\fakesmart;
use local_fakesmarts\fakesmarts;
use local_fakesmarts\models;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/formslib.php');
require_once($CFG->dirroot . '/config.php');

class bot_form extends \moodleform
{

    protected function definition()
    {
        global $DB, $OUTPUT;

        $formdata = $this->_customdata['formdata'];
        // Create form object
        $mform = &$this->_form;

        $MODELS = new models();

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('header', 'home-nav-start', get_string('bot', 'local_fakesmarts'));
       // Name form element
        $mform->addElement('text', 'name', get_string('name', 'local_fakesmarts'));
        $mform->setType('name', PARAM_TEXT);

        // Description form element
        $mform->addElement('editor', 'description_editor', get_string('description', 'local_fakesmarts'));
        $mform->setType('description', PARAM_RAW);

        // Bot type form element
        $mform->addElement('select', 'bot_type', get_string('bot_type', 'local_fakesmarts'), fakesmarts::get_bot_types());
        $mform->setType('bot_type', PARAM_INT);
        $mform->addHelpButton('bot_type', 'bot_type', 'local_fakesmarts');

        // Bot type form element
        $mform->addElement('select', 'model_id', get_string('model', 'local_fakesmarts'), $MODELS->get_select_array());
        $mform->setType('model_id', PARAM_INT);

        // Bot type form element
        $mform->addElement('select', 'embedding_id', get_string('embedding', 'local_fakesmarts'), $MODELS->get_select_array());
        $mform->setType('embedding_id', PARAM_INT);

        // Bot system message form element
        $mform->addElement('textarea', 'bot_system_message', get_string('bot_system_message', 'local_fakesmarts'));
        $mform->setType('bot_system_message', PARAM_TEXT);
        $mform->addHelpButton('bot_system_message', 'bot_system_message', 'local_fakesmarts');

        $mform->addElement('header', 'display-settings-nav-start', get_string('display_settings', 'local_fakesmarts'));
     // Welcome message element
        $mform->addElement('editor', 'welcome_message_editor', get_string('welcome_message', 'local_fakesmarts'));
        $mform->setType('welcome_message', PARAM_RAW);



        $this->add_action_buttons();
        $this->set_data($formdata);
    }

    // Perform some extra moodle validation
    public function validation($data, $files)
    {
        global $DB;

        $errors = parent::validation($data, $files);

//        if (is_null($data['id'])) {
//            $id = -1;
//        } else {
//            $id = $data['id'];
//        }
//
//        if ($data['yulearncategoryid'] == 0) {
//            $errors['yulearncategoryid'] = get_string('field_required', 'local_yulearn');
//        }
//
//        if ($data['id'] < 1) {
//            $sql = 'SELECT * FROM {yulearn_course} WHERE shortname = "'
//                . trim($data['shortname']) . '" AND '
//                . 'id != ' . $id;
//            if ($foundcourses = $DB->get_records_sql($sql)) {
//
//                if (!empty($foundcourses)) {
//                    foreach ($foundcourses as $foundcourse) {
//                        $foundcoursenames[] = $foundcourse->fullname;
//                    }
//                    $foundcoursenamestring = implode(',', $foundcoursenames);
//                    $errors['shortname'] = get_string('shortnametaken', '', $foundcoursenamestring);
//                }
//            }
//
//            if ($foundMoodleCourse = $DB->get_record('course', ['shortname' => trim($data['shortname'])])) {
//                $errors['shortname'] = get_string('shortnametaken');
//            }
//
//
//            $sql = 'SELECT * FROM {yulearn_course} WHERE externalcode = "'
//                . trim($data['externalcode']) . '" AND '
//                . 'id != ' . $id;
//            if ($foundcourses = $DB->get_records_sql($sql)) {
//
//                if (!empty($foundcourses)) {
//                    foreach ($foundcourses as $foundcourse) {
//                        $foundcoursenames[] = $foundcourse->fullname;
//                    }
//                    $foundcoursenamestring = implode(',', $foundcoursenames);
//                    $errors['externalcode'] = get_string('externalcode_taken', 'local_yulearn', $foundcoursenamestring);
//                }
//            }
//
//            if ($data['hascertificate']) {
//                if (!$data['certificatetemplateid']) {
//                    $errors['certificatetemplateid'] = get_string('required', 'local_yulearn');
//                }
//            }
//        }
//
//        // Certificate notifications
//        for ($i = 0; $i < count($data['rnotificationruleid']); $i++) {
//            if ($data['remailtemplateid'][$i] == 0) {
//                $errors['remailtemplateid'][$i] = get_string('required', 'local_yulearn');
//            }
//        }
//
//        for ($i = 0; $i < count($data['remailtemplateid']); $i++) {
//            if (isset($data['rnotificationruleid'])) {
//                if ($data['rnotificationruleid'][$i] == 0) {
//                    $errors['rnotificationruleid'][$i] = get_string('required', 'local_yulearn');
//                }
//            } else {
//                $errors['rnotificationruleid'][$i]  = get_string('required', 'local_yulearn');
//            }
//        }

        return $errors;
    }

}
