<?php 

namespace App;

class Dispatch {
    public function __construct() {}

    public function init(){
        $this->buildUrl();
    }

    public function buildUrl(){
        $url_dump = explode("/", $_SERVER['REQUEST_URI']);

        if (isset($url_dump[1]) && $url_dump[1] != '') {
            switch ($url_dump[1]) {
                case 'admin':
                    // new Dashboard();
                    break;
                case 'user':
                    $user = new \App\Api\User();
                    if (isset($url_dump[2]) && $url_dump[2] != '') {
                        $func = explode('?', $url_dump[2]);
                        $func = $func[0];
                        $user->$func();
                    }
                    break;
            }
        }
    }
    
}