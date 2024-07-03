<?php

final class RecoveryDAO
{
    use Database;

    public function validateEmail($email)
    {
        $query = 'SELECT scan_email(:email)';
        $params = ['email' => $email];
        $result = $this->query($query, $params);
        return $result;
    }
}
