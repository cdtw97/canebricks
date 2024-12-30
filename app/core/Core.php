<?php
/* 
 * App Core Class
 * Creates URL & Loads core controller
 * URL FORMAT /controller/method/params
*/
class Core
{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {


        $string = file_get_contents('../app/helpers/urls.json');
        $url_corrections = json_decode($string, true);



        //print_r($this->getUrl());
        $url = $this->getUrl();
        // Look in controllers for first value
        if (isset($url[0])) {
            for ($col = 0; $col  <= count($url_corrections['url_one']) - 1; $col++) {
                if ($url[0] == $url_corrections['url_one']["$col"]["controller_variant"]) {
                    $url[0] = $url_corrections['url_one']["$col"]["controller"];
                }
            }
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                //if exists, set as controller 
                $this->currentController = ucwords($url[0]);
                //unset 0 index
                unset($url[0]);
            } else {
                //the controller does not exist. Redirect to 404 page.
                redirect('error/404');
            }
        }
        //require the controller
        require_once('../app/controllers/' . $this->currentController . '.php');
        //init the controller class
        $this->currentController = new $this->currentController;
        //check for second part of the url 
        if (isset($url[1])) {
            for ($col = 0; $col  <= count($url_corrections['url_two']) - 1; $col++) {
                if ($url[1] == $url_corrections['url_two']["$col"]["controller_variant"]) {
                    $url[1] = $url_corrections['url_two']["$col"]["controller"];
                }
            }

            //check if method exist in controller
            if (method_exists($this->currentController, $url[1])) {


                $this->currentMethod = $url[1];

                //unset url one
                unset($url[1]);
            } else {
                //method does not exist Redirect to 404 page..
            }
        }
        // Get params
        $this->params = $url ? array_values($url) : [];
        if (empty($this->params)) {
            $this->params = ['notSet'];
        }

        //call a callback with array of params 
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}
