<?php
$mysqli = new mysqli("localhost", "root", "", "TCH");
session_start();
// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function validateRegister($email, $password)
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
        $errMsg->password = "Invalid Password";
    }
    if (strlen($password) > 30){
        $errMsg->password = "Password is too long";
    }
    return $errMsg;
}

$email = $_POST["email"];
$password = $_POST["password"];
$errMsg = validateRegister($email, $password);
if ($errMsg->email !== "" || $errMsg->password !== ""){
    $returnData = json_encode((array)$errMsg);
    echo $returnData;
    return;
}
$query = $mysqli->prepare("SELECT * FROM account WHERE email=?" );
$query->bind_param("s",$email);
$message = $query->execute();
$res = $query->get_result();
$user = $res->fetch_object();
$returnData = new stdClass();
if(password_verify($password,$user->password)){
    $_SESSION['account_id'] = $user->id;
    http_response_code(200);
    $returnData->message = "Login successfully!";
    $returnData = json_encode((array)$returnData);
    echo $returnData;
    return;
} else{
    http_response_code(400);
    $returnData->message = "Wrong email or password!";
    $returnData = json_encode((array)$returnData);
    echo $returnData;
    return;
}