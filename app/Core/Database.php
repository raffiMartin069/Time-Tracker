<?php

Trait Database {
    private function Connect() {
        $string = "mysql:host=".DBHOST.";dbname=".DBNAME;
        return new PDO($string,DBUSER,DBKEY);
    }

    public function Query($query, $params = []) {
        $stmt = $this->Connect()->prepare($query);
        $check = $stmt->execute($params);

        if($check) {
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if(is_array($result) && count($result)) {
                print_r($result);
            }
        }
        return false;
    }
}