<?php
require_once __DIR__ . "/../../DAO/RecoveryDAO.php";
require_once __DIR__ . "/../../Models/EmployeeModel.php";
class ResetPasswordModel
{
    private $new_pass = '';
    private $confirm_pass = '';
    private $id = '';
    private $dob = '';

    use RecoveryDAO;

    /**
     * This method fetches the result of the reset password operation.
     * @return mixed
     */
    public function fetchResetPasswordResult()
    {
        try {
            $this->checkPassMatch();
            $result = $this->resetPassword($this->id, $this->dob, $this->new_pass, $this->confirm_pass);
            return $result;
        } catch(Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    private static function checkNull($param, $field)
    {
        if(!isset($param)) {
            throw new Exception("Please enter your {$field}.", 500);
        }
    }

    public function checkPassMatch()
    {
        if ($this->new_pass !== $this->confirm_pass) {
            throw new Exception("Password do not match.");
        }
    }

    public function setNewPass($new_pass)
    {
        $sanitize = new Sanitation();
        $sanitize_pass = $sanitize->strSanitation($new_pass);
        ResetPasswordModel::checkNull($sanitize_pass, 'New Password');
        $this->new_pass = $new_pass;
    }

    public function setConfirmPass($confirm_pass)
    {
        $sanitize = new Sanitation();
        $sanitize_pass = $sanitize->strSanitation($confirm_pass);
        ResetPasswordModel::checkNull($sanitize_pass, 'Confirmation Password');
        $this->confirm_pass = $confirm_pass;
    }

    public function setID($id)
    {
        $sanitize = new Sanitation();
        $sanitize_id = $sanitize->strSanitation($id);
        ResetPasswordModel::checkNull($sanitize_id, 'ID');
        $this->id = $id;
    }

    public function setDOB($dob)
    {
        $sanitize = new Sanitation();
        $sanitize_dob = $sanitize->strSanitation($dob);
        ResetPasswordModel::checkNull($sanitize_dob, 'Date of Birth');
        $this->dob = $dob;
    }

    public function getID()
    {
        return $this->id;
    }

    public function getDOB()
    {
        return $this->dob;
    }

    public function getNewPass()
    {
        return $this->new_pass;
    }

    public function getConfirmPass()
    {
        return $this->confirm_pass;
    }

}