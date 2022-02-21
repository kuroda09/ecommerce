<?php 

namespace App\Core;

class Db {

    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'ecommerce';

    public $conn;

    public $last_id;

    public function __construct() {
        $this->conn = new \mysqli($this->host,$this->user,$this->password,$this->dbname);
    }

    public function insert($tablename,$data = []){
        $keys = '';
        $vals = '';
        $count = count($data);
        $i = 0;
        foreach($data as $key => $item) {
            if(++$i != $count) {
                $keys .= $key.",";
                $vals .= $item.",";
            } else {
                $keys .= $key;
                $vals .= $item;
            }
        }

        $sql = "
            INSERT INTO {$tablename}({$keys}) VALUES({$vals})
        ";
        $this->conn->query($sql);
        if ($this->conn->error) {
            print_r($this->conn->error);
        } else {
          $this->last_id = $this->conn->insert_id;
        }
    }

    public function create($tablename,$data = []){
        $str = '';
        $count = count($data);
        $i = 0;
        foreach($data as $key => $item) {
            if(++$i != $count) {
                $str .= $key.' '.$item.",";
            } else {
                $str .= $key.' '.$item;
            }
        }

        $sql = "
            CREATE TABLE IF NOT EXISTS {$tablename} ({$str})
        ";
        $this->conn->query($sql);
        if ($this->conn->error) {
            print_r($this->conn->error);
        }
    }

    public function query($sql){
        $this->conn->query($sql);
    }
}