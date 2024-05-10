<?php
require "Interface/DatabaseInterface.php";

class Model implements DatabaseInterface {

    use Database;
    protected $table = 'Account';
    protected $id;
    protected $password;
    
    
    private function allowedTables() {
        return [
            'Account'
        ];
    }

    private function validate() {
        if (!in_array($this->table, $this->allowedTables())) {
            throw new Exception('Invalid table name');
        }
    }

    public function Get() { 
        $this->validate();
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $params = [
            'id' => $this->id
        ];
        return $this->Query($query, $params);
    }

    public function GetAll() {
        // Method implementation
    }

    public function Insert() {
        // Method implementation
    }

    public function Update() {
        // Method implementation
    }

    public function Delete() {
        // Method implementation
    }
}