<?php
session_start();

// Flash message helper
// EXAMPLE - flash('register_success', 'You are now registered');
// DISPLAY IN VIEW - echo flash('register_success');
function flash($name = '', $message = '', $class = 'alert alert-success')
{
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }

            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash" >' . $_SESSION[$name] . ' <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div> ';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

function isLoggedIn()
{
    if (isset($_SESSION['user_id'])) {
        return true;
    } else {
        return false;
    }
}

//dump and then die
function  dump_die($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    die();
}
//dump but keep page 
function  dump($data)
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

function gen_unique_id($len)
{
    $bytes = random_bytes(3);
    return bin2hex($bytes);
}
//simple page redirect

function redirect($page)
{
    header('location:' . URLROOT . $page);
}

function dataToSeoUrl($year, $manufacturer, $model, $application)
{
    $year = seoUrl($year);
    $manufacturer = seoUrl($manufacturer);
    $model = seoUrl($model);
    $application = seoUrl($application);

    return $year . "-" . $manufacturer . "-" . $model . "-" . $application;
}
function  seoUrl($string)
{
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    return $string;
}

function accessProtected($obj, $prop) {
    $reflection = new ReflectionClass($obj);
    $property = $reflection->getProperty($prop);
    $property->setAccessible(true);
    return $property->getValue($obj);
  }


  function create_email_variables($variables){
    
  }




