<?php
/*
 * Author: Admin User
 * Create Date: 27-07-2023
 * License: LGPL 
 * 
 */
namespace local_fakesmarts;

class fakesmarts {

    // Bot type factual
    const BOT_TYPE_FACTUAL = 1;

    // Bot type transcription
    const BOT_TYPE_TRANSCRIPTION = 2;
	/**
	 *
	 *@var string
	 */
	private $results;

	/**
	 *
	 *@global \moodle_database $DB
	 */
	public function __construct() {
	    global $DB;
	    $this->results = $DB->get_records('local_fakesmarts');
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

    static public function get_bot_types() {
        global $DB;
        $types = $DB->get_records('local_fakesmarts_type', []);
        $bot_types = [];
        foreach ($types as $type) {
            $bot_types[$type->id] = $type->name;
        }
        return $bot_types;
    }

}