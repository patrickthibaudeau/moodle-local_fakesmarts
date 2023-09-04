<?php
/*
 * Author: Admin User
 * Create Date: 27-07-2023
 * License: LGPL 
 * 
 */

namespace local_fakesmarts;

use local_fakesmarts\crud;
use local_fakesmarts\cria;

class fakesmart extends crud
{


    /**
     *
     * @var int
     */
    private $id;

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string
     */
    private $description;

    /**
     *
     * @var int
     */
    private $bot_type;

    /**
     *
     * @var int
     */
    private $model_id;

    /**
     *
     * @var int
     */
    private $embedding_id;

    /**
     *
     * @var int
     */
    private $system_reserved;

    /**
     *
     * @var string
     */
    private $bot_system_message;

    /**
     *
     * @var int
     */
    private $usermodified;

    /**
     *
     * @var int
     */
    private $timecreated;


    /**
     *
     * @var int
     */
    private $timemodified;

    /**
     *
     * @var string
     */
    private $table;


    /**
     *
     *
     */
    public function __construct($id = 0)
    {
        global $CFG, $DB, $DB;

        $this->table = 'local_fakesmarts';

        parent::set_table($this->table);

        if ($id) {
            $this->id = $id;
            parent::set_id($this->id);
            $result = $this->get_record($this->table, $this->id);
        } else {
            $result = new \stdClass();
            $this->id = 0;
            parent::set_id($this->id);
        }

        $this->name = $result->name ?? '';
        $this->description = $result->description ?? '';
        $this->bot_type = $result->bot_type ?? 0;
        $this->system_reserved = $result->system_reserved ?? 0;
        $this->model_id = $result->model_id ?? 0;
        $this->embedding_id = $result->embedding_id ?? 0;
        $this->bot_system_message = $result->bot_system_message ?? '';
        $this->usermodified = $result->usermodified ?? 0;
        $this->timecreated = $result->timecreated ?? 0;
        $this->timemodified = $result->timemodified ?? 0;

    }

    /**
     * @return id - bigint (18)
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @return name - varchar (255)
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @return description - longtext (-1)
     */
    public function get_description()
    {
        return $this->description;
    }

    /**
     * @return bot_type - tinyint (2)
     */
    public function get_bot_type()
    {
        return $this->bot_type;
    }

    /**
     * @return system_reserved - int (1)
     */
    public function get_system_reserved() {
        return $this->system_reserved;
    }

    /**
     * Get Model record
     * @return mixed|\stdClass
     */
    public function get_model_config() {
        $MODEL = new model($this->model_id);
        return $MODEL->get_result();
    }

    /**
     * Get Embedding record
     * @return mixed|\stdClass
     */
    public function get_embedding_config() {
        $MODEL = new model($this->embedding_id);
        return $MODEL->get_result();
    }

    /**
     * @return string
     * @throws \dml_exception
     */
    public function get_bot_type_system_message(): string
    {
        global $DB;
        $bot_type = $DB->get_record('local_fakesmarts_type', array('id' => $this->bot_type));
        return $bot_type->system_message ?? '';
    }

    /**
     * @return string
     * @throws \dml_exception
     */
    public function use_indexing_server(): string
    {
        global $DB;
        $bot_type = $DB->get_record('local_fakesmarts_type', array('id' => $this->bot_type));
        return $bot_type->use_indexing_server;
    }

    /**
     * @return bot_system_message - longtext (-1)
     */
    public function get_bot_system_message()
    {
        return $this->bot_system_message;
    }

    /**
     * Builds the system message based on the bot type and the local bot system message
     * @return string
     * @throws \dml_exception
     */
    public function concatenate_system_messages(): string
    {
        return $this->get_bot_type_system_message() . $this->get_bot_system_message();
    }

    /**
     * @return usermodified - bigint (18)
     */
    public function get_usermodified()
    {
        return $this->usermodified;
    }

    /**
     * @return timecreated - bigint (18)
     */
    public function get_timecreated()
    {
        return $this->timecreated;
    }

    /**
     * @return timemodified - bigint (18)
     */
    public function get_timemodified()
    {
        return $this->timemodified;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_id($id)
    {
        $this->id = $id;
    }

    /**
     * @param Type: varchar (255)
     */
    public function set_name($name)
    {
        $this->name = $name;
    }

    /**
     * @param Type: longtext (-1)
     */
    public function set_description($description)
    {
        $this->description = $description;
    }

    /**
     * @param Type: tinyint (2)
     */
    public function set_bot_type($bot_type)
    {
        $this->bot_type = $bot_type;
    }

    /**
     * @param Type: longtext (-1)
     */
    public function set_bot_system_message($bot_system_message)
    {
        $this->bot_system_message = $bot_system_message;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_usermodified($usermodified)
    {
        $this->usermodified = $usermodified;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_timecreated($timecreated)
    {
        $this->timecreated = $timecreated;
    }

    /**
     * @param Type: bigint (18)
     */
    public function set_timemodified($timemodified)
    {
        $this->timemodified = $timemodified;
    }

    /**
     * @return void
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function create_bot_on_indexing_server()
    {
        cria::create_bot($this->id);
    }

    /**
     * @return void
     * @throws \coding_exception
     * @throws \dml_exception
     */
    public function update_bot_on_indexing_server()
    {
        $bot_exists = cria::get_bot($this->id);

        if ($bot_exists->status == 404) {
            cria::create_bot($this->id);
        } else {
            cria::update_bot($this->id);
        }
    }

}