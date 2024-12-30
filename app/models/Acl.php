<?php
class Acl
{
    private $db;
    private $user_empty = false;
    var $permission;
    var $userid;
    var $group_id;

    public function __construct()
    {
        //init database
        $this->db = new Database;
    }
    public function setter($permission, $userid, $group_id){
        
        $this->permission = $permission;
        $this->userid = $userid;
        $this->group_id = $group_id;
    }


    public function check()
    {
       
        //we check the user permissions first
        if (!$this->user_permissions()) {
            return false;
        }
        if (!$this->group_permissions() && $this->IsUserEmpty()) {

            return false;
        }

        return true;
    }

    public function user_permissions()
    {
        // Make a database query to check if the $permission and $userid match a entry in the user_permissions dataase table.
        $this->db->query("SELECT COUNT(*) AS count FROM user_permissions WHERE permission_name='$this->permission' AND userid='$this->userid' ");
        // We set a value of count in the $row array. This is the count of how many matches in the database we had with the query above.
        $row = $this->db->resultSet();
        //Ensure the $row[0]->count is a integer (number)
        (int) $row[0]->count;
        //if "$row[0]->count" = 0, then the user does not have that permission assigned. if "$row[0]->count" = 1, then user has permission assigned.
        if ($row[0]->count > 0) {
            //Now we know the user has the permission assigned, lets check if it has been disabled for what ever reason.
            //Make a new databse query and this time assign $row[0] as an array with all the query data. (The matched entry using $permission & $userid) 
            $this->db->query("SELECT * FROM user_permissions WHERE permission_name='$this->permission' AND userid='$this->userid' ");

            $row = $this->db->resultSet();
            //Ensure $row[0]->permission_type is set to an integer (number)
            (int) $row[0]->permission_type;
            // If permission type is 0 then user does not have access
            if ($row[0]->permission_type == 0) {
                return false;
            }

            return true;
        }
        $this->setUserEmpty('true');

        return false;
    }
    public function group_permissions()
    {
        $this->db->query("SELECT COUNT(*) AS count FROM group_permissions WHERE permission_name='$this->permission' AND group_id='$this->group_id' ");

        $row = $this->db->resultSet();

        if ($row[0]->count > 0) {
            $this->db->query("SELECT * FROM group_permissions WHERE permission_name='$this->permission' AND group_id='$this->group_id' ");

            $row = $this->db->resultSet();
            (int) $row[0]->permission_type;

            if ($row[0]->permission_type == 0) {
                return false;
            }

            return true;
        }

        return false;
    }


    public function setUserEmpty($val)
    {
        $this->user_empty = $val;
    }

    public function isUserEmpty()
    {
        return $this->user_empty;
    }
}
