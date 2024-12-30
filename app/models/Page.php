<?php
class Page
{
    private $db;

    public function __construct()
    {
        //init database
        $this->db = new Database;
    }
}
