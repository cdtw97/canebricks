<?php
class Users extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
    }
    //register controller
    public function index() {}
    public function register()
    {
        // check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process form

            //sannitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [
                "name" => trim($_POST['name']),
                "email" => trim($_POST['email']),
                "password" => trim($_POST['password']),
                "confirm_password" => trim($_POST['confirm_password']),
                "name_error" => "",
                "email_error" => "",
                "password_error" => "",
                "confirm_password_error" => "",
            ];
            //validate email 
            if (empty($data['email'])) {
                $data['email_error'] = 'please enter an email...';
            } else {
                //check email is not registered
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['email_error'] = 'That email is already taken. You can try to <a class="link-primary" href="' . URLROOT . 'users/login">Login here</a>, or use a different email.';
                }
            }
            //validate name 
            if (empty($data['name'])) {
                $data['name_error'] = 'please enter a name...';
            }

            //validate password
            if (empty($data['password'])) {
                $data['password_error'] = 'please enter a password...';
            } elseif (strlen($data['password']) < 6) {
                $data['password_error'] = 'Password must be 6 or more charactors in length';
            }

            //validate confirmation password
            if (empty($data['confirm_password'])) {
                $data['confirm_password_error'] = 'Please confirm your password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_error'] = 'Your passwords do not match';
                }
            }

            //make sure errors are empty
            if (empty($data['email_error']) && empty($data['name_error']) && empty($data['password_error']) && empty($data['confirm_password_error'])) {


                //hash the password before submitting to the database
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user (call model)
                if ($this->userModel->register($data)) {
                    flash('register_success', 'You are registered and can now login.');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                //load the view with errors
                $this->view('users/register', $data);
            }
        } else {
            //init data
            $data = [
                "name" => "",
                "email" => "",
                "password" => "",
                "confirm_password" => "",
                "name_error" => "",
                "email_error" => "",
                "password_error" => "",
                "confirm_password_error" => "",
            ];
            //load view
            $this->view('users/register', $data);
        }
    }
    //login Controller
    public function login()
    {
        //check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //sannitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            //init data
            $data = [
                'title' => 'Share Posts',
                'description' => 'Admin Backend - You must be logged in to view this page.',
                'canonical' => 'https://18004trucks.com',
                "email" => trim($_POST['email']),
                "password" => trim($_POST['password']),
                "email_error" => "",
                "password_error" => "",
            ];

            //validate email 
            if (empty($data['email'])) {
                $data['email_error'] = 'please enter an email...';
            }
            //validate email 
            if (empty($data['password'])) {
                $data['password_error'] = 'please enter a password to login...';
            }

            // Check for user/email
            if ($this->userModel->findUserByEmail($data['email'])) {
                // user found
            } else {
                $data['email_error'] = 'No user found..';
            }

            //make sure errors are empty
            if (empty($data['email_error']) && empty($data['password_error'])) {
                //validated
                //check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    //create session variables
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_error'] = 'Password is not valid..';
                    $this->view('users/login', $data);
                }
            } else {
                //load the view with errors
                $this->view('users/login', $data);
            }
        } else {
            //init Data
            $data = [
                'title' => 'cdtw ace',
                'description' => 'cdtwace Framework',
                'canonical' => 'https://cdtw.ca/cdtw-ace',
                "email" => "",
                "password" => "",
                "email_error" => "",
                "password_error" => "",
            ];

            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['group_id'] = $user->group_id;
        redirect('');
    }

    public function logout()
    {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_email']);
        session_destroy();
        redirect('users/login');
    }
}
