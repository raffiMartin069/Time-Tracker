<?php
require_once __DIR__ . '/Interface/LoginInterface.php';
require_once __DIR__ . "/../DAO/AdminDAO.php";
final class EmployeeModel
{

    use AdminDAO;

    private $ID;
    private $FIRST_NAME;
    private $LAST_NAME;
    private $MIDDLE_NAME;
    private $EMAIL;
    private $DOB;
    private $POSITION;
    private $HIRE_DATE;
    private $EMPLOYMENT_TYPE;
    private $WORKING_HOURS;
    private $CONTACT;
    private $ROLE;
    private $SHIFT;
    private $TYPE;

    public function getAllEmployee()
    {
        try {
            $result = $this->fetchAllEmployee();
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function addNewEmployee() 
    {
        try {
            $result = $this->insertNewEmployee($this->prepareAddEmployee());
            return $result;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private function prepareAddEmployee()
    {
        $data = [
            'lname' => $this->getLastName(),
            'mname' => $this->getMiddleName() === 'temp' ? null : $this->getMiddleName(),
            'fname' => $this->getFirstName(),
            'dob' => $this->getDOB(),
            'hireDate' => $this->getHireDate(),
            'email' => $this->getEmail(),
            'contact' => $this->getCONTACT(),
            'role' => $this->getROLE(),
            'shift' => $this->getSHIFT(),
            'type' => $this->getTYPE()
        ];
        return $data;
    }

    public function getTYPE()
    {
        return $this->TYPE;
    }

    public function setTYPE($TYPE)
    {
        $this->TYPE = $TYPE;
        return $this;
    }

    public function getSHIFT()
    {
        return $this->SHIFT;
    }
    public function setSHIFT($SHIFT)
    {
        $this->SHIFT = $SHIFT;
        return $this;
    }
    public function getROLE()
    {
        return $this->ROLE;
    }
    public function setROLE($ROLE)
    {
        $this->ROLE = $ROLE;
        return $this;
    }

    public function getCONTACT()
    {
        return $this->CONTACT;
    }
    public function setCONTACT($CONTACT)
    {
        $this->CONTACT = $CONTACT;
        return $this;
    }

    public function getID()
    {
        return $this->ID;
    }
    public function setID($ID)
    {
        $this->ID = $ID;
        return $this;
    }
    public function getFirstName()
    {
        return $this->FIRST_NAME;
    }
    public function setFirstName($FIRST_NAME)
    {
        $this->FIRST_NAME = $FIRST_NAME;
        return $this;
    }
    public function getLastName()
    {
        return $this->LAST_NAME;
    }
    public function setLastName($LAST_NAME)
    {
        $this->LAST_NAME = $LAST_NAME;
        return $this;
    }
    public function getMiddleName()
    {
        return $this->MIDDLE_NAME;
    }
    public function setMiddleName($MIDDLE_NAME)
    {
        $this->MIDDLE_NAME = $MIDDLE_NAME;
        return $this;
    }
    public function getEmail()
    {
        return $this->EMAIL;
    }
    public function setEmail($EMAIL)
    {
        $this->EMAIL = $EMAIL;
        return $this;
    }
    public function getDOB()
    {
        return $this->DOB;
    }
    public function setDOB($DOB)
    {
        $this->DOB = $DOB;
        return $this;
    }
    public function getPosition()
    {
        return $this->POSITION;
    }

    public function setPosition($POSITION)
    {
        $this->POSITION = $POSITION;
        return $this;
    }
    public function getHireDate()
    {
        return $this->HIRE_DATE;
    }
    public function setHireDate($HIRE_DATE)
    {
        $this->HIRE_DATE = $HIRE_DATE;
        return $this;
    }
    public function getEmploymentType()
    {
        return $this->EMPLOYMENT_TYPE;
    }
    public function setEmploymentType($EMPLOYMENT_TYPE)
    {
        $this->EMPLOYMENT_TYPE = $EMPLOYMENT_TYPE;
        return $this;
    }
    public function getWorkingHours()
    {
        return $this->WORKING_HOURS;
    }
    public function setWorkingHours($WORKING_HOURS)
    {
        $this->WORKING_HOURS = $WORKING_HOURS;
        return $this;
    }
}
