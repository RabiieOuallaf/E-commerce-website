<?php 

    require_once '../core/Database.php';
    require_once '../config/config.php';
    require_once '../helpers/url_helpers.php';

    class User {

        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        // Register 

        public function register($data){
            $this->db->query('INSERT INTO admins (user_username ,user_password ,user_email) VALUES (:username, :password, :email)');

            $this->db->bind(':username' , $data['FName']);
            $this->db->bind(':password', $data['Password']);
            $this->db->bind(':email', $data['Email']);

            // Execute 

            if($this->db->execute()){

                return true;

            }else {
                
                return false;
            }
        }

        public function Login($email, $password){

            $this->db->query("SELECT * FROM users WHERE user_email = :email AND user_password = :pwd");
            $this->db->bind(':email', $email);
            $this->db->bind(':pwd', $password);

            $row = $this->db->single();
        
            $hashed_password = $row->password;

            if($row){
                return $row;
            } else {
                return false;
            }
        }

        // Find user by email 

        public function findUserByEmail($email) {

            $this->db->query("SELECT * FROM users WHERE email = :email");
            $this->db->bind(':email', $email);

            $row = $this->db->single();

            // Check rows 

            if($this->db->rowCount() > 0){

                return $row;

            }else {
                return false;
            }
        }

    }