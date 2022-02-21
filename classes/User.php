<?php 

namespace App;

class User extends Core\Controller {
    public function __construct() {
        parent::__construct();
        $this->init();
    }

    public function init(){
        parent::init();
        echo $this->db;
    }
}


// $arr = [
//     'id_user' => 'int(7) PRIMARY KEY AUTO_INCREMENT',
//     'name' => 'VARCHAR(255) NOT NULL',
//     'email' => 'VARCHAR(255) NOT NULL',
//     'password' => 'VARCHAR(255) NOT NULL',
// ];
// $this->db->create('user',$arr);