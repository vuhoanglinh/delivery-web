<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 class Pagination_model extends CI_Model
 {
	
	// private $_name = 'ci_books';
	 function __construct()
	 { 
		parent::__construct(); 
	 }
	 
	 public function getTotal($table) 
	 { 
		$this->db->select();
		$query = $this->db->get($table);
		
		return $query->num_rows();
	 } 
 }