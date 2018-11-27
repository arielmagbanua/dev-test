<html>
<head>
	<link rel="stylesheet" type="text/css" href="templates/styles.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php
require_once('include/utils.php');
require_once('include/smarty/Smarty.class.php');

/**
 * Methods available through utils.php
 *  - query - receives an SQL statement & executes it on
 *      the database, returning the result as an array of
 *      associative arrays
 *  - dump - receives an arbitrary number of arguments and
 *      dumps them to the screen using a formatted print_r
 *      and then exits
 */

// you can optionally use smarty templating if you know it
$smarty = new Smarty();


// @TODO: Insert your code here

$query1 = query("SELECT * FROM employees WHERE MONTH(birth_date) = 3 ORDER BY birth_date DESC LIMIT 100");
$query2 = query("SELECT e.*, departments.dept_name, dept_emp.from_date AS served_from, dept_emp.to_date AS served_to FROM employees e
INNER JOIN dept_emp ON dept_emp.emp_no = e.emp_no
INNER JOIN departments ON departments.dept_no = dept_emp.dept_no
WHERE departments.dept_no = 'd009' OR departments.dept_no = 'd002'
ORDER BY departments.dept_name, dept_emp.from_date ASC LIMIT 100");
$query3 = query("SELECT e.*, salaries.salary, titles.title FROM employees e
INNER JOIN titles ON titles.emp_no = e.emp_no
INNER JOIN salaries ON salaries.emp_no = e.emp_no
WHERE DATE(hire_date) <= DATE('1988-03-03')
AND (DATE('1988-03-03') >= DATE(titles.from_date) AND DATE('1988-03-03') <= DATE(titles.from_date))
AND (DATE('1988-03-03') >= DATE(salaries.from_date) AND DATE('1988-03-03') <= DATE(salaries.from_date))
LIMIT 100")


?>

<h1>1</h1>
<table>
    <thead>
        <th>No.</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Birth Date</th>
        <th>Hire Date</th>
    </thead>
    <tbody>
    <?php foreach ($query1 as $employee): ?>
        <tr>
            <td><?php echo $employee['emp_no']?></td>
            <td><?php echo $employee['first_name']?></td>
            <td><?php echo $employee['last_name']?></td>
            <td><?php echo $employee['gender']?></td>
            <td><?php echo $employee['birth_date']?></td>
            <td><?php echo $employee['hire_date']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<hr>

<h1>2</h1>
<table>
    <thead>
    <th>No.</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Gender</th>
    <th>Birth Date</th>
    <th>Hire Date</th>
    <th>Department Name</th>
    <th>Served From</th>
    <th>Served To</th>
    </thead>
    <tbody>
    <?php foreach ($query2 as $employee): ?>
        <tr>
            <td><?php echo $employee['emp_no']?></td>
            <td><?php echo $employee['first_name']?></td>
            <td><?php echo $employee['last_name']?></td>
            <td><?php echo $employee['gender']?></td>
            <td><?php echo $employee['birth_date']?></td>
            <td><?php echo $employee['hire_date']?></td>
            <td><?php echo $employee['dept_name']?></td>
            <td><?php echo $employee['served_from']?></td>
            <td><?php echo $employee['served_to']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<hr>

<h1>3</h1>
<table>
    <thead>
        <th>No.</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Gender</th>
        <th>Birth Date</th>
        <th>Hire Date</th>
        <th>Salary</th>
        <th>Title</th>
    </thead>
    <tbody>
    <?php foreach ($query3 as $employee): ?>
        <tr>
            <td><?php echo $employee['emp_no']?></td>
            <td><?php echo $employee['first_name']?></td>
            <td><?php echo $employee['last_name']?></td>
            <td><?php echo $employee['gender']?></td>
            <td><?php echo $employee['birth_date']?></td>
            <td><?php echo $employee['hire_date']?></td>
            <td><?php echo $employee['salary']?></td>
            <td><?php echo $employee['title']?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>


</body>
</html>