<?php

class Pages extends Controller
{
    // the constructor
    public function __construct()
    {
        $this->pageModel = $this->model('Page');
        $this->aclModel = $this->model('Acl');
    }
    public function index()
    {



        $data = [
            'title' => 'meta Title ',
            'description' => 'meta description',
            'canonical' => 'link'

        ];
        //load the view
        $this->view('pages/index', $data);
    }
}
