<?php

class User_model extends CRUD_model
{
    protected $_table = 'user';
    protected $_primary_key = 'user_id';
    
    // ------------------------------------------------------------------------
    
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------------------
    
}
