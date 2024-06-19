<?php
Trait AuthDAO
{
    use Database;
    
    private static function SQLoader($file)
    {
        $loader = new SQLoader();
        return $loader->loadSqlQuery($file);
    }

    public function Authenticate($data)
    {
        try{
            $query = self::SQLoader('Auth.sql');
            $params = [
                $data['idNumber'],
                $data['pass']
            ];            
            $result = $this->Query($query, $params);
            return $result;

        } catch(Exception $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        } catch(PDOException $e) {
            header('Content-Type: application/json');
            http_response_code($e->getCode());
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }
}