<?php
Trait Model {

    use Database;

    public function Get($id, $table) { 
        try {
            // $this->validate($table);
            $query = "SELECT * FROM {$table}(:id); ";
            $params = [
                'id' => $id
            ];
            return $this->Query($query, $params);
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }

    public function GetAll($table) {
        try {
            $query = "SELECT * FROM {$table};";
            return $this->Query($query);
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        
        }
    }

    public function Delete($id, $table, $col) {
        try{
            $query = "DELETE FROM {$table} WHERE {$col} = :id";
            $params = [
                'id' => $id
            ];
            return $this->Query($query, $params);
        } catch(Exception $e) {
            echo 'Error: ' . $e->getMessage();
        } catch(PDOException $e) {
            echo 'PDO Error: ' . $e->getMessage();
        }
    }
}