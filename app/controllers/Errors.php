<?php

class Errors extends Controller
{
    // the constructor
    public function __construct()
    {
        $this->pageModel = $this->model('Page');
    }
    public function index()
    {

        $data = [
            'title' => 'Elite Support | Francis Canada Truck Center',
            'description' => 'Elite Support is a comprehensive support network of dealers that are trained and certified to provide the highest level of knowledge and professionalism.',
            'canonical' => 'https://18004trucks.com/elite-support',


        ];
        //load the view
        $this->view('errors/index', $data);
    }

    public function error404()
    {
        $data = [
            'title' => 'Error 404 | The page was not found..',
            'description' => 'Elite Support is a comprehensive support network of dealers that are trained and certified to provide the highest level of knowledge and professionalism.',
            'canonical' => 'https://18004trucks.com/error/404/',


        ];
        //load the view
        $this->view('errors/404', $data);
    }
}
