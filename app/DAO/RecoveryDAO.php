<?php

Trait RecoveryDAO
{
    use Database;

    public function resetPassword($id, $dob, $new_pass, $confirm_pass)
    {
        $query = 'call forgot_pass(:id, :dob, :new_pw, :confirm_pw)';
        $params = [
            'id' => $id,
            'dob' => $dob,
            'new_pw' => $new_pass,
            'confirm_pw' => $confirm_pass
        ];
        $result = $this->query($query, $params);
        return $result;
    }

    public function validateToken($token)
    {
        $query = 'SELECT check_token(:token)';
        $params = ['token' => $token];
        $result = $this->query($query, $params);
        return $result;
    }

    public function validateEmail($email)
    {
        $query = 'SELECT * FROM scan_email(:email)';
        $params = ['email' => $email];
        $result = $this->query($query, $params);
        return $result;
    }
}
