<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/* #********************************************#
  #                   ClusterCoding             #
  #*********************************************#
  #      Author:     ClusterCoding              #
  #      Email:      info@clustercoding.com     #
  #      Website:    http://clustercoding.com   #
  #                                             #
  #      Version:    1.0.0                      #
  #      Copyright:  (c) 2017 - ClusterCoding   #
  #                                             #
  #*********************************************# */

class Pages_model extends CI_Model {
 
    private $_faq = 'faq';  
    private $_contactus = 'contactus'; 
    public function get_faq_list()
    {
        $this->db->from($this->_faq);   
        $this->db->order_by('heading_order,display_order');    
        $query =  $this->db->get();
        $res =  $query->result();
        return $res;
    }
    public function store_contactus($data)
    {
        $this->db->insert($this->_contactus, $data); 
		return $this->db->affected_rows();  
    }
}
