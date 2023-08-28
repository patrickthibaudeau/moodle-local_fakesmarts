<?php
namespace local_fakesmarts;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/lib/formslib.php');
require_once($CFG->dirroot . '/config.php');

class edit_content_form extends \moodleform
{

    protected function definition()
    {
        global $DB;

        $formdata = $this->_customdata['formdata'];
        // Create form object
        $mform = &$this->_form;

        $word_count = str_word_count($formdata->content);
        $mform->addElement(
            'hidden',
            'id'
        );
        $mform->setType(
            'id',
            PARAM_INT
        );

        $mform->addElement(
            'hidden',
            'fakesmarts_id'
        );
        $mform->setType(
            'fakesmarts_id',
            PARAM_INT)
        ;

        //Header: General
        $mform->addElement(
            'header',
            'edit_content_form',
            get_string('edit_content', 'local_fakesmarts')
        );

        // Show file name
        $mform->addElement(
            'html',
            "<h3>$formdata->name</h3>"
        );
        // Edit file content
        $mform->addElement(
            'textarea',
            'content',
            get_string('content', 'local_fakesmarts'),
            [
                'rows' => 30,
                'cols' => 80
            ]
        );

        $mform->addElement(
            'static',
            'word_count',
            get_string('word_count', 'local_fakesmarts'),
            $word_count
        );

        $this->add_action_buttons();
        $this->set_data($formdata);
    }

    // Perform some extra moodle validation
    public function validation($data, $files)
    {
        global $DB;

        $errors = parent::validation($data, $files);

        return $errors;
    }

}
