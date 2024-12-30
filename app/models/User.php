<?php 

class User{
    private $db;

    public function __construct(){
        //init database
        $this->db = new Database;
    }

    public function register($data){

        //create query
        $this->db->query('INSERT INTO users (name, email, password) VALUES(:name, :email, :password)');
        //bind value
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        //execute 
        if($this->db->execute()){
            //it worked!
            return true;

        }else{
            //something did not work
            return false;
        }
    }

    public function login($email, $password){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        $hashed_password = $row->password;
        if(password_verify($password, $hashed_password)){
            return $row;

        }else{
            return false;
        }

    }
    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email'); 
        $this->db->bind(':email', $email);
 
        $row = $this->db->single();
 
        //check row
        if($this->db->rowCount() > 0){
            return true;
 
        }else{
            return false;
        }
     }
 
     public function getUserById($id){
         $this->db->query('SELECT * FROM users WHERE id = :id');
         $this->db->bind(':id', $id);
         $row = $this->db->single();
         return $row;
 
     }
     public function getAllUsers(){
         $this->db->query('SELECT * FROM users');
         $row = $this->db->resultSet();
         return $row;
 
     }
}