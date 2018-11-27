<?php
require_once('include/utils.php');
require_once('include/smarty/Smarty.class.php');

// you can optionally use smarty templating if you know it
$smarty = new Smarty();

/**
 * Methods available through utils.php
 *  - query - receives an SQL statement & executes it on
 *      the database, returning the result as an array of
 *      associative arrays
 *  - dump - receives an arbitrary number of arguments and
 *      dumps them to the screen using a formatted print_r
 *      and then exits
 */

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="templates/styles.css" />
    <style>
        span.error{
            color: red;
        }
    </style>

    <?php
        // query employee
        $employee = '';
        $employeeNumber = '';
        $doesExist = false;

        if(isset($_GET['employee_number'])){
            $employeeNumber = $_GET['employee_number'];

            $employee = query("SELECT * FROM employees WHERE emp_no = ".$_GET['employee_number']);

            if(is_array($employee) && count($employee) > 0){
                $employee = $employee[0];
                $doesExist = true;
            }
        }
    ?>

</head>
<body>
    <!-- SECTION 1 -->
    <div id="edit-employee-container">
        <h2>Edit an employee</h2>

        <form action="/test1.php">
            <span>Employee Number: </span> <input id="employee_number" type="number" name="employee_number" value="<?php echo $employeeNumber?>">
            <button>Look Up</button>
            <span class="error">
                <?php if(!$doesExist && !empty($_GET['employee_number'])): ?>
                    Sorry - no employee matching that number was found. Please try again.
                <?php endif; ?>
            </span>
        </form>

        <?php if($doesExist && !empty($_GET['employee_number'])): ?>
            <div id="employee-container">
                <form action="test1-api.php" id="save-employee-form">
                    <input id="emp_no" type="text" name="emp_no" value="<?php echo $employee['emp_no']?>" hidden>
                    <span>First name </span> <input id="first_name" type="text" name="first_name" value="<?php echo $employee['first_name']?>" required> <br> <br>
                    <span>Last name </span> <input id="last_name" type="text" name="last_name" value="<?php echo $employee['last_name']?>" required> <br> <br>
                    <span>Birth date </span> <input id="birth_date" type="date" name="birth_date" value="<?php echo $employee['birth_date']?>" required> <br> <br>
                    <span>Gender </span>
                    <select id="gender" name="gender" required>
                        <option value="M" <?php echo $employee['gender'] == 'M' ? 'selected=selected' : '' ?>>Male</option>
                        <option value="F" <?php echo $employee['gender'] == 'F' ? 'selected=selected' : '' ?>>Female</option>
                    </select> <br> <br>
                    <span>Hire date </span> <input id="hire_date" type="date" name="hire_date" value="<?php echo $employee['hire_date']?>" required> <br> <br>
                    <button type="submit" id="save-employee">Save</button>
                </form>

                <div id="result-container">
                    <span id="update-result">

                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#save-employee-form').submit(function(event){
                event.preventDefault();

                let api = $(this).attr('action');

                let empNo = $('#emp_no').val();
                let firstName = $('#first_name').val();
                let lastName = $('#last_name').val();
                let birthDate = $('#birth_date').val();
                let gender = $('#gender').val();
                let hireDate = $('#hire_date').val();

                console.log(empNo);
                console.log(firstName);
                console.log(lastName);
                console.log(birthDate);
                console.log(gender);
                console.log(hireDate);

                let apiURL = window.location.protocol + '//' + window.location.host + '/' + api;
                console.log(apiURL);

                let payload = {
                    emp_no: empNo,
                    first_name: firstName,
                    last_name: lastName,
                    birth_date: birthDate,
                    gender: gender,
                    hire_date: hireDate
                };

                let formBody = [];
                for (let property in payload) {
                    let encodedKey = encodeURIComponent(property);
                    let encodedValue = encodeURIComponent(payload[property]);
                    formBody.push(encodedKey + "=" + encodedValue);
                }

                formBody = formBody.join("&");

                // Use the Promise base fetch api
                fetch(apiURL, {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    // body: JSON.stringify(payload)
                    body: formBody
                }).then(response => response.json()).then(data => {
                    console.log('success!');
                    console.log(data);

                    let updateResult = $('#update-result');
                    updateResult.html('Employee has been successfully updated!!!');
                    updateResult.css('color', '#00FF00');
                }).catch(error => {
                    console.log(error);
                    let updateResult = $('#update-result');
                    updateResult.html('Something\'s wrong!!!');
                    updateResult.css('color', '#FF0000');
                });
            });
        });
    </script>
</body>
</html>