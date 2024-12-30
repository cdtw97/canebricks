<?php 
/*
* Base controller 
* loads the models and views
*/

class Controller{
    // load model 
    public function model($model){
    //require model file
    require_once('../app/models/' . $model . '.php');

    //init model
    return new $model();

    }

    //load view
    public function view($view, $data =[]){
        //check for the view file
        if(file_exists('../app/views/' . $view . '.php')){
            require_once('../app/views/' . $view . '.php');

        }else{
            // View does not exist
            die('The view: "' . $view . '" does not exist');
        }


    }

}