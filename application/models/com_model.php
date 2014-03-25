<?php

class Com_model extends CRUD_model
{
    protected $_table = 'com';
    protected $_primary_key = 'com_id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}
