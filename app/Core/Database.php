<?php

Trait Database {
    private function Connect() {
        $string = "pgsql:host=".DBHOST.";dbname=".DBNAME.";port=".PORT;
        try {
            return new PDO($string,DBUSER,DBKEY);
        } catch (PDOException $e) {
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    public function Query($query, $params = []) {
        try {
            $stmt = $this->Connect()->prepare($query);
            $check = $stmt->execute($params);
    
            if($check) {
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);
                if(is_array($result) && count($result)) {
                    print_r($result);
                }
            }
            return false;
        } catch(PDOException $e) {
            // Handle PDOException
            echo 'PDO Connection error: ' . $e->getMessage();
        } catch(Exception $e) {
            // Handle connection exception
            echo 'Connection error: ' . $e->getMessage();
        }

    }
}