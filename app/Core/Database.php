<?php

trait Database
{
    /**
     * @return PDO
     * @throws Exception
     * Connect to the database and return the connection
     * 
     */
    private function Connect()
    {
        $string = "pgsql:host=" . DBHOST . ";dbname=" . DBNAME . ";port=" . PORT;
        try {
            return new PDO($string, DBUSER, DBKEY);
        } catch (PDOException $e) {
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    private function errorHandler($mess)
    {
        $ex = new ExceptionHandler();
        $ex->setMessage($mess);
        
        return $ex->getMessage();
    }

    public function Query($query, $params = [])
    {
        $connection = $this->Connect();
        try {
            $stmt = $connection->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $result ?: []; // Always return an array, even if it's empty
        } catch (PDOException $e) {
            http_response_code(500); // Set a proper HTTP response code
            header('Content-Type: application/json'); // Indicate the content type is JSON
            $sweep = $this->errorHandler($e->getMessage());
            echo json_encode(['error' => $sweep]);
            exit;
        }
    }

    public function UpdateQuery($query, $params = [])
    {
        $connection = $this->Connect(); // Consider making this a reusable connection
        try {
            $stmt = $connection->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount(); // Return the number of rows affected
        } catch (PDOException $e) {
            // Log the error and potentially rethrow or handle it appropriately
            throw new Exception('Query execution failed: ' . $e->getMessage());
        }
    }

    public function DeleteQuery($query, $params = [])
    {
        $connection = $this->Connect(); // Consider making this a reusable connection
        try {
            $stmt = $connection->prepare($query);
            $stmt->execute($params);
            return $stmt->rowCount(); // Return the number of rows affected
        } catch (PDOException $e) {
            // Log the error and potentially rethrow or handle it appropriately
            throw new Exception('Query execution failed: ' . $e->getMessage());
        }
    }
}