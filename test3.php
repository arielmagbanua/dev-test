<?php
require_once('include/utils.php');

/**
 * Simple method to generate a random employee id that
 * will not conflict with one already in the database
 */
function generate_id() {
	return rand(500000, 1000000);
}

/**
 * Methods available through utils.php
 *  - query - receives an SQL statement & executes it on
 *      the database, returning the result as an array of
 *      associative arrays
 *  - dump - receives an arbitrary number of arguments and
 *      dumps them to the screen using a formatted print_r
 *      and then exits
 */

// @TODO: Create your class here

class Employee{
    public $emp_no = '';
    public $first_name = '';
    public $last_name = '';
    public $birth_date = '';
    public $gender = '';
    public $hire_date = '';

    public function __construct(){

    }

    /**
     * @param string $emp_no
     */
    public function setEmpno($emp_no) {
        $this->emp_no = $emp_no;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName($first_name) {
        $this->first_name = $first_name;
    }

    /**
     * @param string $last_name
     */
    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    /**
     * @param string $birth_date
     */
    public function setBirthDate($birth_date) {
        $this->birth_date = $birth_date;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender) {
        $this->gender = $gender;
    }

    /**
     * @param string $hire_date
     */
    public function setHireDate($hire_date){
        $this->hire_date =  $hire_date;
    }

    public function retrieve($employeeNumber){
        $data = query("SELECT * FROM employees WHERE emp_no = '$employeeNumber'");
        if(is_array($data) && count($data) > 0){
            $employee = $data[0];

            $this->emp_no = $employee['emp_no'];
            $this->first_name = $employee['first_name'];
            $this->last_name = $employee['last_name'];
            $this->birth_date = $employee['birth_date'];
            $this->gender = $employee['gender'];
            $this->hire_date = $employee['hire_date'];
        }
    }

    public static function get($employeeNumber){
        $data = query("SELECT * FROM employees WHERE emp_no = '$employeeNumber'");

        $employee = new Employee();

        if(is_array($data) && count($data) > 0){
            $employeeData = $data[0];

            $employee->emp_no = $employeeData['emp_no'];
            $employee->first_name = $employeeData['first_name'];
            $employee->last_name = $employeeData['last_name'];
            $employee->birth_date = $employeeData['birth_date'];
            $employee->gender = $employeeData['gender'];
            $employee->hire_date = $employeeData['hire_date'];
        }

        return $employee;
    }

    public function save(){

        if(empty($this->emp_no)){
            $this->emp_no = generate_id();

            return query("INSERT INTO employees (emp_no, first_name, last_name, birth_date, gender, hire_date) VALUES('$this->emp_no', '$this->first_name', '$this->last_name', '$this->birth_date', '$this->gender', '$this->hire_date')");
        } else {
            return query("UPDATE employees SET first_name='$this->first_name', last_name='$this->last_name', birth_date='$this->birth_date', gender='$this->gender', hire_date='$this->hire_date' WHERE emp_no=$this->emp_no");
        }

    }
}

/**
 * Method: retrieve
 * Retrieve a record from the database and populate the object properties
 * @param integer employee_number an employees primary key emp_no to retrieve
 * @example
 * $employee = new Employee();
 * $employee->retrieve('10001');
 * echo "First name: " . $employee->first_name;
 */
// @todo - replace this comment with your retrieve method
// @todo - to generate a new primary key call the function generate_id()

$employee = new Employee();
$employee->retrieve('10001');
echo "First name: " . $employee->first_name;

/**
 * Method: save
 * Save a record to the employee database based on the current values of this
 * object's properties. For an insertion, assign a random number for the
 * emp_no property.
  * @example
 * $employee = new Employee();
 * $employee->retrieve('10001');
 * $employee->first_name = 'Bob';
  * $employee->save();
 */
// @todo - replace this comment with your save method
$employee = new Employee();
$employee->retrieve('10001');
$employee->first_name = 'Bob';
$employee->save();

// EXTRA FOR EXPERTS
/**
 * Static method: get
 * Static factory method to retrieve a requested employee from the database
 * and return a new Employee object populated with that employee data
 * @param integer employee_number an employees primary key emp_no to retrieve
 * @example
 * $bob = Employee::get('10001');
 * $bob->last_name = 'Peters';
 * $bob->save();
 */
// @todo - replace this comment with your static get method
$bob = Employee::get('10001');
$bob->last_name = 'Peters';
$bob->save();

/**
 * A method to test your class
 * PLEASE NOTE: You should not change any code below this line
 */
function test() {
    // clean up any past testing
    query("DELETE FROM employees WHERE first_name = 'Peter' AND last_name = 'Pan' AND birth_date = '2020-01-01'");

	// preset data to update employee record
	$data = [
		'emp_no' => 10001,
		'first_name' => 'Jane',
		'last_name' => 'Johnson',
		'birth_date' => '2015-01-01',
		'gender' => 'F',
		'hire_date' => '2017-05-05',
	];

	// retrieve employee 10001 and update all fields
	$employee = new Employee();
	$employee->retrieve('10001');
	foreach ($data as $property => $value) {
		$employee->$property = $value;
	}
	$employee->save();

	// re-retrieve the same employee & ensure the fields were correctly saved
	$check = new Employee();
	$check->retrieve('10001');
	if ((array)$check != $data) {
		fail("Data doesn't appear to have saved correctly");
	}

	// insert a new employee
    $data = [
        'first_name' => 'Peter',
        'last_name' => 'Pan',
        'birth_date' => '2020-01-01',
        'gender' => 'M',
        'hire_date' => '2025-05-05',
    ];

	$employee = new Employee();
    foreach ($data as $property => $value) {
        $employee->$property = $value;
    }

    $employee->save();

    // retrieve the new employee & ensure all fields set correctly
	$check = query("SELECT * FROM employees WHERE first_name = 'Peter' AND last_name = 'Pan' AND birth_date = '2020-01-01'");

	if (!is_array($check) || !$check[0]['emp_no']) {
		fail('New employee failed to save');
	}

	$check = $check[0];
	$data['emp_no'] = $check['emp_no'];
	if ($data != $check) {
		fail('New employee data not saved correctly');
	}
	pass('Tests passed. Congratulations, your class seems to be running well.');
}
test();

?>