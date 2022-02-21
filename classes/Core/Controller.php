<?php 

namespace App\Core;
use App\Core\Db;

class Controller {
    public $db;
    public function __construct() {
        $this->db = new Db();
    }

    public function init(){
        echo "Controller";
    }
}