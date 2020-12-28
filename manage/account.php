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
$query = $mysqli->prepare("SELECT id, email FROM account LIMIT ? OFFSET ?");
$query->bind_param('ii', $limit, $offset);
$query->execute();
$result = $query->get_result();
$response = json_encode($result->fetch_all(MYSQLI_ASSOC));
echo $response;
$query->close();
return;
}
$data = json_decode(file_get_contents('php://input'), true);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data["type"] == 'UPDATE') {
    $id = intval($data["id"]);
    $email = $data["email"];
    $password = $data["password"];
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
    if ($email !== "" && $password !== ""){
        $query = $mysqli->prepare("UPDATE account SET email= ?, password= ? WHERE id= ?") ;
        $query->bind_param('ssi', $email, $password, $id);
    } elseif ($email !== ""){
        $query = $mysqli->prepare("UPDATE account SET email= ? WHERE id= ?") ;
        $query->bind_param('si', $email, $id);
    } else {
        $query = $mysqli->prepare("UPDATE account SET password= ? WHERE id= ?") ;
        $query->bind_param('si', $password, $id);
    }
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $data["type"] == 'DELETE'){
    $id = intval($data["id"]);
    $errMsg = new stdClass();
    if (!is_int($id) || $id < 0) {
        $errMsg->message = "Invalid ID";
        http_response_code(400);
        $returnData = json_encode((array)$errMsg);
        echo $returnData;
        return;
    }
    $query = $mysqli->prepare("DELETE FROM account WHERE id=?");
    $query->bind_param('i', $id);
    $query->execute();
    $isDeleted = $query->affected_rows;
    $returnData = new stdClass();
    if ($isDeleted === 0) {
        $returnData->message = "Nothing is deleted";
        http_response_code(400);
        $returnData = json_encode((array)$returnData);
        echo $returnData;
        return;
    }
    $returnData->message = "Deleted Successfully";
    http_response_code(200);
    $returnData = json_encode((array)$returnData);
    echo $returnData;
    return;
}