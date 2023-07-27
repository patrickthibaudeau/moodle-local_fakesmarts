<?php
/*
 * Author: Admin User
 * Create Date: 27-07-2023
 * License: LGPL 
 * 
 */
namespace local_fakesmarts;
use local_fakesmarts\fakesmart;

class fakesmart_files {

	/**
	 *
	 *@var string
	 */
	private $results;

    /**
     * @var string
     */
    private $bot_id;

	/**
	 *
	 *@global \moodle_database $DB
	 */
	public function __construct($bot_id) {
	    global $DB;
        $this->bot_id = $bot_id;
	    $this->results = $DB->get_records('local_fakesmarts_files', array('fakesmarts_id' => $bot_id));
	}

	/**
	  * Get records
	 */
	public function get_records() {
	    return $this->results;
	}

	/**
	  * Array to be used for selects
	  * Defaults used key = record id, value = name 
	  * Modify as required. 
	 */
	public function get_select_array() {
	    $array = [
	        '' => get_string('select', 'local_fakesmarts')
	      ];
	      foreach($this->results as $r) {
	            $array[$r->id] = $r->name;
	      }
	    return $array;
	}

    public function get_bot_name() {
        $FAKESMART = new fakesmart($this->bot_id);
        return $FAKESMART->get_name();
    }

}