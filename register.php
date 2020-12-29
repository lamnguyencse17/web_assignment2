<?php
$mysqli = new mysqli("localhost", "root", "", "TCH");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function validateRegister($email, $password, $confirm_password)
{
    $errMsg = new stdClass();
    $errMsg->email = "";
    $errMsg->password = "";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errMsg->email = "Invalid Email";
    }
    if (strlen($email) > 30){
        $errMsg->email = "Email is too long";
    }
    if (empty($password) || strlen($password) < 6) {
        $errMsg->email = "Invalid Password";
    }
    if (strlen($password) > 30){
        $errMsg->password = "Password is too long";
    }
    if($confirm_password != $password){
        $errMsg->password = "Confirmed password did not match";
    }
    return $errMsg;
}

$email = $_POST["email"];
$password = $_POST["psswrd"];
$confirm_password = $_POST["confirm_psswrd"];
$errMsg = validateRegister($email, $password, $confirm_password);
if ($errMsg->email !== "" || $errMsg->password !== ""){
    $returnData = json_encode((array)$errMsg);
    echo "<script>
    alert('Check Your Email Or Password');
    window.location.href='register.html';
    </script>";
}
$password=hashPassword($password);
$query = $mysqli->prepare("insert into tch.account(email, password) values (?, ?)") ;
$query->bind_param("ss", $email, $password);
$message = $query->execute();
$returnData = new stdClass();

if ($message === true){
    http_response_code(201);
//    $returnData->message = "Successfully registered";
//    $returnData = json_encode((array)$returnData);
    // echo $returnData;
    // return;
    echo "<script>
    alert('Successfully registered');
    window.location.href='login.html';
    </script>";
}
http_response_code(400);
$returnData->message = "Email is duplicated";
$returnData = json_encode((array)$returnData);
// echo $returnData;
// return;
echo "<script>
    alert('$returnData');
    window.location.href='register.html';
    </script>";