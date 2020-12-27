<?php
function hashPassword($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function validateUpdate($email, $password)
{
    $errMsg = new stdClass();
    $errMsg->email = "";
    $errMsg->password = "";
    if ($email === "" && $password === ""){
        $errMsg->email = "Email or Password must be updated";
        $errMsg->password = "Email or Password must be updated";
        return $errMsg;
    }
    if ($email !== ""){
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errMsg->email = "Invalid Email";
        }
        if (strlen($email) > 30){
            $errMsg->email = "Email is too long";
        }
    }
    if ($password !== "") {
        if (empty($password) || strlen($password) < 6) {
            $errMsg->email = "Invalid Password";
        }
        if (strlen($password) > 30) {
            $errMsg->password = "Password is too long";
        }
    }
    return $errMsg;
}


$mysqli = new mysqli("localhost", "root", "", "TCH");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
$limit = intval($_GET['limit']);
$offset = intval($_GET['offset']);
$query = $mysqli->prepare("SELECT * FROM account LIMIT ? OFFSET ?");
$query->bind_param('ii', $limit, $offset);
$query->execute();
$result = $query->get_result();
$response = json_encode($result->fetch_all(MYSQLI_ASSOC));
echo $response;
$query->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST["type"] == 'UPDATE') {
    $id = intval($_POST["id"]);
    $email = $_POST["email"];
    $password = $_POST["password"];
    $errMsg = new stdClass();
    if (!is_int($id) || $id < 0) {
        $errMsg->message = "Invalid ID";
        http_response_code(400);
        $returnData = json_encode((array)$errMsg);
        echo $returnData;
        return;
    }
    $errMsg = validateUpdate($email, $password);
    if ($errMsg->email !== "" || $errMsg->password !== ""){
        $returnData = json_encode((array)$errMsg);
        echo $returnData;
        return;
    }
    if ($password !== ""){
        $password=hashPassword($password);
    }
    $query = $mysqli->prepare("UPDATE account SET email= CASE WHEN ? != '' THEN ? END, password= CASE WHEN ? != '' THEN ? END WHERE id= ?") ;
    $query->bind_param('ssssi', $email, $email, $password, $password, $id);
    $query->execute();
    $isUpdated = $query->affected_rows;
    $returnData = new stdClass();
    if ($isUpdated === 0){
        $returnData->message = "Nothing is updated";
        http_response_code(400);
        $returnData = json_encode((array)$returnData);
        echo $returnData;
        return;
    }
    $returnData->message = "Updated Successfully";
    http_response_code(200);
    $returnData = json_encode((array)$returnData);
    echo $returnData;
    return;
}