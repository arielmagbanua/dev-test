<?php
require_once('include/utils.php');
require_once('employee.php');

/**
 * Methods available through utils.php
 *  - query - receives an SQL statement & executes it on
 *      the database, returning the result as an array of
 *      associative arrays
 *  - dump - receives an arbitrary number of arguments and
 *      dumps them to the screen using a formatted print_r
 *      and then exits
 */

// dump($_REQUEST);

$response = [
    'status' => 'ok'
];

$employeeNumber = '';
$firstName = '';
$lastName = '';
$birthDate = '';
$gender = '';
$hireDate = '';

//echo  isset($_POST['first_name']);
//exit(200);

if(isset($_POST['emp_no']) && !empty($_POST['emp_no'])){
    $employeeNumber = $_POST['emp_no'];
}

if(isset($_POST['first_name']) && !empty($_POST['first_name'])){
    $firstName = $_POST['first_name'];
} else {
    $response['status'] = 'error';
    $response['message'] = 'First name missing or empty!';

    echo json_encode($response);
    exit(400);
}

if(isset($_POST['last_name']) && !empty($_POST['last_name'])){
    $lastName = $_POST['last_name'];
} else {
    $response['status'] = 'error';
    $response['message'] = 'Last name missing or empty!';

    echo json_encode($response);
    exit(400);
}

if(isset($_POST['birth_date']) && !empty($_POST['birth_date'])){
    $birthDate = $_POST['birth_date'];
} else {
    $response['status'] = 'error';
    $response['message'] = 'Birth date missing or empty!';

    echo json_encode($response);
    exit(400);
}

if(isset($_POST['gender']) && !empty($_POST['gender'])){
    $gender = $_POST['gender'];
} else {
    $response['status'] = 'error';
    $response['message'] = 'Gender missing or empty!';

    echo json_encode($response);
    exit(400);
}

if(isset($_POST['hire_date']) && !empty($_POST['hire_date'])){
    $hireDate = $_POST['hire_date'];
} else {
    $response['status'] = 'error';
    $response['message'] = 'Hire date missing or empty!';

    echo json_encode($response);
    exit(400);
}

$employee = new EmployeeHelper($employeeNumber, $firstName, $lastName, $birthDate, $gender, $hireDate);
$employee->setMysqliDB($mysqli_db);
$result = $employee->update();

$response['result'] = $result;

echo json_encode($response);
exit(200);

//$json = '{"foo-bar": 12345}';
//
//$obj = json_decode($json);
//
//echo $json;