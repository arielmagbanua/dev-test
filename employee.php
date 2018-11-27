<?php
/**
 * Created by PhpStorm.
 * User: Ariel
 * Date: 28/11/2018
 * Time: 12:29 AM
 */

class EmployeeHelper
{
    private $mysqliDB = null;

    private $employeeNumber = '';
    private $firstName = '';
    private $lastName = '';
    private $birthDate = '';
    private $genter = '';
    private $hireDate = '';

    /**
     * Employee constructor.
     * @param string $employeeNumber
     * @param string $firstName
     * @param string $lastName
     * @param string $birthDate
     * @param string $genter
     * @param string $hireDate
     */
    public function __construct($employeeNumber, $firstName, $lastName, $birthDate, $genter, $hireDate) {
        $this->employeeNumber = $employeeNumber;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->genter = $genter;
        $this->hireDate = $hireDate;
    }

    /**
     * @param null $mysqliDB
     */
    public function setMysqliDB($mysqliDB) {
        $this->mysqliDB = $mysqliDB;
    }

    /**
     * @param string $employeeNumber
     */
    public function setEmployeeNumber($employeeNumber) {
        $this->employeeNumber = $employeeNumber;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @param string $birthDate
     */
    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    /**
     * @param string $genter
     */
    public function setGenter($genter) {
        $this->genter = $genter;
    }

    /**
     * @param string $hireDate
     */
    public function setHireDate($hireDate) {
        $this->hireDate = $hireDate;
    }

    /**
     * Escape for protection
     */
    private function escapeFields(){
        if(!is_null($this->mysqliDB)){
            $this->employeeNumber = mysqli_real_escape_string($this->mysqliDB, $this->employeeNumber);
            $this->firstName =  mysqli_real_escape_string($this->mysqliDB, $this->firstName);
            $this->lastName = mysqli_real_escape_string($this->mysqliDB, $this->lastName);
            $this->birthDate = mysqli_real_escape_string($this->mysqliDB, $this->birthDate);
            $this->genter = mysqli_real_escape_string($this->mysqliDB, $this->genter);
            $this->hireDate = mysqli_real_escape_string($this->mysqliDB, $this->hireDate);
        }
    }

    /**
     * Update
     *
     * @return array
     */
    public function update() {
        $this->escapeFields();

        $result = $this->mysqliDB->query("UPDATE employees SET first_name='$this->firstName', last_name='$this->lastName', birth_date='$this->birthDate', gender='$this->genter', hire_date='$this->hireDate' WHERE emp_no=$this->employeeNumber");

        if (!is_object($result)) {
            return $result;
        }

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}