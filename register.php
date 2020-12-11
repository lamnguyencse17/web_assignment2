<?php
function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function validateRegister($email, $password)
{
    $errMsg = new stdClass();
    $errMsg->email = "";
    $errMsg->email = "";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errMsg->email = "Invalid Email";
    }
    if (empty($password) || strlen($password) < 6) {
        $errMsg->email = "Invalid Password";
    }
    return $errMsg;
}

$email = $_POST["email"];
$password = $_POST["password"];
$errMsg = validateRegister($email, $password);
if ($errMsg->email !== "" || $errMsg->password !== ""){
    $errMsg->message->email = $errMsg->email;
    $errMsg->message->password = $errMsg->password;
    $returnData = json_encode((array)$errMsg);
    echo $returnData;
    return;
}
