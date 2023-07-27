<?php
/*
 * Author: Admin User
 * Create Date: 27-07-2023
 * License: LGPL 
 * 
 */
namespace local_fakesmarts;

use local_fakesmarts\crud;

class fakesmart_file extends crud {


	/**
	 *
	 *@var int
	 */
	private $id;

	/**
	 *
	 *@var int
	 */
	private $fakesmarts_id;

	/**
	 *
	 *@var string
	 */
	private $name;

	/**
	 *
	 *@var string
	 */
	private $content;

	/**
	 *
	 *@var int
	 */
	private $usermodified;

	/**
	 *
	 *@var int
	 */
	private $timecreated;

	/**
	 *
	 *@var string
	 */
	private $timecreated_hr;

	/**
	 *
	 *@var int
	 */
	private $timemodified;

	/**
	 *
	 *@var string
	 */
	private $timemodified_hr;

	/**
	 *
	 *@var string
	 */
	private $table;


    /**
     *  
     *
     */
	public function __construct($id = 0){
  	global $CFG, $DB, $DB;

		$this->table = 'local_fakesmarts_files';

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

		$this->fakesmarts_id = $result->fakesmarts_id ?? 0;
		$this->name = $result->name ?? '';
		$this->content = $result->content ?? '';
		$this->usermodified = $result->usermodified ?? 0;
		$this->timecreated = $result->timecreated ?? 0;
          $this->timecreated_hr = '';
          if ($this->timecreated) {
		        $this->timecreated_hr = strftime(get_string('strftimedate'),$result->timecreated);
          }
		$this->timemodified = $result->timemodified ?? 0;
      $this->timemodified_hr = '';
          if ($this->timemodified) {
		        $this->timemodified_hr = strftime(get_string('strftimedate'),$result->timemodified);
          }
	}

	/**
	 * @return id - bigint (18)
	 */
	public function get_id(){
		return $this->id;
	}

	/**
	 * @return fakesmarts_id - bigint (18)
	 */
	public function get_fakesmarts_id(){
		return $this->fakesmarts_id;
	}

	/**
	 * @return name - varchar (255)
	 */
	public function get_name(){
		return $this->name;
	}

	/**
	 * @return content - longtext (-1)
	 */
	public function get_content(){
		return $this->content;
	}

	/**
	 * @return usermodified - bigint (18)
	 */
	public function get_usermodified(){
		return $this->usermodified;
	}

	/**
	 * @return timecreated - bigint (18)
	 */
	public function get_timecreated(){
		return $this->timecreated;
	}

	/**
	 * @return timemodified - bigint (18)
	 */
	public function get_timemodified(){
		return $this->timemodified;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_id($id){
		$this->id = $id;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_fakesmarts_id($fakesmarts_id){
		$this->fakesmarts_id = $fakesmarts_id;
	}

	/**
	 * @param Type: varchar (255)
	 */
	public function set_name($name){
		$this->name = $name;
	}

	/**
	 * @param Type: longtext (-1)
	 */
	public function set_content($content){
		$this->content = $content;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_usermodified($usermodified){
		$this->usermodified = $usermodified;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_timecreated($timecreated){
		$this->timecreated = $timecreated;
	}

	/**
	 * @param Type: bigint (18)
	 */
	public function set_timemodified($timemodified){
		$this->timemodified = $timemodified;
	}

}