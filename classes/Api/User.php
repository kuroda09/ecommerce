<?php 

namespace App\Api;
use App\Core\Db;

class User {
    private $db;
    public function __construct($id_user = null) {
        $this->db = new Db();
        $this->createUserTables();
    }

    public function createUserTables(){
        $this->db->create('user',
            [
                'id_user'=>'int(7) PRIMARY KEY AUTO_INCREMENT',
                'username'=>'varchar(255) NOT NULL',
                'password'=>'varchar(255) NOT NULL',
                'email'=>'varchar(255) NOT NULL',
                'first_name'=>'varchar(255) NOT NULL',
                'last_name'=>'varchar(255) NOT NULL',
                'is_active'=>'int(1) NOT NULL DEFAULT 1',
                'verification_code'=>'varchar(255) NULL',
                'date_added'=>'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
                'date_modified'=>'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
            ]
        );

        $this->db->create('user_meta',
            [
                'id_user int(7)'=>'PRIMARY KEY AUTO_INCREMENT',
                'user_id int(7)'=>'NOT NULL',
                'contact_number'=>'varchar(255) NOT NULL',
                'date_added'=>'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
                'date_modified'=>'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
                'user_role int(7)'=>'NOT NULL DEFAULT 4'
            ]
        );

        $this->db->query('
            ALTER TABLE user_meta
            ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES user(id_user);
        ');
    }

    public function createUser(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $allowed_fields = array('username','password','email','first_name','last_name');
            if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['first_name']) && isset($_POST['last_name'])) {

                // check if datas are correct
                $is_valid = 1;
                foreach ($_POST as $key => $value) {
                    if (!in_array($key, $allowed_fields)) {
                        $is_valid = 0;
                    }
                }
                // if valid, continue with creating user | else, throw an error
                if ($is_valid == 1) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $email = $_POST['email'];
                    $first_name = $_POST['first_name'];
                    $last_name = $_POST['last_name'];
                    $this->db->insert('user',
                        [
                            'username'=>"'{$username}'",
                            'password'=>"'{$password}'",
                            'email'=>"'{$email}'",
                            'first_name'=>"'{$first_name}'",
                            'last_name'=>"'{$last_name}'"
                        ]
                    );
                    $this->db->insert('user_meta',
                        [
                            'user_id'=>$this->db->last_id,
                            'contact_number'=>'""'
                        ]
                    );
                } else {
                    die("Incorrect Data!");
                }
            } else {
                die("Empty Fields!");
            }
        }
    }
}