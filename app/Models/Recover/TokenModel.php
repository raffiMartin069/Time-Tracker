<?php
require_once __DIR__ . "/../../DAO/RecoveryDAO.php";
/**
 * TokenModel
 * This class is used for recovery tokens from database.
 * This will confirm and validate the token.
 */
class Token {
    use RecoveryDAO;

    private $token = '';

    public function getToken() 
    {
        return $this->token;
    }

    public static function checkNull($token)
    {
        if(!isset($token)) {
            throw new Exception("Please enter your Access Token.");
        }
    }

    /**
     * Clean token before using it.
     */
    public function setToken($token) 
    {
        $sanitize = new Sanitation();
        $sanitize_token = $sanitize->strSanitation($token);
        Token::checkNull($sanitize_token); // Check if token is empty or not.
        $this->token = $sanitize_token;
    }

    /**
     * @method confirmToken
     * @return bool
     * This method invokes Recovery Data Object Access (RecoveryDAO) for database query.
     */
    public function confirmToken()
    {
        Token::checkNull($this->token);
        $db_result = $this->validateToken($this->token);
        foreach($db_result as $result) {
            $access_token = $result->check_token;
        }
        if(!$access_token) {
            throw new Exception("Invalid Access Token.");
        }
        return $access_token;
    }
}